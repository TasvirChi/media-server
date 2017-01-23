package com.borhan.media.server.managers;

import java.util.List;

import com.borhan.client.BorhanApiException;
import com.borhan.client.types.BorhanBaseEntry;
import com.borhan.client.types.BorhanLiveChannel;


public interface ILiveChannelManager extends IManager, ILiveManager {

	public BorhanLiveChannel get(String liveChannelId, int partnerId) throws BorhanApiException;
	
	public void start(String liveChannelId, int partnerId);
	
	public void start(BorhanLiveChannel liveChannel, List<BorhanBaseEntry> segmentEntries);
	
	public void publishEntry(String liveChannelId, String entryId, int partnerId);
	
	public void publishSegment(int liveChannelSegmentId, int partnerId);
	
}
