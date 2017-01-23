<?php

require_once('/opt/borhan/app/clients/php5/BorhanClient.php');

$xml_file_path="/usr/local/WowzaStreamingEngine/conf/Server.xml";


/**
 * @param $xml_file_path
 * @param $admin_secret
 * @return BorhanClient
 */
function initClient ($xml_file_path, $admin_secret) {
    $config = new BorhanConfiguration();
    $config->serviceUrl = getValueFromXml($xml_file_path,"Server/Properties/Property[1]/Value").'/';
    $client = new BorhanClient($config);
    $result = $client->session->start($admin_secret, null, BorhanSessionType::ADMIN, -5, null, null);
    $client->setKs($result);
    return $client;
}


/**
 * @param $xml_file_path
 * @param $client
 */
function registerMediaServer ($xml_file_path, $client) {
    $sys_hostname = php_uname('n');
    $media_server_tag = "_media_server";
    $media_server_default_port = 1935;
    $media_server_default_protocol = "http";

    $config = new BorhanConfiguration();
    $config->serviceUrl = getValueFromXml($xml_file_path,"Server/Properties/Property[1]/Value").'/';
    $serverNode = new BorhanWowzaMediaServerNode();
    $serverNode->name = $sys_hostname.$media_server_tag;
    $serverNode->systemName = '';
    $serverNode->description = '';
    $serverNode->hostName = $sys_hostname;
    $serverNode->liveServicePort = $media_server_default_port;
    $serverNode->liveServiceProtocol = $media_server_default_protocol;
    try {
        (array)$res = $client->serverNode->add($serverNode);
    } catch (BorhanException $ex) {
        logToFIle('The server ['.$sys_hostname.'] is already registered.');
        print PHP_EOL;
        exit (0);
    }
    $client->serverNode->enable($res->id);
    logToFIle ('['.php_uname('n')."] registered with id: ".$res->id.PHP_EOL);
}

function logToFIle ($message) {
    print $message;
}


/**
 * @param $xml_file
 * @param $xml_path
 * @return SimpleXMLElement
 */
function getValueFromXml ($xml_file, $xml_path) {
    $xml = simplexml_load_file($xml_file);
    $result = $xml->xpath($xml_path);
    return $result[0];
}

// main
$xml_admin_secret = getValueFromXml($xml_file_path, "Server/Properties/Property[2]/Value");
$new_client = initClient($xml_file_path, $xml_admin_secret);
registerMediaServer ($xml_file_path, $new_client);

