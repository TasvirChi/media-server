package com.borhan.media.server.events;

import com.borhan.client.BorhanObjectBase;
import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.types.BorhanLiveEntry;

public class BorhanMetadataEvent extends BorhanStreamEvent {

	private BorhanObjectBase object;

	public BorhanMetadataEvent(IBorhanEventType type, BorhanLiveEntry entry, BorhanMediaServerIndex serverIndex, BorhanObjectBase object) {
		super(type, entry, serverIndex);

		this.object = object;
	}

	public BorhanObjectBase getObject() {
		return object;
	}
}
