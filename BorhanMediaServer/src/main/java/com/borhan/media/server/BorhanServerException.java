package com.borhan.media.server;

@SuppressWarnings("serial")
public class BorhanServerException extends Exception {

	public BorhanServerException(String message) {
		super(message);
	}

	public BorhanServerException(String message, Throwable throwable) {
		super(message, throwable);
	}
}
