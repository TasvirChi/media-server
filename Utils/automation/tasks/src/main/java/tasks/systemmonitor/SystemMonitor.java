package tasks.systemmonitor;

import java.net.URL;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;

import borhan.actions.StartSession;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.enums.BorhanLiveStreamEntryOrderBy;
import com.borhan.client.enums.BorhanNullableBoolean;
import com.borhan.client.types.BorhanFilterPager;
import com.borhan.client.types.BorhanLiveStreamEntry;
import com.borhan.client.types.BorhanLiveStreamEntryFilter;
import com.borhan.client.types.BorhanLiveStreamListResponse;

import configurations.ConfigurationReader;
import configurations.TestConfig;

/**
 * This class monitors the system:
 * For each live entry in the system it creates a downloading thread
 * and comparator thread.
 */
public class SystemMonitor {

	private static final DateFormat dateFormat = new SimpleDateFormat("yyyy_MM_dd_HH_mm_ss");
	private TestConfig config;
	private StartSession session;
	private BorhanClient client;
	
	public static void main(String[] args) throws Exception {
		SystemMonitor monitor = new SystemMonitor();
		monitor.execute();
	}
	 
	public void execute() throws Exception {
		config = getTestConfiguration("batch-conf.json");
		int partnerId = Integer.valueOf(config.getPartnerId());
		List<String> syncEntries = config.getSyncEntries();
		
		session = new StartSession(partnerId,
				config.getServiceUrl(), config.getAdminSecret());
		client = session.execute();
		
		System.out.println("Loaded!");
		
		Set<String> entries = new HashSet<String>();

		while(true) {
			System.out.println("...");
			Map<String, Integer> curEntries = getEntries();
			for (Entry<String, Integer> entry : curEntries.entrySet()) {
				if(!entries.contains(entry.getKey())) {
					// Create downloaders threads
					System.out.println("### Create new thread for entry - " + entry.getKey());
					String downloadDir = createDefaultDownloadDir(config,  entry.getKey());
					
					EntryDownloader downloader = new EntryDownloader(config, entry.getValue(), entry.getKey(), syncEntries.contains(entry.getKey()));
					downloader.setDownloadDir(downloadDir);
					(new Thread(downloader, "Downloader_" + entry.getKey())).start();
					EntryComparator comparator = new EntryComparator(config, downloader, entry.getKey(), downloadDir);
					(new Thread(comparator, "Comparator_" + entry.getKey())).start();
				}
			}
			
			entries = curEntries.keySet();
			Thread.sleep(60*1000);
		}
	}
	
	private String createDefaultDownloadDir(TestConfig config, String entryId) {
		String reportDate = dateFormat.format(new Date());
		return config.getDestinationFolder() + "/" + entryId + "/" + reportDate;
	}
	
	private TestConfig getTestConfiguration(String configFileName)
			throws Exception {
		// read configuration file:
		URL u = getClass().getResource("/" + configFileName);
		if (u == null) {
			throw new Exception("Configuration file: " + configFileName
					+ " not found.");
		} 
		return ConfigurationReader.getTestConfigurations(u.getPath());
    }
	
	private Map<String, Integer> getEntries() throws BorhanApiException {
		Map<String, Integer> result = new HashMap<String, Integer>();
		
		BorhanLiveStreamEntryFilter filter = new BorhanLiveStreamEntryFilter();
		filter.isLive = BorhanNullableBoolean.TRUE_VALUE;
		filter.orderBy = BorhanLiveStreamEntryOrderBy.CREATED_AT_ASC.getHashCode();
		
		BorhanFilterPager pager = new BorhanFilterPager();
		pager.pageSize = 500;
		pager.pageIndex = 1;
		
		while(true) {
			BorhanLiveStreamListResponse entries = null;
			
			try {
				entries = client.getLiveStreamService().list(filter, pager);
			} catch (BorhanApiException e) {
				if("INVALID_KS".equals(e.code)) {
					client = session.execute();
					continue;
				} else {
					throw e;
				}
			}
			for(BorhanLiveStreamEntry entry : entries.objects) {
				result.put(entry.id, entry.partnerId);
				filter.createdAtGreaterThanOrEqual = entry.createdAt;
			}
			
			pager.pageIndex++;
			if(entries.totalCount < 500)
				break;
		}
		return result;
	}
	
}