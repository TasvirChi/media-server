package com.borhan.media.server.managers;

import java.io.File;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Map;
import java.util.Set;
import java.util.Timer;
import java.util.TimerTask;
import java.util.concurrent.ConcurrentHashMap;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.apache.log4j.Logger;
import org.w3c.dom.Document;
import org.w3c.dom.Element;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.BorhanFile;
import com.borhan.client.BorhanMultiResponse;
import com.borhan.client.BorhanServiceBase;
import com.borhan.client.enums.BorhanDVRStatus;
import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.enums.BorhanLiveEntryStatus;
import com.borhan.client.types.BorhanConversionProfileAssetParams;
import com.borhan.client.types.BorhanConversionProfileAssetParamsFilter;
import com.borhan.client.types.BorhanConversionProfileAssetParamsListResponse;
import com.borhan.client.types.BorhanDataCenterContentResource;
import com.borhan.client.types.BorhanFlavorAsset;
import com.borhan.client.types.BorhanFlavorAssetListResponse;
import com.borhan.client.types.BorhanFlavorParams;
import com.borhan.client.types.BorhanFlavorParamsListResponse;
import com.borhan.client.types.BorhanLiveAsset;
import com.borhan.client.types.BorhanLiveAssetFilter;
import com.borhan.client.types.BorhanLiveEntry;
import com.borhan.client.types.BorhanLiveParams;
import com.borhan.client.types.BorhanLiveStreamEntry;
import com.borhan.client.types.BorhanServerFileResource;
import com.borhan.client.types.BorhanUploadToken;
import com.borhan.client.types.BorhanUploadedFileTokenResource;
import com.borhan.media.server.BorhanEventsManager;
import com.borhan.media.server.events.IBorhanEvent;
import com.borhan.media.server.events.IBorhanEventConsumer;
import com.borhan.media.server.events.BorhanEventType;
import com.borhan.media.server.events.BorhanStreamEvent;

abstract public class BorhanLiveManager extends BorhanManager implements ILiveManager, IBorhanEventConsumer {

	protected final static String BORHAN_RECORDED_CHUNCK_MAX_DURATION = "BorhanRecordedChunckMaxDuration";
	protected final static String UPLOAD_XML_SAVE_PATH = "uploadXMLSavePath";
	protected final static String BORHAN_LIVE_STREAM_KEEP_ALIVE_INTERVAL = "BorhanLiveStreamKeepAliveInterval";
	protected final static String BORHAN_LIVE_STREAM_MAX_DVR_WINDOW = "BorhanLiveStreamMaxDvrWindow";
	protected final static String BORHAN_IS_LIVE_REGISTRATION_MIN_BUFFER_TIME = "BorhanIsLiveRegistrationMinBufferTime";
	protected final static String BORHAN_WOWZA_SERVER_WORK_MODE = "BorhanWorkMode";

	protected final static long DEFAULT_IS_LIVE_REGISTRATION_MIN_BUFFER_TIME = 5;
	protected final static String BORHAN_WOWZA_SERVER_WORK_MODE_REMOTE = "remote";
	protected final static String BORHAN_WOWZA_SERVER_WORK_MODE_BORHAN = "borhan";

	protected final static String LIVE_STREAM_EXCEEDED_MAX_RECORDED_DURATION = "LIVE_STREAM_EXCEEDED_MAX_RECORDED_DURATION";

	protected static Logger logger = Logger.getLogger(BorhanLiveManager.class);

	protected ConcurrentHashMap<String, LiveEntryCache> entries = new ConcurrentHashMap<String, LiveEntryCache>();
	protected ConcurrentHashMap<Integer, BorhanLiveParams> liveAssetParams = new ConcurrentHashMap<Integer, BorhanLiveParams>();
	protected long isLiveRegistrationMinBufferTime = BorhanLiveManager.DEFAULT_IS_LIVE_REGISTRATION_MIN_BUFFER_TIME;

	private Timer setMediaServerTimer;

	protected void updateEntryCache(BorhanLiveEntry liveStreamEntry) {
		LiveEntryCache c = entries.get(liveStreamEntry.id);
		if (c == null) {
			entries.put(liveStreamEntry.id, new LiveEntryCache(liveStreamEntry));
		} else {
			c.setLiveEntry(liveStreamEntry);
		}

	}

