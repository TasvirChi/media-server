package com.borhan.media.server.managers;

import com.borhan.client.types.BorhanLiveEntry;

public interface ICuePointsManager extends IManager {

	void createPeriodicSyncPoints(String liveEntryId, int interval, int duration);
	
	void createSyncPoint(String liveEntryId);
	
	double getEntryCurrentTime(BorhanLiveEntry liveEntry) throws BorhanManagerException;

	void sendSyncPoint(String entryId, String id, double offset) throws BorhanManagerException;

}
