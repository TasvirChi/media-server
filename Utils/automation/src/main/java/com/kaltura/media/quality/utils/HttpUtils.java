package com.kaltura.media.quality.utils;

import org.apache.commons.io.FileUtils;
import org.apache.http.HttpEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;
import org.apache.log4j.Logger;

import java.io.File;
import java.io.IOException;
import java.net.URL;

/**
 * Created by asher.saban on 2/17/2015.
 */
public class HttpUtils {

    private static final Logger log = Logger.getLogger(HttpUtils.class);

    /**
     * user should close the httpClient in a finally block
     * @return
     */
    public static CloseableHttpClient getHttpClient() {
        return HttpClients.createDefault();
    }

    public static String doGetRequest(CloseableHttpClient httpClient, String url) throws Exception {
        HttpGet httpGet = new HttpGet(url);
        CloseableHttpResponse response = null;
        try {
            response = httpClient.execute(httpGet);

            if (response.getStatusLine().getStatusCode() != 200 && response.getStatusLine().getStatusCode() != 201) {
                throw new Exception("get request failed. error code: " + response.getStatusLine().getStatusCode());
            }

            HttpEntity entity = response.getEntity();
            String body = EntityUtils.toString(entity, "UTF-8");
            EntityUtils.consume(entity);
            return body;
        } finally {
            try {
                if (response != null) {
                    response.close();
                }
            } catch (IOException e) {
            }
        }
    }

    public static File downloadFile(String url, String destinationPath) throws IOException {
        url = url.trim();
        destinationPath = destinationPath.trim();

        File f = new File(destinationPath);
        URL urlObj = new URL(url);

        log.info("Downloading file: " + url);
        log.info("Destination: " + destinationPath);
        FileUtils.copyURLToFile(urlObj, f);
        log.info("File downloaded successfully");
        
        return f;
    }
}