package com.borhan.media.server;

import java.util.HashMap;
import java.util.HashSet;
import java.util.Map;
import java.util.Set;
import java.util.Timer;
import java.util.TimerTask;

import org.apache.log4j.Logger;

import com.borhan.media.server.events.IBorhanEvent;
import com.borhan.media.server.events.IBorhanEventConsumer;
import com.borhan.media.server.events.IBorhanEventType;


public class BorhanEventsManager{

	protected static Logger logger = Logger.getLogger(BorhanEventsManager.class);
	static Map<IBorhanEventType, Set<IBorhanEventConsumer>> map = new HashMap<IBorhanEventType, Set<IBorhanEventConsumer>>();
	
	public static void registerEventConsumer(IBorhanEventConsumer eventConsumer, IBorhanEventType ... eventTypes){
		Set<IBorhanEventConsumer> consumersMap = null;
		
		for(IBorhanEventType eventType : eventTypes){
			logger.info("Attempting to register event consumer [" + eventConsumer.toString() + "] for event types: [" + eventType.toString() + "]");
			if(map.containsKey(eventType)){
				consumersMap = map.get(eventType);
			}
			else{
				consumersMap = new HashSet<IBorhanEventConsumer>();
				map.put(eventType, consumersMap);
			}
			consumersMap.add(eventConsumer);
		}
		
	}

	public static void raiseEvent(final IBorhanEvent event){
		logger.info("Raising event of type [" + event.getType() + "]");
		Set<IBorhanEventConsumer> consumersMap = map.get(event.getType());
		if (consumersMap == null)
			return;
			
		for(final IBorhanEventConsumer eventConsumer : consumersMap) {
			TimerTask timerTask = new TimerTask() {
				
				@Override
				public void run() {
					if(map.containsKey(event.getType())){
						eventConsumer.onEvent(event);
					}
				}
			};
			
			Timer timer = new Timer(true);
			timer.schedule(timerTask, 0);
		}
	}
}
