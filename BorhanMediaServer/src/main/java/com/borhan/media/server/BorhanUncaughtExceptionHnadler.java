package com.borhan.media.server;

import org.apache.log4j.Logger;

/**
 * Created by asher.saban on 4/14/2015.
 */
public class BorhanUncaughtExceptionHnadler implements Thread.UncaughtExceptionHandler{
		private static Logger log = Logger.getLogger(BorhanUncaughtExceptionHnadler.class);

		public void uncaughtException(Thread t, Throwable ex) {
			log.error("Uncaught exception in thread: " + t.getName(), ex);
		}
}
