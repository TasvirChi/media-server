package com.borhan.media.server;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.SocketException;
import java.net.UnknownHostException;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;
import java.util.Map;
import java.util.Timer;
import java.util.TimerTask;

import org.apache.log4j.Logger;

import com.borhan.client.BorhanClient;
import com.borhan.client.BorhanConfiguration;
import com.borhan.client.enums.BorhanSessionType;
import com.borhan.media.server.api.IWebService;
import com.borhan.media.server.api.BorhanWebServicesServer;
import com.borhan.media.server.managers.IManager;

public class BorhanServer {
	public static int MEDIA_SERVER_PARTNER_ID = -5;

	public final static String BORHAN_SERVER_SECRET_KEY = "BorhanServerSecretKey";

	// use the same session key for all Wowza sessions, so all (within a DC) will be directed to the same sphinx to prevent synchronization problems
	private final static String BORHAN_PERMANENT_SESSION_KEY = "borhanWowzaPermanentSessionKey";
	
	protected final static String BORHAN_SERVER_URL = "BorhanServerURL";
	protected final static String BORHAN_SERVER_ADMIN_SECRET = "BorhanServerAdminSecret";
	protected final static String BORHAN_SERVER_PARTNER_ID = "BorhanPartnerId";
	protected final static String BORHAN_SERVER_TIMEOUT = "BorhanServerTimeout";
	protected final static String BORHAN_SERVER_MANAGERS = "BorhanServerManagers";
	protected final static String BORHAN_SERVER_WEB_SERVICES = "BorhanServerWebServices";
	protected final static String BORHAN_SERVER_WEB_SERVICES_PORT = "BorhanServerWebServicesPort";
	protected final static String BORHAN_SERVER_WEB_SERVICES_HOST = "BorhanServerWebServicesHost";

	protected static Logger logger = Logger.getLogger(BorhanServer.class);
	protected static BorhanServer instance;
	protected static Map<String, Object> config;
	protected static BorhanClient client;
	protected static String hostname;
	protected static BorhanWebServicesServer webServicesServer;

	private static String OS;

	private static List<String> initManagers = new ArrayList<String>();
	protected static List<IManager> managers;

	protected BorhanServer() throws BorhanServerException {
		logger.info("Initializing BorhanUncaughtException handler");
		Thread.setDefaultUncaughtExceptionHandler(new BorhanUncaughtExceptionHnadler());

		InputStream versionInputStream = getClass().getResourceAsStream("/VERSION.txt");
		BufferedReader versionBufferedReader = new BufferedReader(new InputStreamReader(versionInputStream));
		String version = "Version not found";
		
		try {
			version = versionBufferedReader.readLine();
		} catch (IOException e1) {
			logger.error("Failed to read version file");
		}
		
		logger.debug("Initializing Borhan server [" + version + "]");
		BorhanServer.instance = this;
		
		try {
			hostname = InetAddress.getLocalHost().getHostName();
			logger.debug("Borhan server host name: " + hostname);
		} catch (UnknownHostException e) {
			throw new BorhanServerException("Failed to determine server host name: " + e.getMessage());
		}

		initClient();

		managers = new ArrayList<IManager>();
		if (!config.containsKey(BorhanServer.BORHAN_SERVER_MANAGERS)) {
			logger.error("Server managers [" + BorhanServer.BORHAN_SERVER_MANAGERS + "] are not defined");
		}
		else{
			String managersNames = (String) config.get(BorhanServer.BORHAN_SERVER_MANAGERS);
			logger.debug("Initializing server managers: " + managersNames);
			initServerManagers(managersNames.replaceAll(" ", "").split(","));
		}

		if (config.containsKey(BorhanServer.BORHAN_SERVER_WEB_SERVICES)) {
			int port = 888;
			String host = hostname;
			try {
				Enumeration<NetworkInterface> networkInterfaces = NetworkInterface.getNetworkInterfaces();
	            while(networkInterfaces.hasMoreElements()){
	                NetworkInterface networkInterface = networkInterfaces.nextElement();
	                Enumeration<InetAddress> inetAddresses = networkInterface.getInetAddresses();
	                while(inetAddresses.hasMoreElements()){
	                    InetAddress inetAddress = inetAddresses.nextElement();
	                    host = inetAddress.getHostAddress();
	                }
	            }
			} catch (SocketException e) {
				logger.error("Find local server IP address: " + e.getMessage());
			}
			
			if (config.containsKey(BorhanServer.BORHAN_SERVER_WEB_SERVICES_PORT)) 
				port = Integer.parseInt((String) config.get(BorhanServer.BORHAN_SERVER_WEB_SERVICES_PORT));

			if (config.containsKey(BorhanServer.BORHAN_SERVER_WEB_SERVICES_HOST)) 
				host = (String) config.get(BorhanServer.BORHAN_SERVER_WEB_SERVICES_HOST);
			
			webServicesServer = new BorhanWebServicesServer(host, port, logger);
			String servicesNames = (String) config.get(BorhanServer.BORHAN_SERVER_WEB_SERVICES);
			logger.debug("Initializing web services: " + servicesNames);
			initWebServices(servicesNames.replaceAll(" ", "").split(","));
		}
	}

