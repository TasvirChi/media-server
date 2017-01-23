package com.borhan.media.server.managers;

import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.types.BorhanConversionProfileAssetParams;
import com.borhan.client.types.BorhanLiveAsset;
import com.borhan.client.types.BorhanLiveEntry;
import com.borhan.client.types.BorhanLiveParams;

public interface ILiveManager extends IManager {
	
	/**
	 *	Marking interface to indicate classes as entry-cache dependent 
	 */
	public interface ILiveEntryReferrer {
		
	}
	
	/**
	 * Registers an object as referrer to a given entry
	 * @param entryId The entry it refers to
	 * @param obj The referrer
	 */
	public void addReferrer(String entryId, ILiveEntryReferrer obj);
	
	/**
	 * Unregisters an object as referrer to a given entry
	 * @param entryId The entry it referred to
	 * @param obj The referrer
	 */
	public void removeReferrer(String entryId, ILiveEntryReferrer obj);
		
	public BorhanLiveEntry get(String entryId);
	
	public BorhanMediaServerIndex getMediaServerIndexForEntry(String entryId);

	public Integer getDvrWindow(BorhanLiveEntry liveStreamEntry);
	
	public BorhanConversionProfileAssetParams getConversionProfileAssetParams(String entryId, int assetParamsId);
	
	public BorhanLiveAsset getLiveAsset(String entryId, int assetParamsId);
	
	public BorhanLiveParams getLiveAssetParams(int assetParamsId);
	
	public Object getOrAddMetadata(String entryId, String key, Object defaultValue);
	public Object getMetadata(String entryId, String key);
	public Object setMetadata(String entryId, String key, Object value);
}
