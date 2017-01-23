package com.borhan.media.server.wowza.events;

import com.borhan.client.enums.BorhanMediaServerIndex;
import com.borhan.client.types.BorhanLiveEntry;
import com.borhan.media.server.events.IBorhanEventType;
import com.borhan.media.server.events.BorhanStreamEvent;
import com.wowza.wms.stream.IMediaStream;

public class BorhanMediaStreamEvent extends BorhanStreamEvent {

	public BorhanMediaStreamEvent(IBorhanEventType type, BorhanLiveEntry entry, BorhanMediaServerIndex serverIndex, String applicationName, IMediaStream mediaStream) {
		super(type, entry, serverIndex, applicationName);

		this.mediaStream = mediaStream;
	}

	public BorhanMediaStreamEvent(IBorhanEventType type, BorhanLiveEntry entry, BorhanMediaServerIndex serverIndex, String applicationName, IMediaStream mediaStream, int assetParamsId) {
		this(type, entry, serverIndex, applicationName, mediaStream);

		this.assetParamsId = assetParamsId;
	}

	private IMediaStream mediaStream;
	private int assetParamsId;

	public IMediaStream getMediaStream() {
		return mediaStream;
	}

	public int getAssetParamsId() {
		return assetParamsId;
	}
}
