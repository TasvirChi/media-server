package com.kaltura.media.quality.utils;

import java.lang.management.ManagementFactory;
import java.lang.management.ThreadMXBean;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.concurrent.CancellationException;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;
import java.util.concurrent.FutureTask;
import java.util.concurrent.TimeUnit;

import org.apache.log4j.Logger;

import com.kaltura.media.quality.configurations.TestConfig;

public class ThreadManager {
	private static final Logger log = Logger.getLogger(ThreadManager.class);
	private static ExecutorService executor  = init();
	private static Map<String, List<FutureTask<String>>> pools = new HashMap<String, List<FutureTask<String>>>();
	private static List<Future<String>> workers = Collections.synchronizedList(new ArrayList<Future<String>>());
	private static long endTime; 
	private static Boolean stopped = false; 
	private static Boolean shouldRunForever = false;
	
	private static ExecutorService init(){
		TestConfig config = TestConfig.get();

		long duration = config.getTestDuration() * 1000;
		endTime = System.currentTimeMillis() + duration;
		
		int numberOfThreads = 1000;
		if(config.hasOtherProperty("number-of-threads")){
			numberOfThreads = (int) config.getOtherProperty("number-of-threads");
		}
//		return Executors.newCachedThreadPool();
		return Executors.newFixedThreadPool(numberOfThreads);
	}
	
	public static void start(String poolName, Runnable worker){
		synchronized (stopped) {
			if(!shouldContinue()){
				return;
			}
			
			FutureTask<String> task = new FutureTask<String>(worker, null);
			List<FutureTask<String>> pool;
			if(pools.containsKey(poolName)){
				pool = pools.get(poolName);
			}
			else{
				pool = Collections.synchronizedList(new ArrayList<FutureTask<String>>());
				pools.put(poolName, pool);
			}
				
			pool.add(task);
			workers.add(task);
			executor.execute(task);
		}
	}
	
	@SuppressWarnings("unchecked")
	public static void start(Runnable worker){
		synchronized (stopped) {
			if(!shouldContinue()){
				return;
			}
			
			if(worker instanceof Future){
				workers.add((Future<String>) worker);
			}
			executor.execute(worker);
		}
	}

	public static boolean shouldContinue() {
		synchronized (shouldRunForever) {
			if(shouldRunForever){
				return true;
			}
		}
		synchronized (stopped) {
			return (!stopped) && (System.currentTimeMillis() < endTime);
		}
	}

	public static long leftTimeToRun() {
		return endTime - System.currentTimeMillis();
	}

	public static void stop(String poolName) {
		stop(poolName, true);
	}

	public static void stop(String poolName, boolean mayInterruptIfRunning) {
		if(!pools.containsKey(poolName)){
			return;
		}

		List<FutureTask<String>> pool = pools.get(poolName);
		for(FutureTask<String> worker : pool){
			worker.cancel(mayInterruptIfRunning);
		}

		for(FutureTask<String> worker : pool){
			try {
				worker.get();
			} catch (InterruptedException | ExecutionException | CancellationException e) {
			}
		}
	}

	public static void stop() {
		synchronized (stopped) {
			stopped = true;
			
			for(Future<String> worker : workers){
				worker.cancel(true);
			}
			executor.shutdown();
		}
		
		try {
			executor.awaitTermination(30, TimeUnit.SECONDS);
		} catch (InterruptedException e) {
			log.error(e.getMessage(), e); 
		}
	}

	static public void printAllThreads(){
		Thread[] threads = getAllThreads();
		for(Thread thread : threads){
			log.warn("Thread " + thread.getName() + " is still alive: \n" + getStackTraceMessage(thread));
		}
	}

	static protected String getStackTraceMessage(Thread thread) {
		String message = "";
		
        StackTraceElement[] trace = thread.getStackTrace();
        for (StackTraceElement traceElement : trace)
        	message += "\tat " + traceElement + "\n";
        
        return message;
    }
    
	static protected ThreadGroup getRootThreadGroup( ) {
	    ThreadGroup tg = Thread.currentThread( ).getThreadGroup( );
	    ThreadGroup ptg;
	    while ( (ptg = tg.getParent( )) != null )
	        tg = ptg;
	    return tg;
	}
	
	static protected Thread[] getAllThreads( ) {
	    final ThreadGroup root = getRootThreadGroup( );
	    final ThreadMXBean thbean = ManagementFactory.getThreadMXBean( );
	    int nAlloc = thbean.getThreadCount( );
	    int n = 0;
	    Thread[] threads;
	    do {
	        nAlloc *= 2;
	        threads = new Thread[ nAlloc ];
	        n = root.enumerate( threads, true );
	    } while ( n == nAlloc );
	    return java.util.Arrays.copyOf( threads, n );
	}

	public static void runForever() {
		synchronized (shouldRunForever) {
			shouldRunForever = true;
		}
	}
}