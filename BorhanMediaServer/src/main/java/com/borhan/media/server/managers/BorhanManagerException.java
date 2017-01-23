package com.borhan.media.server.managers;

import com.borhan.media.server.BorhanServerException;

@SuppressWarnings("serial")
public class BorhanManagerException extends BorhanServerException {

	public BorhanManagerException(String message) {
		super(message);
	}

	public BorhanManagerException(String message, Throwable throwable) {
		super(message, throwable);
	}
}