	protected class LiveEntryCache {
		private BorhanLiveEntry liveEntry;
		private boolean entryRegistered = false;
		private BorhanMediaServerIndex index = null;
		private ArrayList<BorhanConversionProfileAssetParams> conversionProfileAssetParams;
		private Map<Integer, BorhanLiveAsset> liveAssets = new HashMap<Integer, BorhanLiveAsset>();
		private Timer timer;
		private boolean readyForPlayback = false;
		Set<ILiveEntryReferrer> referrers = new HashSet<ILiveManager.ILiveEntryReferrer>();
		Map<String, Object> metadata = new ConcurrentHashMap<String, Object>();

		public void addReferrer(ILiveEntryReferrer obj) {
			synchronized (referrers) {
				referrers.add(obj);
				logger.debug(liveEntry.id + " referrer count: "
						+ referrers.size());
			}
		}

		/**
		 * This code is added to prevent a case in which an entry is removed from cache while there are still references to it.
		 */
		public boolean removeReferrer(ILiveEntryReferrer obj) {
			synchronized (referrers) {
				boolean removed = referrers.remove(obj);
				logger.debug(liveEntry.id + " referrer count : "
						+ referrers.size());
				if (referrers.isEmpty()) {

					synchronized (entries) {
						logger.info("Remove object [" + liveEntry.id
								+ "] from entry cache");
						entries.remove(liveEntry.id);
					}
					unregister();
				}
				return removed;
			}
		}

		public LiveEntryCache(BorhanLiveEntry liveEntry) {
			this.liveEntry = liveEntry;

			loadAssetParams();
		}

		private void loadAssetParams() {
			if(liveEntry.conversionProfileId <= 0)
				return;

			BorhanConversionProfileAssetParamsFilter assetParamsFilter = new BorhanConversionProfileAssetParamsFilter();
			assetParamsFilter.conversionProfileIdEqual = liveEntry.conversionProfileId;

			BorhanLiveAssetFilter asstesFilter = new BorhanLiveAssetFilter();
			asstesFilter.entryIdEqual = liveEntry.id;

			BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
			impersonateClient.startMultiRequest();
			try {
				impersonateClient.getConversionProfileAssetParamsService().list(assetParamsFilter);
				impersonateClient.getFlavorAssetService().list(asstesFilter);
				BorhanMultiResponse responses = impersonateClient.doMultiRequest();


				Object conversionProfileAssetParamsList = responses.get(0);
				Object flavorAssetsList = responses.get(1);

				if(conversionProfileAssetParamsList instanceof BorhanConversionProfileAssetParamsListResponse)
					conversionProfileAssetParams = ((BorhanConversionProfileAssetParamsListResponse) conversionProfileAssetParamsList).objects;

				if(flavorAssetsList instanceof BorhanFlavorAssetListResponse){
					for(BorhanFlavorAsset liveAsset : ((BorhanFlavorAssetListResponse) flavorAssetsList).objects){
						if(liveAsset instanceof BorhanLiveAsset){
							liveAssets.put(liveAsset.flavorParamsId, (BorhanLiveAsset) liveAsset);

							if(!liveAssetParams.containsKey(liveAsset.flavorParamsId)){
								BorhanFlavorParams liveParams = impersonateClient.getFlavorParamsService().get(liveAsset.flavorParamsId);
								if(liveParams instanceof BorhanLiveParams)
									liveAssetParams.put(liveAsset.flavorParamsId, (BorhanLiveParams) liveParams);
							}
						}
					}
				}

			} catch (BorhanApiException e) {
				logger.error("Failed to load asset params for live entry [" + liveEntry.id + "]:" + e.getMessage());
			}
			impersonateClient = null;
		}

		public synchronized void setEntryIsLive() {
			if (isReadyForPlayback()) {
				logger.info("setEntryIsLive was called - IsLive is already on");
				return;
			}
			TimerTask setMediaServerTask = new TimerTask() {

				@Override
				public void run() {
					if(!isEntryRegistered()) {
						logger.info("Entry's not registered, can't call setEntryMediaServer");
						return;
					}
					try{
						logger.info("Initial timer task running [" + liveEntry.id + "] - PLAYABLE");
						setEntryMediaServer(liveEntry, index, BorhanLiveEntryStatus.PLAYABLE);
					}
					catch (Exception err) {
						logger.error(err);
					}
				}
			};

			timer = new Timer("register-" + liveEntry.id, true);
			timer.schedule(setMediaServerTask, 0);
			readyForPlayback = true;
			logger.debug("Scheduled initial timer [" + liveEntry.id + "]");
		}
		
