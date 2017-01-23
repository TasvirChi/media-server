package com.borhan.media.server.wowza.demo;

import com.borhan.media.server.managers.BorhanManagerException;
import com.borhan.media.server.wowza.LiveChannelManager;

public class LiveChannelDemo extends LiveChannelManager implements Runnable {

	protected final static String BORHAN_CHANNELS_DEMO_PARTNER_ID = "BorhanChannelsDemoPartnerId";
	protected final static String BORHAN_CHANNELS_DEMO_CHANNEL_IDS = "BorhanChannelsDemoChannelIds";

	private int partnerId;
	
	@Override
	public void init() throws BorhanManagerException {
		super.init();
		
		new Thread(this).start();
	}


	@Override
	public void run() {
		if (serverConfiguration.containsKey(LiveChannelDemo.BORHAN_CHANNELS_DEMO_PARTNER_ID) && serverConfiguration.containsKey(LiveChannelDemo.BORHAN_CHANNELS_DEMO_CHANNEL_IDS)) {
			
			partnerId = Integer.parseInt((String) serverConfiguration.get(LiveChannelDemo.BORHAN_CHANNELS_DEMO_PARTNER_ID));
			String channelIds = (String) serverConfiguration.get(LiveChannelDemo.BORHAN_CHANNELS_DEMO_CHANNEL_IDS);
			
			logger.debug("LiveChannelDemo::init Initializing channels: " + channelIds);
			start(channelIds.replaceAll(" ", "").split(","));
		}
	}

	private void start(String[] channelIds) {
		for(String channelId : channelIds)
			start(channelId, partnerId);
	}
}
