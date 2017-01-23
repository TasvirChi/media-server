package com.borhan.media.server.managers;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.BorhanServiceBase;
import com.borhan.client.types.BorhanLiveStreamEntry;



abstract public class BorhanLiveStreamManager extends BorhanLiveManager implements ILiveStreamManager {

	protected final static String BORHAN_SYNC_ENTRY_IDS = "BorhanSyncEntryids";
	protected List<String> syncEntryIds = new ArrayList<String>();

	@Override
	public void init() throws BorhanManagerException {
		super.init();

		if (serverConfiguration.containsKey(BorhanLiveStreamManager.BORHAN_SYNC_ENTRY_IDS)) {

			String[] entryIds = ((String) serverConfiguration.get(BorhanLiveStreamManager.BORHAN_SYNC_ENTRY_IDS)).replaceAll(" ", "").split(",");
			logger.debug("Sync entry ids: " + entryIds);
			syncEntryIds = Arrays.asList(entryIds);
		}
	}

	public boolean shouldSync(String entryId) {
		return syncEntryIds.contains(entryId);
	}

	public BorhanLiveStreamEntry authenticate(String entryId, int partnerId, String token) throws BorhanApiException {
		BorhanClient impersonateClient = impersonate(partnerId);
		BorhanLiveStreamEntry liveStreamEntry = impersonateClient.getLiveStreamService().authenticate(entryId, token);

		synchronized (entries) {
			updateEntryCache(liveStreamEntry);
		}

		return liveStreamEntry;
	}

	public BorhanLiveStreamEntry get(String entryId, int partnerId) throws BorhanApiException {
		BorhanClient impersonateClient = impersonate(partnerId);
		BorhanLiveStreamEntry liveStreamEntry = impersonateClient.getLiveStreamService().get(entryId);

		synchronized (entries) {
			updateEntryCache(liveStreamEntry);
		}

		return liveStreamEntry;
	}

	@Override
	public BorhanLiveStreamEntry get(String entryId) {
		return (BorhanLiveStreamEntry) super.get(entryId);
	}


	public BorhanServiceBase getLiveServiceInstance (BorhanClient impersonateClient)
	{
		return impersonateClient.getLiveStreamService();
	}


}
