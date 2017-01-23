package com.borhan.media.server.managers;


public interface IManager {

	public void init() throws BorhanManagerException;

	public void stop();
}