	protected void initClient() throws BorhanServerException {
		final BorhanConfiguration clientConfig = new BorhanConfiguration();

		int partnerId = config.containsKey(BorhanServer.BORHAN_SERVER_PARTNER_ID) ? (int) config.get(BorhanServer.BORHAN_SERVER_PARTNER_ID) : MEDIA_SERVER_PARTNER_ID;
		

		if (!config.containsKey(BorhanServer.BORHAN_SERVER_URL))
			throw new BorhanServerException("Missing configuration [" + BorhanServer.BORHAN_SERVER_URL + "]");

		if (!config.containsKey(BorhanServer.BORHAN_SERVER_ADMIN_SECRET))
			throw new BorhanServerException("Missing configuration [" + BorhanServer.BORHAN_SERVER_ADMIN_SECRET + "]");

		clientConfig.setEndpoint((String) config.get(BorhanServer.BORHAN_SERVER_URL));
		logger.debug("Initializing Borhan client, URL: " + clientConfig.getEndpoint());

		if (config.containsKey(BorhanServer.BORHAN_SERVER_TIMEOUT))
			clientConfig.setTimeout(Integer.parseInt((String) config.get(BorhanServer.BORHAN_SERVER_TIMEOUT)) * 1000);

		client = new BorhanClient(clientConfig);
		client.setPartnerId(partnerId);
		client.setClientTag("MediaServer-" + hostname);
		generateClientSession();

		TimerTask generateSession = new TimerTask() {
			
			@Override
			public void run() {
				generateClientSession();
			}
		};

		long sessionGenerationInterval = 86000000;
		
		Timer timer = new Timer("clientSessionGeneration", true);
		timer.schedule(generateSession, sessionGenerationInterval, sessionGenerationInterval);
	}

	protected void generateClientSession() {
		int partnerId = config.containsKey(BorhanServer.BORHAN_SERVER_PARTNER_ID) ? (int) config.get(BorhanServer.BORHAN_SERVER_PARTNER_ID) : MEDIA_SERVER_PARTNER_ID;
		String adminSecretForSigning = (String) config.get(BorhanServer.BORHAN_SERVER_ADMIN_SECRET);
		String userId = "MediaServer";
		BorhanSessionType type = BorhanSessionType.ADMIN;
		int expiry = 86400;
		String privileges = "disableentitlement,sessionkey:" + BorhanServer.BORHAN_PERMANENT_SESSION_KEY;
		String sessionId;
		
		try {
			sessionId = client.generateSession(adminSecretForSigning, userId, type, partnerId, expiry, privileges);
		} catch (Exception e) {
			logger.error("Initializing Borhan client, URL: " + client.getBorhanConfiguration().getEndpoint());
			return;
		}

		client.setSessionId(sessionId);
		logger.debug("Borhan client session id: " + sessionId);
	}

