package com.borhan.media.server.events;

public enum BorhanEventType implements IBorhanEventType {
	STREAM_PUBLISHED,
	STREAM_UNPUBLISHED,
	STREAM_DISCONNECTED,
	METADATA,
	STREAM_READY_FOR_PLAYBACK
}
