package com.borhan.media.server.managers;

import java.util.Map;

import com.borhan.client.BorhanClient;
import com.borhan.client.BorhanConfiguration;
import com.borhan.media.server.BorhanServer;

abstract public class BorhanManager implements IManager {

	protected String hostname;
	private BorhanClient client;
	protected BorhanConfiguration config;
	protected Map<String, Object> serverConfiguration;

	protected BorhanClient impersonate(int partnerId) {
		BorhanConfiguration impersonateConfig = new BorhanConfiguration();
		impersonateConfig.setEndpoint(config.getEndpoint());
		impersonateConfig.setTimeout(config.getTimeout());

		BorhanClient cloneClient = new BorhanClient(impersonateConfig);
		cloneClient.setPartnerId(partnerId);
		cloneClient.setClientTag(client.getClientTag());
		cloneClient.setSessionId(client.getSessionId());

		return cloneClient;
	}
	
	/**
	 * Clones a client to create a new instance of it
	 * Pay attention that the KS isn't renewed and copied from the current client
	 * @return BorhanClient
	 */
	protected BorhanClient getClient() {
		BorhanClient cloneClient = new BorhanClient(config);
		cloneClient.setSessionId(client.getSessionId());
		return cloneClient;
	}

	public void init() throws BorhanManagerException {
		hostname = BorhanServer.getHostName();
		client = BorhanServer.getClient();
		config = client.getBorhanConfiguration();
		serverConfiguration = BorhanServer.getConfiguration();
	}

	protected void setInitialized() throws BorhanManagerException {
		BorhanServer.setManagerInitialized(getClass().getName());
	}

	@Override
	public void stop() {
	}
}
