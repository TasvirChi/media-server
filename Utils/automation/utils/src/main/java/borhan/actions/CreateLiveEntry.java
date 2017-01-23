package borhan.actions;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.enums.BorhanDVRStatus;
import com.borhan.client.enums.BorhanMediaType;
import com.borhan.client.enums.BorhanRecordStatus;
import com.borhan.client.enums.BorhanSourceType;
import com.borhan.client.types.BorhanLiveStreamEntry;
import utils.StringUtils;

/**
 * Created by asher.saban on 3/8/2015.
 */
public class CreateLiveEntry {

    private BorhanClient client;
    private String name;
    private boolean isDvr;
    private boolean isRecording;
    private boolean isRandom;
    private int conversionProfileId;

    public CreateLiveEntry(BorhanClient client, String name, boolean isRandom, boolean isDvr, boolean isRecording, int conversionProfileId) {
        this.client = client;
        this.name = name;
        this.isDvr = isDvr;
        this.isRecording = isRecording;
        if (isRandom) {
            this.name += StringUtils.generateRandomSuffix();
        }
        this.conversionProfileId = conversionProfileId;
    }

    public BorhanLiveStreamEntry execute() throws BorhanApiException {
        BorhanLiveStreamEntry liveStreamEntry = new BorhanLiveStreamEntry();
        liveStreamEntry.name = name;
        liveStreamEntry.mediaType = BorhanMediaType.LIVE_STREAM_FLASH;
        liveStreamEntry.sourceType = BorhanSourceType.LIVE_STREAM;
        liveStreamEntry.dvrStatus = isDvr ? BorhanDVRStatus.ENABLED : BorhanDVRStatus.DISABLED;
        liveStreamEntry.recordStatus = isRecording ? BorhanRecordStatus.ENABLED : BorhanRecordStatus.DISABLED;
        liveStreamEntry.conversionProfileId = conversionProfileId;
        BorhanSourceType sourceType = null;
        Object result = client.getLiveStreamService().add(liveStreamEntry, sourceType);
        return (BorhanLiveStreamEntry) result;
    }
}