		public synchronized void register(BorhanMediaServerIndex serverIndex, String appName) {
			logger.debug("Register [" + liveEntry.id + "]");
			if(isEntryRegistered())
				return;

			index = serverIndex;

			// run this task now to let the server know we are broadcasting
			TimerTask setMediaServerTaskBroadcasting = new TimerTask() {

				@Override
				public void run() {
					logger.info("Initial timer task running [" + liveEntry.id + "] - BROADCASTING");
					setEntryMediaServer(liveEntry, index, BorhanLiveEntryStatus.BROADCASTING);
				}
			};

			timer = new Timer("register-" + liveEntry.id, true);
			timer.schedule(setMediaServerTaskBroadcasting, 0);
			logger.debug("Scheduled initial timer [" + liveEntry.id + "]");

			entryRegistered = true;
		}

		public synchronized void unregister() {
			logger.debug("LiveEntryCache::unregister");
			BorhanMediaServerIndex tmpIndex = index;
			index = null;

			if(timer != null){
				timer.cancel();
				timer.purge();
				timer = null;
			}
			entryRegistered = false;
			readyForPlayback = false;

			unsetEntryMediaServer(liveEntry, tmpIndex);
		}

		public boolean isEntryRegistered() {
			return entryRegistered;
		}

		public boolean isReadyForPlayback() {
			return isEntryRegistered() && readyForPlayback;
		}

		public void setLiveEntry(BorhanLiveEntry liveEntry) {
			this.liveEntry = liveEntry;
		}

		public BorhanLiveEntry getLiveEntry() {
			return liveEntry;
		}

		public ArrayList<BorhanConversionProfileAssetParams> getConversionProfileAssetParams() {
			return conversionProfileAssetParams;
		}

		public BorhanLiveAsset getLiveAsset(int assetParamsId) {
			if(liveAssets.containsKey(assetParamsId))
				return liveAssets.get(assetParamsId);

			logger.error("Asset params id [" + assetParamsId + "] not found");
			return null;
		}

		public BorhanLiveAsset getLiveAsset(String streamSuffix) {
			BorhanLiveParams assetParams;
			for(BorhanLiveAsset liveAsset : liveAssets.values()){
				assetParams = getLiveAssetParams(liveAsset.flavorParamsId);
				if(assetParams != null && assetParams.streamSuffix != null && assetParams.streamSuffix.equals(streamSuffix)){
					return liveAsset;
				}
			}

			logger.error("Asset with stream suffix [" + streamSuffix + "] not found");
			return null;
		}

		public BorhanLiveAsset getLiveAssetById(String assetId) {
			for(BorhanLiveAsset liveAsset : liveAssets.values()){
				if(liveAsset.id == assetId){
					return liveAsset;
				}
			}

			logger.error("Asset with id [" + assetId + "] not found");
			return null;
		}

		public Integer[] getLiveAssetParamsIds() {
			return liveAssets.keySet().toArray(new Integer[0]);
		}

		public BorhanMediaServerIndex getIndex() {
			return index;
		}

		public Object getMetadata(String key) {
			return getOrAddMetadata(key, null);
		}

		public Object getOrAddMetadata(String key, Object defaultValue) {
			synchronized (metadata) {
				if (!metadata.containsKey(key) && (null != defaultValue))
					metadata.put(key, defaultValue);
				return metadata.get(key);
			}
		}

		public Object setMetadata(String key, Object value) {
			synchronized (metadata) {
				return metadata.put(key, value);
			}
		}

	}

	abstract public BorhanServiceBase getLiveServiceInstance (BorhanClient impersonateClient);

	abstract protected void disconnectStream (String entryId);

	public BorhanLiveEntry get(String entryId) {

		synchronized (entries) {
			if (entries.containsKey(entryId)) {
				LiveEntryCache liveEntryCache = entries.get(entryId);
				return liveEntryCache.getLiveEntry();
			}
		}

		return null;
	}

	public BorhanMediaServerIndex getMediaServerIndexForEntry (String entryId) {
		synchronized (entries) {
			if (entries.containsKey(entryId)) {
				LiveEntryCache liveEntryCache = entries.get(entryId);
				return liveEntryCache.getIndex();
			}
		}

		return null;
	}

	public BorhanLiveParams getLiveAssetParams(int assetParamsId){

		synchronized (liveAssetParams) {
			if (!liveAssetParams.containsKey(assetParamsId)) {
				logger.error("Asset params id [" + assetParamsId + "] not found");
				return null;
			}

			return liveAssetParams.get(assetParamsId);
		}
	}

