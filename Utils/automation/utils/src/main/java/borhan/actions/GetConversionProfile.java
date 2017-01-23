package borhan.actions;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.types.BorhanConversionProfile;

/**
 * Created by asher.saban on 3/8/2015.
 */
public class GetConversionProfile {

    private int id;
    private BorhanClient client;

    public BorhanConversionProfile execute() throws BorhanApiException {
        return client.getConversionProfileService().get(id);
    }
}
