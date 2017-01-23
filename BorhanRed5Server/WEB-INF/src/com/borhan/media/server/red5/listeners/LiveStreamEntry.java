package com.borhan.media.server.red5.listeners;

import java.util.HashMap;
import java.util.Map;

import org.apache.log4j.Logger;
import org.red5.server.adapter.ApplicationAdapter;
import org.red5.server.api.IClient;
import org.red5.server.api.IConnection;
import org.red5.server.api.Red5;
import org.red5.server.api.scope.IScope;
import org.red5.server.api.stream.IBroadcastStream;
import org.red5.server.api.stream.IPlayItem;
import org.red5.server.api.stream.IStreamAwareScopeHandler;
import org.red5.server.api.stream.ISubscriberStream;
import org.red5.server.stream.ServerStream;

import com.borhan.client.BorhanApiException;
import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.enums.BorhanRecordStatus;
import com.borhan.client.types.BorhanLiveStreamEntry;
import com.borhan.media.server.ILiveStreamManager;
import com.borhan.media.server.BorhanServer;
import com.borhan.media.server.BorhanServerException;
import com.borhan.media.server.red5.LiveStreamManager;

public class LiveStreamEntry extends ApplicationAdapter implements IStreamAwareScopeHandler {

	protected final static String REQUEST_PROPERTY_PARTNER_ID = "p";
	protected final static String REQUEST_PROPERTY_ENTRY_ID = "e";
	protected final static String REQUEST_PROPERTY_SERVER_INDEX = "i";
	protected final static String REQUEST_PROPERTY_TOKEN = "t";

	protected final static String CLIENT_PROPERTY_PARTNER_ID = "partnerId";
	protected final static String CLIENT_PROPERTY_SERVER_INDEX = "serverIndex";
	protected final static String CLIENT_PROPERTY_ENTRY_ID = "entryId";

	protected final static int INVALID_SERVER_INDEX = -1;

	private static LiveStreamManager liveStreamManager;

	protected static Logger logger = Logger.getLogger(LiveStreamEntry.class);
	Map<String, Object> config = new HashMap<String, Object>();

	@Override
	public void streamPublishStart(IBroadcastStream stream) {
		logger.debug("LiveStreamEntry::streamPublishStart: name [" + stream.getPublishedName() + "]");

		IClient client = Red5.getConnectionLocal().getClient();
		if (client == null)
			return;

		if (!client.hasAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID))
			return;