	public BorhanLiveAsset getLiveAsset(String entryId, int assetParamsId) {

		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.getLiveAsset(assetParamsId);
		}
	}

	public BorhanLiveAsset getLiveAsset(String entryId, String streamSuffix) {

		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.getLiveAsset(streamSuffix);
		}
	}

	public BorhanLiveAsset getLiveAssetById(String entryId, String assetId) {

		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.getLiveAssetById(assetId);
		}
	}

	public Integer[] getLiveAssetParamsIds(String entryId) {

		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.getLiveAssetParamsIds();
		}
	}

	public BorhanConversionProfileAssetParams getConversionProfileAssetParams(String entryId, int assetParamsId) {

		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			ArrayList<BorhanConversionProfileAssetParams> conversionProfileAssetParamsList = liveEntryCache.getConversionProfileAssetParams();
			for(BorhanConversionProfileAssetParams conversionProfileAssetParams : conversionProfileAssetParamsList){
				if(conversionProfileAssetParams.assetParamsId == assetParamsId)
					return conversionProfileAssetParams;
			}
		}

		logger.error("Asset id [" + assetParamsId + "] in entry [" + entryId + "] not found");
		return null;
	}

	public Integer getDvrWindow(BorhanLiveEntry liveEntry) {
		if (liveEntry.dvrStatus != BorhanDVRStatus.ENABLED)
			return null;

		int maxDvrWindow = Integer.parseInt((String) serverConfiguration.get(BorhanLiveManager.BORHAN_LIVE_STREAM_MAX_DVR_WINDOW));
		int dvrWindowSeconds = liveEntry.dvrWindow * 60;
		if (dvrWindowSeconds <= 0 || dvrWindowSeconds > maxDvrWindow)
			return maxDvrWindow;

		return dvrWindowSeconds;
	}

	public Object getMetadata(String entryId, String key) {
		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.getMetadata(key);
		}
	}

	public Object getOrAddMetadata(String entryId, String key, Object defaultValue) {
		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.getOrAddMetadata(key, defaultValue);
		}
	}

	public Object setMetadata(String entryId, String key, Object value) {
		synchronized (entries) {
			if (!entries.containsKey(entryId)) {
				logger.error("Entry id [" + entryId + "] not found");
				return null;
			}

			LiveEntryCache liveEntryCache = entries.get(entryId);
			return liveEntryCache.setMetadata(key, value);
		}
	}

	@Override
	public void onEvent(IBorhanEvent event){
		BorhanStreamEvent streamEvent;

		if(event.getType() instanceof BorhanEventType){
			switch((BorhanEventType) event.getType())
			{
				case STREAM_PUBLISHED:
					streamEvent = (BorhanStreamEvent) event;
					logger.info("Calling BorhanLiveManager onPublish");
					onPublish(streamEvent.getEntryId(), streamEvent.getServerIndex(), streamEvent.getApplicationName());
					break;
				case STREAM_READY_FOR_PLAYBACK:
					streamEvent = (BorhanStreamEvent) event;
					logger.info("Calling BorhanLiveManager onStreamReadyForPlayback");
					onStreamReadyForPlayback(streamEvent.getEntryId(), streamEvent.getServerIndex());

				default:
					break;
			}
		}
	}

	protected  void onStreamReadyForPlayback(String entryId, final BorhanMediaServerIndex serverIndex) {
		logger.debug("onStreamReadyForPlayback [" + entryId + "]");

		synchronized (entries) {

			if (entries.containsKey(entryId)) {
				entries.get(entryId).setEntryIsLive();
			} else {
				logger.error("entry [" + entryId + "] not found in entries array");
			}
		}
	}

	protected void onPublish(String entryId, final BorhanMediaServerIndex serverIndex, String applicationName) {
		logger.debug("Entry [" + entryId + "]");

		LiveEntryCache liveEntryCache = null;

		synchronized (entries) {

			if (entries.containsKey(entryId)) {
				liveEntryCache = entries.get(entryId);
				liveEntryCache.register(serverIndex, applicationName);
			} else {
				logger.error("entry [" + entryId + "] not found in entries array");
				return;
			}
		}

		onEntryPublished(entryId, liveEntryCache, serverIndex, applicationName);
	}

	protected void onEntryPublished(String entryId, LiveEntryCache liveEntryCache, final BorhanMediaServerIndex serverIndex, String applicationName) {

		if (liveEntryCache == null || liveEntryCache.getLiveEntry() == null) {
			logger.debug("liveEntryCache is null. or getLiveEntry is null");
			return;
		}
		//update the entry cache object with the correct currentBroadcastStartTime
		//lock the entry cache object to ensure only one thread writes the start value
		synchronized (liveEntryCache) {

			logger.debug("onEntryPublished - entryId: " + entryId);
			BorhanLiveEntry liveEntry = liveEntryCache.getLiveEntry();

			//entry cache is already updated
			logger.debug("currentBroadcastStartTime = " + liveEntry.currentBroadcastStartTime);
			if (liveEntry.currentBroadcastStartTime > 0d) {
				return;
			}

			//currentBC time in entryCache is <= 0 -> get the real BC time from the server
			BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
			try {
				BorhanLiveStreamEntry updatedEntry = impersonateClient.getLiveStreamService().get(entryId);

				logger.debug("got updatedEntry from the server. currentBroadcastStartTime = " + updatedEntry.currentBroadcastStartTime);
				//stream has already started - update the entry cache with the start time value
				if (updatedEntry.currentBroadcastStartTime > 0d) {
					logger.debug("currentBroadcastStartTime already set in server - updating liveEntryCache: " + liveEntry.currentBroadcastStartTime);
					updateEntryCache(updatedEntry);
					return;
				}

				//this stream is the first one to broadcast, update the server
				liveEntry.currentBroadcastStartTime = new Date().getTime() / 1000.0;
				logger.debug("currentBroadcastStartTime is not updated in server. updating to value - " + liveEntry.currentBroadcastStartTime);
				boolean isPrimary = BorhanMediaServerIndex.PRIMARY.equals(serverIndex);

				//if the current Wowza is the primary one, update the server
				if (isPrimary) {
					BorhanLiveEntry updatedLiveEntry = liveEntry.getClass().newInstance();
					updatedLiveEntry.currentBroadcastStartTime = liveEntry.currentBroadcastStartTime;
					impersonateClient.getLiveStreamService().update(liveEntry.id, (BorhanLiveStreamEntry) updatedLiveEntry);
					logger.debug("server updated with currentBroadcastStartTime = " + updatedLiveEntry.currentBroadcastStartTime);
				} else {
					logger.debug("current Wowza is not primary. skipping server update.");
				}
			} catch (BorhanApiException e) {
				logger.error("failed to update entry [" + liveEntry.id + "]", e);
			} catch (InstantiationException | IllegalAccessException e) {
				logger.error("failed to instantiate updatedLiveEntry", e);
			}
		}
	}

	public boolean isEntryRegistered(String entryId) {
		boolean entryRegistered = false;
		synchronized (entries) {
			LiveEntryCache liveEntryCache = entries.get(entryId);
			if (liveEntryCache != null)
				entryRegistered = liveEntryCache.isEntryRegistered();
		}

		return entryRegistered;
	}

	public void init() throws BorhanManagerException {

		super.init();
		loadLiveParams();

		isLiveRegistrationMinBufferTime = BorhanLiveManager.DEFAULT_IS_LIVE_REGISTRATION_MIN_BUFFER_TIME * 1000;
		if (serverConfiguration.containsKey(BorhanLiveManager.BORHAN_IS_LIVE_REGISTRATION_MIN_BUFFER_TIME)) {
			isLiveRegistrationMinBufferTime = Long.parseLong((String) serverConfiguration.get(BorhanLiveManager.BORHAN_IS_LIVE_REGISTRATION_MIN_BUFFER_TIME)) * 1000;
		}

		long keepAliveInterval = Long.parseLong((String) serverConfiguration.get(BorhanLiveManager.BORHAN_LIVE_STREAM_KEEP_ALIVE_INTERVAL)) * 1000;

		if (keepAliveInterval > 0) {
			TimerTask setMediaServerTask = new TimerTask() {

				@Override
				public void run() {
					logger.debug("Running scheduled task");
					try {
						synchronized (entries) {
							for (String entryId : entries.keySet()) {
								LiveEntryCache liveEntryCache = entries.get(entryId);
								logger.debug("handling entry " + entryId);
								if (liveEntryCache.isReadyForPlayback()) {
									logger.debug("re-registering media server");
									entryStillAlive(liveEntryCache.getLiveEntry(), liveEntryCache.index);
								}
							}
						}
					}
					catch (Exception e){
						logger.error(e);
					}
				}
			};

			setMediaServerTimer = new Timer("setMediaServerTimer", true);
			setMediaServerTimer.schedule(setMediaServerTask, keepAliveInterval, keepAliveInterval);
			logger.debug("scheduled setMediaServerTask");
		}

		BorhanEventsManager.registerEventConsumer(this, BorhanEventType.STREAM_PUBLISHED);
	}

	private void loadLiveParams() {
		try {
			BorhanFlavorParamsListResponse flavorParamsList = getClient().getFlavorParamsService().list();
			for(BorhanFlavorParams flavorParams : flavorParamsList.objects){
				if(flavorParams instanceof BorhanLiveParams)
					liveAssetParams.put(flavorParams.id, (BorhanLiveParams) flavorParams);
			}
			logger.info("loaded live params [" + liveAssetParams.size() + "]");
		} catch (BorhanApiException e) {
			logger.error("failed to load live params: " + e.getMessage());
		}
	}

	public void stop() {
		setMediaServerTimer.cancel();
		setMediaServerTimer.purge();
	}

	public void appendRecording(String entryId, String assetId, BorhanMediaServerIndex index, String filePath, double duration, boolean isLastChunk) {

		logger.info("Entry [" + entryId + "] asset [" + assetId + "] index [" + index + "] filePath [" + filePath + "] duration [" + duration + "] isLastChunk [" + isLastChunk + "]");

		BorhanLiveEntry liveEntry = get(entryId);
		if(liveEntry == null){
			logger.info("Entry [" + entryId + "] not found");
			return;
		}

		if (serverConfiguration.containsKey(BorhanLiveManager.UPLOAD_XML_SAVE_PATH))
		{
			boolean result = saveUploadAsXml (entryId, assetId, index, filePath, duration, isLastChunk, liveEntry.partnerId);
			if (result) {
				liveEntry.msDuration += duration;
				LiveEntryCache liveEntryCache = entries.get(entryId);
				liveEntryCache.setLiveEntry(liveEntry);
				return;
			}

		}

		BorhanDataCenterContentResource resource = getContentResource(filePath, liveEntry);

		BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
		BorhanServiceBase liveServiceInstance = getLiveServiceInstance(impersonateClient);

		try {

			Method method = liveServiceInstance.getClass().getMethod("appendRecording", String.class, String.class, BorhanMediaServerIndex.class, BorhanDataCenterContentResource.class, double.class, boolean.class);
			BorhanLiveEntry updatedEntry = (BorhanLiveEntry)method.invoke(liveServiceInstance, entryId, assetId, index, resource, duration, isLastChunk);

			if(updatedEntry != null){
				synchronized (entries) {
					LiveEntryCache liveEntryCache = entries.get(entryId);
					if(liveEntryCache != null){
						liveEntryCache.setLiveEntry(updatedEntry);
					}
					else{
						entries.put(entryId, new LiveEntryCache(updatedEntry));
					}
				}
			}
		}
		catch (Exception e) {
			if(e instanceof BorhanApiException && ((BorhanApiException) e).code == BorhanLiveManager.LIVE_STREAM_EXCEEDED_MAX_RECORDED_DURATION){
				logger.info("Entry [" + entryId + "] exceeded max recording duration: " + e.getMessage());
			}
			logger.error("Unexpected error occurred [" + entryId + "]", e);
		}
	}

	protected BorhanDataCenterContentResource getContentResource (String filePath, BorhanLiveEntry liveEntry) {
		if (!this.serverConfiguration.containsKey(BORHAN_WOWZA_SERVER_WORK_MODE) || (this.serverConfiguration.get(BORHAN_WOWZA_SERVER_WORK_MODE).equals(BORHAN_WOWZA_SERVER_WORK_MODE_BORHAN))) {
			BorhanServerFileResource resource = new BorhanServerFileResource();
			resource.localFilePath = filePath;
			return resource;
		}
		else {
			BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
			try {
				impersonateClient.startMultiRequest();
				impersonateClient.getUploadTokenService().add(new BorhanUploadToken());

				File fileData = new File(filePath);
				impersonateClient.getUploadTokenService().upload("{1:result:id}", new BorhanFile(fileData));
				BorhanMultiResponse responses = impersonateClient.doMultiRequest();

				BorhanUploadedFileTokenResource resource = new BorhanUploadedFileTokenResource();
				Object response = responses.get(1);
				if (response instanceof BorhanUploadToken)
					resource.token = ((BorhanUploadToken)response).id;
				else {
					if (response instanceof BorhanApiException) {
					}
					logger.error("Content resource creation error: " + ((BorhanApiException)response).getMessage());
					return null;
				}

				return resource;

			} catch (BorhanApiException e) {
				logger.error("Content resource creation error: " + e.getMessage());
			}
		}

		return null;
	}

	protected void entryStillAlive(BorhanLiveEntry liveEntry, BorhanMediaServerIndex serverIndex) {
		setEntryMediaServer(liveEntry, serverIndex, BorhanLiveEntryStatus.PLAYABLE);
	}

	protected void setEntryMediaServer(BorhanLiveEntry liveEntry, BorhanMediaServerIndex serverIndex, BorhanLiveEntryStatus liveEntryStatus) {
		logger.debug("Register media server [" + hostname + "] partner [" + liveEntry.partnerId + "] entry [" + liveEntry.id + "] index [" + serverIndex.hashCode + "] entry status [" + liveEntryStatus + "]");

		BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
		BorhanServiceBase liveServiceInstance = getLiveServiceInstance(impersonateClient);
		try {
			Method method = liveServiceInstance.getClass().getMethod("registerMediaServer", String.class, String.class, BorhanMediaServerIndex.class, String.class, BorhanLiveEntryStatus.class );
			BorhanLiveEntry updatedEntry = (BorhanLiveEntry)method.invoke(liveServiceInstance, liveEntry.id, hostname, serverIndex, (String)null, liveEntryStatus);

			if(updatedEntry != null){
				synchronized (entries) {
					LiveEntryCache liveEntryCache = entries.get(liveEntry.id);
					if(liveEntryCache != null){
						liveEntryCache.setLiveEntry(updatedEntry);
					}
					else{
						logger.info("Entry [" + liveEntry.id + "] not found in cache, entry info will not be updated");
					}
				}
			}
			else{
				logger.info("updatedEntry is null");
			}

		} catch (Exception e) {
			if (e instanceof InvocationTargetException) {
				Throwable target = ((InvocationTargetException) e).getTargetException();
				logger.error("Unable to register media server [" + liveEntry.id + "]: " + target.getMessage());
				if (target instanceof BorhanApiException && ((BorhanApiException) target).code.equals("SERVICE_FORBIDDEN_CONTENT_BLOCKED")) {
					logger.info("About to disconnect stream " + liveEntry.id);
					this.disconnectStream(liveEntry.id);
				}
			}
			else{
				logger.info("Got exception in setEntryMediaServer " + e);
			}
		}
	}

	protected void unsetEntryMediaServer(BorhanLiveEntry liveEntry, BorhanMediaServerIndex serverIndex) {
		logger.debug("Unregister media server [" + hostname + "] entry [" + liveEntry.id + "] index [" + serverIndex.hashCode + "]");

		BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
		BorhanServiceBase liveServiceInstance = getLiveServiceInstance(impersonateClient);
		try {
			Method method = liveServiceInstance.getClass().getMethod("unregisterMediaServer", String.class, String.class, BorhanMediaServerIndex.class);
			method.invoke(liveServiceInstance, liveEntry.id, hostname, serverIndex);
		} catch (Exception e) {
			logger.error("Unable to unregister media server [" + liveEntry.id + "]: ", e);
		}
	}

	public BorhanLiveEntry reloadEntry(String entryId, int partnerId) {
		BorhanClient impersonateClient = impersonate(partnerId);
		BorhanServiceBase liveServiceInstance = getLiveServiceInstance(impersonateClient);
		BorhanLiveEntry liveEntry;
		try {
			Method method = liveServiceInstance.getClass().getMethod("get", String.class);
			liveEntry = (BorhanLiveEntry)method.invoke(liveServiceInstance, entryId);
		} catch (Exception e) {
			logger.error("BorhanLiveManager::reloadEntry unable to get entry [" + entryId + "]: " + e.getMessage());
			return null;
		}

		synchronized (entries) {
			LiveEntryCache liveEntryCache = entries.get(entryId);
			liveEntryCache.setLiveEntry(liveEntry);
		}

		return liveEntry;
	}

	protected boolean saveUploadAsXml (String entryId, String assetId, BorhanMediaServerIndex index, String filePath, double duration, boolean isLastChunk, int partnerId)
	{
		try {
			DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
			DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
			Document doc = docBuilder.newDocument();
			Element rootElement = doc.createElement("upload");
			doc.appendChild(rootElement);

			// entryId element
			Element entryIdElem = doc.createElement("entryId");
			entryIdElem.appendChild(doc.createTextNode(entryId));
			rootElement.appendChild(entryIdElem);

			// assetId element
			Element assetIdElem = doc.createElement("assetId");
			assetIdElem.appendChild(doc.createTextNode(assetId));
			rootElement.appendChild(assetIdElem);

			// partnerId element
			Element partnerIdElem = doc.createElement("partnerId");
			partnerIdElem.appendChild(doc.createTextNode(Integer.toString(partnerId)));
			rootElement.appendChild(partnerIdElem);

			// index element
			Element indexElem = doc.createElement("index");
			indexElem.appendChild(doc.createTextNode(Integer.toString(index.hashCode)));
			rootElement.appendChild(indexElem);

			// duration element
			Element durationElem = doc.createElement("duration");
			durationElem.appendChild(doc.createTextNode(Double.toString(duration)));
			rootElement.appendChild(durationElem);

			// isLastChunk element
			Element isLastChunkElem = doc.createElement("isLastChunk");
			isLastChunkElem.appendChild(doc.createTextNode(Boolean.toString(isLastChunk)));
			rootElement.appendChild(isLastChunkElem);

			// filepath element
			Element filepathElem = doc.createElement("filepath");
			filepathElem.appendChild(doc.createTextNode(filePath));
			rootElement.appendChild(filepathElem);

			// workmode element
			String workmode = serverConfiguration.containsKey(BorhanLiveManager.BORHAN_WOWZA_SERVER_WORK_MODE) ? (String)serverConfiguration.get(BorhanLiveManager.BORHAN_WOWZA_SERVER_WORK_MODE) : BorhanLiveManager.BORHAN_WOWZA_SERVER_WORK_MODE_BORHAN;
			Element workmodeElem = doc.createElement("workMode");
			workmodeElem.appendChild(doc.createTextNode(workmode));
			rootElement.appendChild(workmodeElem);

			// write the content into xml file
			TransformerFactory transformerFactory = TransformerFactory.newInstance();
			Transformer transformer = transformerFactory.newTransformer();
			DOMSource source = new DOMSource(doc);

			String xmlFilePath = buildXmlFilePath(entryId, assetId);
			StreamResult result = new StreamResult(new File(xmlFilePath));

			// Output to console for testing
			// StreamResult result = new StreamResult(System.out);

			transformer.transform(source, result);

			logger.info("Upload XML saved at: " + xmlFilePath);
			return true;
		}
		catch (Exception e) {
			logger.error("Error occurred creating upload XML: " + e.getMessage());
			return false;
		}
	}

	private String buildXmlFilePath(String entryId, String assetId) {
		StringBuilder sb = new StringBuilder();
		sb.append(serverConfiguration.get(BorhanLiveManager.UPLOAD_XML_SAVE_PATH));
		sb.append("/");
		sb.append(entryId);
		sb.append("_");
		sb.append(assetId);
		sb.append("_");
		sb.append(System.currentTimeMillis());
		sb.append(".xml");
		return sb.toString();
	}


	public void cancelReplace (String entryId) {
		logger.info("Cancel replacement is required");
		BorhanLiveEntry liveEntry = get(entryId);

		BorhanClient impersonateClient = impersonate(liveEntry.partnerId);
		try {
			if (liveEntry.recordedEntryId != null && liveEntry.recordedEntryId.length() > 0) {
				impersonateClient.getMediaService().cancelReplace(liveEntry.recordedEntryId);
			}
		}
		catch (Exception e)
		{
			logger.error("Error occured: " + e.getMessage());
		}
	}

	public void addReferrer(String entryId, ILiveEntryReferrer obj) {
		logger.info("Add [" + obj.getClass().getName() + "] as referrer of ["
				+ entryId + "]");
		synchronized (entries) {
			LiveEntryCache liveEntryCache = entries.get(entryId);
			if (liveEntryCache == null) {
				logger.error("Couldn't add referrer becuase entry doesn't exist in cache");
			} else {
				liveEntryCache.addReferrer(obj);
				logger.info("Referrer added " + obj.getClass().getName());
			}
		}
	}

	public void removeReferrer(String entryId, ILiveEntryReferrer obj) {
		logger.info("Remove [" + obj.getClass().getName()
				+ "] from being referrer of [" + entryId + "]");
		boolean removed = false;
		synchronized (entries) {
			LiveEntryCache liveEntryCache = entries.get(entryId);
			if (liveEntryCache != null) {
				removed = liveEntryCache.removeReferrer(obj);
			}
		}

		if (removed) {
			logger.info("Referrer removed successfully");
		} else {
			logger.error("Failed to remove referrer");
		}
	}
}
