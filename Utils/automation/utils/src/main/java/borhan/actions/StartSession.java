package borhan.actions;

import com.borhan.client.BorhanApiException;
import com.borhan.client.BorhanClient;
import com.borhan.client.BorhanConfiguration;
import com.borhan.client.enums.BorhanSessionType;

/**
 * Created by asher.saban on 3/8/2015.
 */
public class StartSession {

    public int partnerId;
    public String endPoint;
    public String adminSecret;

    public StartSession(int partnerId, String endPoint, String adminSecret) {
        this.partnerId = partnerId;
        this.endPoint = endPoint;
        this.adminSecret = adminSecret;
    }

    public BorhanClient execute() throws BorhanApiException {

            BorhanConfiguration config = new BorhanConfiguration();
            config.setPartnerId(partnerId);
            config.setEndpoint(endPoint);
            config.setAdminSecret(adminSecret);

            BorhanClient client = new BorhanClient(config);
            String secret = adminSecret;
            String userId = null;
            BorhanSessionType type = BorhanSessionType.ADMIN;
            int expiry = Integer.MAX_VALUE;
            String privileges = null;
            Object result = client.getSessionService().start(secret, userId, type, partnerId, expiry, privileges);
            client.setSessionId(result.toString());
            return client;
    }
}
