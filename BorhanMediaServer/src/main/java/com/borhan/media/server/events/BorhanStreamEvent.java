package com.borhan.media.server.events;

import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.types.BorhanLiveEntry;

public class BorhanStreamEvent extends BorhanEvent {

	private BorhanLiveEntry entry;
	private BorhanMediaServerIndex serverIndex;
	private String applicationName;

	public BorhanStreamEvent(IBorhanEventType type, BorhanLiveEntry entry) {
		super(type);
		
		this.entry = entry;
	}
	
	public BorhanStreamEvent(IBorhanEventType type, BorhanLiveEntry entry, BorhanMediaServerIndex serverIndex) {
		this(type, entry);
		this.serverIndex = serverIndex;
	}
	
	public BorhanStreamEvent(IBorhanEventType type, BorhanLiveEntry entry, BorhanMediaServerIndex serverIndex, String applicationName) {
		this(type, entry, serverIndex);
		this.applicationName = applicationName;
	}
	
	public String getEntryId() {
		return entry.id;
	}

	public BorhanLiveEntry getEntry() {
		return entry;
	}

	public BorhanMediaServerIndex getServerIndex() {
		return serverIndex;
	}

	public String getApplicationName() {
		return applicationName;
	}
}
