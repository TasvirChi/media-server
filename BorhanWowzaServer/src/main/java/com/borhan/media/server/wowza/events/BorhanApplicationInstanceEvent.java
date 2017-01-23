package com.borhan.media.server.wowza.events;

import com.borhan.media.server.events.IBorhanEventType;
import com.borhan.media.server.events.BorhanEvent;
import com.wowza.wms.application.IApplicationInstance;

public class BorhanApplicationInstanceEvent extends BorhanEvent {

	public BorhanApplicationInstanceEvent(IBorhanEventType type, IApplicationInstance applicationInstance) {
		super(type);

		this.applicationInstance = applicationInstance;
	}

	private IApplicationInstance applicationInstance;

	public IApplicationInstance getApplicationInstance() {
		return applicationInstance;
	}
}
