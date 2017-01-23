package com.borhan.media.server.managers;

import com.borhan.client.BorhanApiException;
import com.borhan.client.types.BorhanLiveStreamEntry;

public interface ILiveStreamManager extends IManager, ILiveManager {

	public BorhanLiveStreamEntry get(String entryId);

	public BorhanLiveStreamEntry authenticate(String entryId, int partnerId, String token) throws BorhanApiException;

	public boolean splitRecordingNow(String entryId);
	
	public boolean shouldSync(String entryId);
}
