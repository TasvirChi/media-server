package com.borhan.media.server.red5;

import java.io.File;
import java.io.IOException;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.attribute.GroupPrincipal;
import java.nio.file.attribute.PosixFileAttributeView;
import java.nio.file.attribute.UserPrincipalLookupService;

import org.red5.server.stream.ServerStream;

import com.borhan.client.BorhanApiException;
import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.types.BorhanLiveStreamEntry;
import com.borhan.client.types.BorhanServerFileResource;
import com.borhan.media.server.BorhanLiveStreamManager;
import com.borhan.media.server.BorhanManagerException;
import com.borhan.media.server.BorhanServer;

public class LiveStreamManager extends BorhanLiveStreamManager {

	protected final static String BORHAN_RECORDED_FILE_GROUP = "BorhanRecordedFileGroup";
	protected final static String DEFAULT_RECORDED_FILE_GROUP = "borhan";


	protected GroupPrincipal group;

	@Override
	public void init() throws BorhanManagerException {
		super.init();

		if (!BorhanServer.isWindows()) {
			String groupName = LiveStreamManager.DEFAULT_RECORDED_FILE_GROUP;
			if (serverConfiguration.containsKey(LiveStreamManager.BORHAN_RECORDED_FILE_GROUP))
				groupName = (String) serverConfiguration.get(LiveStreamManager.BORHAN_RECORDED_FILE_GROUP);

			UserPrincipalLookupService lookupService = FileSystems.getDefault().getUserPrincipalLookupService();
			try {
				group = lookupService.lookupPrincipalByGroupName(groupName);
			} catch (IOException e) {
				throw new BorhanManagerException("Group [" + groupName + "] not found", e);
			}
		}

		hostname = BorhanServer.getHostName();
		client = BorhanServer.getClient();
	}

	@Override
	public void restartRecordings() {
		logger.error("LiveStreamEntry::restartRecordings is not supported");
	}

	protected boolean restartRecording(String entryId) {
		logger.error("LiveStreamEntry::restartRecording: is not supported [" + entryId + "]");

		return false;
	}

	public void onPublish(BorhanLiveStreamEntry liveStreamEntry, BorhanMediaServerIndex serverIndex, ServerStream stream) {
		logger.debug("LiveStreamManager::onPublish: " + liveStreamEntry.id);

		try {
			stream.saveAs(liveStreamEntry.id, true);
		} catch (Exception e) {
			logger.error("LiveStreamManager::onPublish: Failed saving stream [" + liveStreamEntry.id + "]:" + e.getMessage());
			return;
		}

		logger.info("LiveStreamManager::onPublish: Saving stream [" + stream.getSaveFilename() + "]");
	}

	public void onUnPublish(BorhanLiveStreamEntry liveStreamEntry, BorhanMediaServerIndex serverIndex, ServerStream stream) {
		logger.info("LiveStreamManager::onUnPublish: stream [" + stream.getPublishedName() + "]");
		
		if(stream.getSaveFilename() != null){
			logger.info("LiveStreamManager::onUnPublish: file [" + stream.getSaveFilename() + "]");

			File file = new File(stream.getSaveFilename());
	if(group != null){
		Path path = Paths.get(file.getAbsolutePath());
		PosixFileAttributeView fileAttributes = Files.getFileAttributeView(path, PosixFileAttributeView.class);
			
		try {
			fileAttributes.setGroup(group);
		} catch (IOException e) {
			logger.error(e.getMessage());
		}}
		
		BorhanServerFileResource resource = new BorhanServerFileResource();
		resource.localFilePath = file.getAbsolutePath();
		
		impersonate(liveStreamEntry.partnerId);
		try {
			client.getLiveStreamService().appendRecording(liveStreamEntry.id, serverIndex, resource, -1);
		} catch (BorhanApiException e) {
			logger.error("Append live stream recording error: " + e.getMessage());
		}
		unimpersonate();
		
		if(serverIndex == BorhanMediaServerIndex.PRIMARY)
			createMediaEntryOrAppend(liveStreamEntry);
		}
		
		super.onUnPublish(liveStreamEntry, serverIndex);
	}

	@Override
	public boolean splitRecordingNow(String entryId) {
		return restartRecording(entryId);
	}
}