	protected void initWebServices(String[] servicesNames) throws BorhanServerException {

		Object obj; 
		IWebService service;
		for (String serviceName : servicesNames) {
			try {
				obj = Class.forName(serviceName).newInstance();
				logger.debug("Initializing Borhan web service " + obj.getClass().getName());
			} catch (ClassNotFoundException e) {
				throw new BorhanServerException("Web service class [" + serviceName + "] not found");
			} catch (Exception e) {
				throw new BorhanServerException("Web service class [" + serviceName + "] failed to instantiate", e);
			}
			
			if(!(obj instanceof IWebService))
				throw new BorhanServerException("Web service class [" + serviceName + "] is not instance of IManager");
			
			service = (IWebService) obj;
			webServicesServer.addService(service);
			logger.info("Initialized Borhan web service " + obj.getClass().getName());
		}

	}
	
	public static synchronized void setManagerInitialized(String managerName) {
		logger.debug("Initialized Borhan manager " + managerName);

		if(initManagers == null || !initManagers.contains(managerName)){
			logger.error("Manager [" + managerName + "] already initialized");
			return;
		}
		
		initManagers.remove(managerName);
		
		if(initManagers.isEmpty()){
			initManagers = null;
			logger.debug("All managers initialized");
		}
	}
	
	public void initApplicationManagers (String[] managersNames) throws BorhanServerException {
		this.initManagers(managersNames);
	}
	
	protected void initServerManagers(String[] managersNames) throws BorhanServerException {
		
		for (String managerName : managersNames) {
			initManagers.add(managerName);			
		}
		
		this.initManagers(managersNames);
	}
	
	protected void initManagers(String[] managersNames) throws BorhanServerException {
		Object obj; 
		IManager manager;
		
		for (String managerName : managersNames) {
			try {
				obj = Class.forName(managerName).newInstance();
				logger.debug("Initializing Borhan manager " + obj.getClass().getName());
			} catch (ClassNotFoundException e) {
				throw new BorhanServerException("Server manager class [" + managerName + "] not found");
			} catch (Exception e) {
				throw new BorhanServerException("Server manager class [" + managerName + "] failed to instantiate", e);
			}
			
			if(!(obj instanceof IManager))
				throw new BorhanServerException("Server manager class [" + managerName + "] is not instance of IManager");
			
			manager = (IManager) obj;
			managers.add(manager);
			manager.init();
			logger.info("Initialized Borhan manager " + obj.getClass().getName());
		}
	}

	// TODO - Remove casting from those who use this function
	@SuppressWarnings("unchecked")
	public static <T extends IManager> T getManager(Class<T> managerInterface) {
		if (instance == null || managers == null) {
			logger.error("Managers are not initialized");
			return null;
		}

		if(!managerInterface.isInterface() || !IManager.class.isAssignableFrom(managerInterface))
			return null;
		
		for(IManager manager : managers){
			if(managerInterface.isInstance(manager))
				return (T)manager;
		}

		logger.error("Manager [" + managerInterface.getName() + "] not found");
		return null;
	}

	public static BorhanServer init(Map<String, Object> config) throws BorhanServerException {
		BorhanServer.config = config;
		
		if (instance == null)
			instance = new BorhanServer();

		return instance;
	}

	public void stop() {
		webServicesServer.shutdown();
		
		for(IManager manager : managers){
			manager.stop();
		}
	}

	public static boolean isInitialized() {
		if (instance == null || initManagers != null){
			return false;
		}
		
		return true;
	}

	public static BorhanServer getInstance() throws BorhanServerException {
		if (instance == null)
			throw new BorhanServerException("Server not initialized");

		return instance;
	}

	public static Map<String, Object> getConfiguration() {
		return config;
	}

	public static Object getConfiguration(String key) {
		if(config.containsKey(key)){
			return config.get(key);
		}
		
		return null;
	}

	public static BorhanClient getClient() {
		return client;
	}

	public static String getHostName() {
		return hostname;
	}

	public static boolean isWindows() {
		return getOsName().startsWith("Windows");
	}

	protected static String getOsName() {
		if(OS == null)
			OS = System.getProperty("os.name");
		
		return OS;
	}
}