		BorhanLiveStreamEntry liveStreamEntry = liveStreamManager.get((String) client.getAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID));
		BorhanMediaServerIndex serverIndex = BorhanMediaServerIndex.get((int) client.getAttribute(LiveStreamEntry.CLIENT_PROPERTY_SERVER_INDEX, LiveStreamEntry.INVALID_SERVER_INDEX));

		logger.debug("LiveStreamEntry::streamPublishStart: " + liveStreamEntry.id);

		if (liveStreamEntry.recordStatus == BorhanRecordStatus.ENABLED) {
			if (stream instanceof ServerStream) {
				liveStreamManager.onPublish(liveStreamEntry, serverIndex, (ServerStream) stream);
				return;
			}
		}

		liveStreamManager.onPublish(liveStreamEntry, serverIndex);
	}

	@Override
	public void streamRecordStart(IBroadcastStream ibroadcaststream) {
	}

	@Override
	public void streamRecordStop(IBroadcastStream ibroadcaststream) {
	}

	@Override
	public void streamBroadcastStart(IBroadcastStream stream) {
	}

	@Override
	public void streamBroadcastClose(IBroadcastStream stream) {
		logger.debug("LiveStreamEntry::streamBroadcastClose: name [" + stream.getPublishedName() + "]");

		IClient client = Red5.getConnectionLocal().getClient();
		if (client == null)
			return;

		if (!client.hasAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID))
			return;

		if (!client.hasAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID))
			return;

		BorhanLiveStreamEntry liveStreamEntry = liveStreamManager.get((String) client.getAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID));
		BorhanMediaServerIndex serverIndex = BorhanMediaServerIndex.get((int) client.getAttribute(LiveStreamEntry.CLIENT_PROPERTY_SERVER_INDEX, LiveStreamEntry.INVALID_SERVER_INDEX));

		logger.debug("LiveStreamEntry::streamPublishStart: " + liveStreamEntry.id);

		if (liveStreamEntry.recordStatus == BorhanRecordStatus.ENABLED) {
			if (stream instanceof ServerStream) {
				liveStreamManager.onUnPublish(liveStreamEntry, serverIndex, (ServerStream) stream);
				return;
			}
		}

		liveStreamManager.onUnPublish(liveStreamEntry, serverIndex);
	}

	@Override
	public void streamSubscriberStart(ISubscriberStream isubscriberstream) {
	}

	@Override
	public void streamSubscriberClose(ISubscriberStream isubscriberstream) {
	}

	@Override
	public void streamPlayItemPlay(ISubscriberStream isubscriberstream, IPlayItem iplayitem, boolean flag) {
	}

	@Override
	public void streamPlayItemStop(ISubscriberStream isubscriberstream, IPlayItem iplayitem) {
	}

	@Override
	public void streamPlayItemPause(ISubscriberStream isubscriberstream, IPlayItem iplayitem, int i) {
	}

	@Override
	public void streamPlayItemResume(ISubscriberStream isubscriberstream, IPlayItem iplayitem, int i) {
	}

	@Override
	public void streamPlayItemSeek(ISubscriberStream isubscriberstream, IPlayItem iplayitem, int i) {
	}

	@Override
	public synchronized void disconnect(IConnection conn, IScope scope) {
		logger.debug("LiveStreamEntry::disconnect: name [" + scope.getName() + "]");

		IClient client = conn.getClient();
		if (client.hasAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID)) {
			String entryId = (String) client.getAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID);
			liveStreamManager.onDisconnect(entryId);
			logger.info("LiveStreamEntry::onDisconnect: Entry removed [" + entryId + "]");
		}

		super.disconnect(conn, scope);
	}

	@Override
	public synchronized boolean connect(IConnection conn, IScope scope, Object params[]) {
		String entryPoint = conn.getPath();

		logger.debug("LiveStreamEntry::connect: [" + entryPoint + "]");

		IClient client = conn.getClient();

		String[] requestParts = entryPoint.split("/");
		HashMap<String, String> requestParams = new HashMap<String, String>();
		String field = null;
		for (int i = 1; i < requestParts.length; ++i) {
			if (field == null) {
				field = requestParts[i];
			} else {
				requestParams.put(field, requestParts[i]);
				logger.debug("LiveStreamEntry::connect: " + field + ": " + requestParams.get(field));
				field = null;
			}
		}

		int partnerId = Integer.parseInt(requestParams.get(LiveStreamEntry.REQUEST_PROPERTY_PARTNER_ID));
		String entryId = requestParams.get(LiveStreamEntry.REQUEST_PROPERTY_ENTRY_ID);
		String token = requestParams.get(LiveStreamEntry.REQUEST_PROPERTY_TOKEN);

		try {
			liveStreamManager.authenticate(entryId, partnerId, token);
			client.setAttribute(LiveStreamEntry.CLIENT_PROPERTY_PARTNER_ID, partnerId);
			client.setAttribute(LiveStreamEntry.CLIENT_PROPERTY_SERVER_INDEX, Integer.parseInt(requestParams.get(LiveStreamEntry.REQUEST_PROPERTY_SERVER_INDEX)));
			client.setAttribute(LiveStreamEntry.CLIENT_PROPERTY_ENTRY_ID, entryId);
			logger.info("LiveStreamEntry::connect: Entry added [" + entryId + "]");
		} catch (BorhanApiException e) {
			logger.error("LiveStreamEntry::connect: Entry authentication failed [" + entryId + "]: " + e.getMessage());
			return false;
		}
		
		return super.connect(conn, scope, params);
	}

	public void setBorhanServerURL(String borhanServerURL) {
		config.put("BorhanServerURL", borhanServerURL);
	}

	public void setBorhanServerAdminSecret(String borhanServerAdminSecret) {
		config.put("BorhanServerAdminSecret", borhanServerAdminSecret);
	}

	public void setBorhanServerTimeout(String borhanServerTimeout) {
		config.put("BorhanServerTimeout", borhanServerTimeout);
	}

	public void setBorhanServerManagers(String borhanServerManagers) {
		config.put("BorhanServerManagers", borhanServerManagers);
	}

	public void setBorhanServerWebServices(String borhanServerWebServices) {
		config.put("BorhanServerWebServices", borhanServerWebServices);
	}

	public void setBorhanServerStatusInterval(String borhanServerStatusInterval) {
		config.put("BorhanServerStatusInterval", borhanServerStatusInterval);
	}

	public void setBorhanLiveStreamKeepAliveInterval(String borhanLiveStreamKeepAliveInterval) {
		config.put("BorhanLiveStreamKeepAliveInterval", borhanLiveStreamKeepAliveInterval);
	}

	public void setBorhanLiveStreamMaxDvrWindow(String borhanLiveStreamMaxDvrWindow) {
		config.put("BorhanLiveStreamMaxDvrWindow", borhanLiveStreamMaxDvrWindow);
	}

	public void setBorhanRecordedChunckMaxDuration(String borhanRecordedChunckMaxDuration) {
		config.put("BorhanRecordedChunckMaxDuration", borhanRecordedChunckMaxDuration);
	}

	public void setBorhanServerWebServicesPort(String borhanServerWebServicesPort) {
		config.put("BorhanServerWebServicesPort", borhanServerWebServicesPort);
	}

	public void setBorhanServerWebServicesHost(String borhanServerWebServicesHost) {
		config.put("BorhanServerWebServicesHost", borhanServerWebServicesHost);
	}

	public void setBorhanRecordedFileGroup(String borhanRecordedFileGroup) {
		config.put("BorhanRecordedFileGroup", borhanRecordedFileGroup);
	}

	public void setBorhanIsLiveRegistrationMinBufferTime(String borhanIsLiveRegistrationMinBufferTime) {
		config.put("BorhanIsLiveRegistrationMinBufferTime", borhanIsLiveRegistrationMinBufferTime);
	}

	public boolean appStart(IScope app) {

		if (liveStreamManager == null) {

			setCanConnect(false);

			if (!BorhanServer.isInitialized()) {
				try {
					BorhanServer.init(logger, config);
					logger.info("Initialized Borhan server");
				} catch (BorhanServerException e) {
					logger.error("Failed to initialize Borhan server: " + e.getMessage());
					return super.appStart(app);
				}
			}

			logger.debug("LiveStreamEntry::setServletContext: name [" + app.getContextPath() + "]");
			ILiveStreamManager serverLiveStreamManager = (ILiveStreamManager) BorhanServer.getManager(ILiveStreamManager.class);

			if (serverLiveStreamManager != null && serverLiveStreamManager instanceof LiveStreamManager) {
				liveStreamManager = (LiveStreamManager) serverLiveStreamManager;
				setCanConnect(true);
			} else {
				logger.error("LiveStreamEntry::onAppStart: Live stream manager not defined");
			}
		}

		return super.appStart(app);
	}
}