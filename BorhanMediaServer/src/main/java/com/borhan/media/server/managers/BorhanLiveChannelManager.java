package com.borhan.media.server.managers;

import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.BorhanServiceBase;
import com.borhan.client.types.BorhanBaseEntry;
import com.borhan.client.types.BorhanLiveChannel;


abstract public class BorhanLiveChannelManager extends BorhanLiveManager implements ILiveChannelManager, ILiveManager.ILiveEntryReferrer{

	protected final static String BORHAN_RELOAD_SCHEDULED_CHANNELS_INTERVAL = "BorhanReloadScheduledChannelsInterval";
	
	protected final static long DEFAULT_RELOAD_SCHEDULED_CHANNELS_INTERVAL = 60;

	private Timer reloadScheduledChannelsTimer;
	
	@Override
	public void init() throws BorhanManagerException {
		super.init();
		
		long reloadScheduledChannelsInterval = BorhanLiveChannelManager.DEFAULT_RELOAD_SCHEDULED_CHANNELS_INTERVAL * 1000;
		if (serverConfiguration.containsKey(BorhanLiveChannelManager.BORHAN_RELOAD_SCHEDULED_CHANNELS_INTERVAL))
			reloadScheduledChannelsInterval = Long.parseLong((String) serverConfiguration.get(BorhanLiveChannelManager.BORHAN_RELOAD_SCHEDULED_CHANNELS_INTERVAL)) * 1000;

		if(reloadScheduledChannelsInterval > 0){
			TimerTask reloadScheduledChannelsTask = new TimerTask(){
	
				@Override
				public void run() {
					reloadScheduledChannels();
				}

			};
			
			reloadScheduledChannelsTimer = new Timer(true);
			reloadScheduledChannelsTimer.schedule(reloadScheduledChannelsTask, reloadScheduledChannelsInterval, reloadScheduledChannelsInterval);
		}
	}

	protected void reloadScheduledChannels() {
		// TODO
	}

	public BorhanLiveChannel get(String liveChannelId){
		return (BorhanLiveChannel) super.get(liveChannelId);
	}

	public BorhanLiveChannel get(String liveChannelId, int partnerId) throws BorhanApiException{
		BorhanClient impersonateClient = impersonate(partnerId);
		BorhanLiveChannel liveEntry = impersonateClient.getLiveChannelService().get(liveChannelId);

		synchronized (entries) {
			updateEntryCache(liveEntry);
			addReferrer(liveEntry.id, this);
		}
		
		return liveEntry;
	}
	
	@Override
	public void start(String liveChannelId, int partnerId){
		BorhanLiveChannel liveChannel;
		try {
			liveChannel = get(liveChannelId, partnerId);
		} catch (BorhanApiException e) {
			logger.error("BorhanLiveChannelManager::start failed to get live channel [" + liveChannelId + "]: " + e.getMessage());
			return;
		}
		
		if(liveChannel.playlistId != null){
			List<BorhanBaseEntry> segmentEntries;
			BorhanClient impersonateClient = impersonate(partnerId);
			try {
				segmentEntries = impersonateClient.getPlaylistService().execute(liveChannel.playlistId);
				impersonateClient = null;
			} catch (BorhanApiException e) {
				impersonateClient = null;
				logger.error("BorhanLiveChannelManager::start failed to execute playlist [" + liveChannel.playlistId + "] for channel [" + liveChannelId + "]: " + e.getMessage());
				return;
			}
			start(liveChannel, segmentEntries);
		}
		else{
			// TODO
		}
	}

	@Override
	public void publishEntry(String liveChannelId, String entryId, int partnerId){
		// TODO
	}

	@Override
	public void publishSegment(int liveChannelSegmentId, int partnerId){
		// TODO
	}

	@Override
	public void stop() {
		reloadScheduledChannelsTimer.cancel();
		reloadScheduledChannelsTimer.purge();
		
		super.stop();

		synchronized (entries) {
			for(LiveEntryCache liveEntryCache : entries.values()){
				removeReferrer(liveEntryCache.getLiveEntry().id, this);
			}
		}
	}


	public BorhanServiceBase getLiveServiceInstance (BorhanClient impersonateClient)
	{
		return impersonateClient.getLiveChannelService();
	}
}
