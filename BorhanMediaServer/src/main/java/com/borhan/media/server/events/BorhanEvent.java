package com.borhan.media.server.events;

public class BorhanEvent implements IBorhanEvent {

	protected IBorhanEventType type;

	public BorhanEvent(IBorhanEventType type) {
		this.type = type;
	}
	
	@Override
	public IBorhanEventType getType() {
		return type;
	}
}
