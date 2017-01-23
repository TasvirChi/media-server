<?php
// ===================================================================================================
//                           _  __     _ _
//                          | |/ /__ _| | |_ _  _ _ _ __ _
//                          | ' </ _` | |  _| || | '_/ _` |
//                          |_|\_\__,_|_|\__|\_,_|_| \__,_|
//
// This file is part of the Borhan Collaborative Media Suite which allows users
// to do with audio, video, and animation what Wiki platfroms allow them to do with
// text.
//
// Copyright (C) 2006-2011  Borhan Inc.
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// @ignore
// ===================================================================================================
require_once(dirname(__FILE__) . '/../BorhanClient.php');
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'BorhanTestConfiguration.php');

class TestMain implements IBorhanLogger
{
	public function log($message)
	{
		echo date('Y-m-d H:i:s') . ' ' .  $message . "\n";
	}

	public static function run()
	{
		$test = new TestMain();
		$test->listActions();
		$test->multiRequest();
		$test->add();
		echo "\nFinished running client library tests\n";
	}
	
	private function getBorhanClient($partnerId, $adminSecret, $isAdmin)
	{
		$kConfig = new BorhanConfiguration($partnerId);
		$kConfig->serviceUrl = BorhanTestConfiguration::SERVICE_URL;
		$kConfig->setLogger($this);
		$client = new BorhanClient($kConfig);
		
		$userId = "SomeUser";
		$sessionType = ($isAdmin)? BorhanSessionType::ADMIN : BorhanSessionType::USER; 
		try
		{
			$ks = $client->generateSession($adminSecret, $userId, $sessionType, $partnerId);
			$client->setKs($ks);
		}
		catch(Exception $ex)
		{
			die("could not start session - check configurations in BorhanTestConfiguration class");
		}
		
		return $client;
	}
	
	public function listActions()
	{
		try
		{
			$client = $this->getBorhanClient(BorhanTestConfiguration::PARTNER_ID, BorhanTestConfiguration::ADMIN_SECRET, true);
			$results = $client->media->listAction();
			$entry = $results->objects[0];
			echo "\nGot an entry: [{$entry->name}]";
		}
		catch(Exception $ex)
		{
			die($ex->getMessage());
		}
	}

	public function multiRequest()
	{
		try
		{
			$client = $this->getBorhanClient(BorhanTestConfiguration::PARTNER_ID, BorhanTestConfiguration::ADMIN_SECRET, true);
			$client->startMultiRequest();
			$client->baseEntry->count();
			$client->partner->getInfo();
			$client->partner->getUsage(2011);
			$multiRequest = $client->doMultiRequest();
			$partner = $multiRequest[1];
			if(!is_object($partner) || get_class($partner) != 'BorhanPartner')
			{
				throw new Exception("UNEXPECTED_RESULT");
			}
			echo "\nGot Admin User email: [{$partner->adminEmail}]";
		}
		catch(Exception $ex)
		{
			die($ex->getMessage()); 
		}
	}	

	public function add()
	{
		try 
		{
			echo "\nUploading test video...";
			$client = $this->getBorhanClient(BorhanTestConfiguration::PARTNER_ID, BorhanTestConfiguration::ADMIN_SECRET, false);
			$filePath = BorhanTestConfiguration::UPLOAD_FILE;
			
			$token = $client->baseEntry->upload($filePath);
			$entry = new BorhanMediaEntry();
			$entry->name = "my upload entry";
			$entry->mediaType = BorhanMediaType::VIDEO;
			$newEntry = $client->media->addFromUploadedFile($entry, $token);
			echo "\nUploaded a new Video entry " . $newEntry->id;
			$client->media->delete($newEntry->id);
			try {
				$entry = null;
				$entry = $client->media->get($newEntry->id);
			} catch (BorhanException $exApi) {
				if ($entry == null) {
					echo "\nDeleted the entry (" . $newEntry->id .") successfully!";
				}
			}
		} catch (BorhanException $ex) {
			die($ex->getMessage());
		}	
	}
}

TestMain::run();
