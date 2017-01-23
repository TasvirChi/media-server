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

/**
 * @package Borhan
 * @subpackage Client
 */
require_once(dirname(__FILE__) . "/BorhanClientBase.php");
require_once(dirname(__FILE__) . "/BorhanEnums.php");
require_once(dirname(__FILE__) . "/BorhanTypes.php");


/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamService extends BorhanServiceBase
{
	function __construct(BorhanClient $client = null)
	{
		parent::__construct($client);
	}

	/**
	 * Get live stream entry by ID.
	 * 
	 * @param string $entryId Live stream entry id
	 * @param int $version Desired version of the data
	 * @return BorhanLiveStreamEntry
	 */
	function get($entryId, $version = -1)
	{
		$kparams = array();
		$this->client->addParam($kparams, "entryId", $entryId);
		$this->client->addParam($kparams, "version", $version);
		$this->client->queueServiceActionCall("livestream", "get", $kparams);
		if ($this->client->isMultiRequest())
			return $this->client->getMultiRequestResult();
		$resultObject = $this->client->doQueue();
		$this->client->throwExceptionIfError($resultObject);
		$this->client->validateObjectType($resultObject, "BorhanLiveStreamEntry");
		return $resultObject;
	}

	/**
	 * Append recorded video to live entry
	 * 
	 * @param string $entryId Live entry id
	 * @param string $assetId Live asset id
	 * @param int $mediaServerIndex 
	 * @param BorhanDataCenterContentResource $resource 
	 * @param float $duration In seconds
	 * @param bool $isLastChunk Is this the last recorded chunk in the current session (i.e. following a stream stop event)
	 * @return BorhanLiveEntry
	 */
	function appendRecording($entryId, $assetId, $mediaServerIndex, BorhanDataCenterContentResource $resource, $duration, $isLastChunk = false)
	{
		$kparams = array();
		$this->client->addParam($kparams, "entryId", $entryId);
		$this->client->addParam($kparams, "assetId", $assetId);
		$this->client->addParam($kparams, "mediaServerIndex", $mediaServerIndex);
		$this->client->addParam($kparams, "resource", $resource->toParams());
		$this->client->addParam($kparams, "duration", $duration);
		$this->client->addParam($kparams, "isLastChunk", $isLastChunk);
		$this->client->queueServiceActionCall("livestream", "appendRecording", $kparams);
		if ($this->client->isMultiRequest())
			return $this->client->getMultiRequestResult();
		$resultObject = $this->client->doQueue();
		$this->client->throwExceptionIfError($resultObject);
		$this->client->validateObjectType($resultObject, "BorhanLiveEntry");
		return $resultObject;
	}
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUploadTokenService extends BorhanServiceBase
{
	function __construct(BorhanClient $client = null)
	{
		parent::__construct($client);
	}

	/**
	 * Adds new upload token to upload a file
	 * 
	 * @param BorhanUploadToken $uploadToken 
	 * @return BorhanUploadToken
	 */
	function add(BorhanUploadToken $uploadToken = null)
	{
		$kparams = array();
		if ($uploadToken !== null)
			$this->client->addParam($kparams, "uploadToken", $uploadToken->toParams());
		$this->client->queueServiceActionCall("uploadtoken", "add", $kparams);
		if ($this->client->isMultiRequest())
			return $this->client->getMultiRequestResult();
		$resultObject = $this->client->doQueue();
		$this->client->throwExceptionIfError($resultObject);
		$this->client->validateObjectType($resultObject, "BorhanUploadToken");
		return $resultObject;
	}

	/**
	 * Upload a file using the upload token id, returns an error on failure (an exception will be thrown when using one of the Borhan clients)
	 * 
	 * @param string $uploadTokenId 
	 * @param file $fileData 
	 * @param bool $resume 
	 * @param bool $finalChunk 
	 * @param float $resumeAt 
	 * @return BorhanUploadToken
	 */
	function upload($uploadTokenId, $fileData, $resume = false, $finalChunk = true, $resumeAt = -1)
	{
		$kparams = array();
		$this->client->addParam($kparams, "uploadTokenId", $uploadTokenId);
		$kfiles = array();
		$this->client->addParam($kfiles, "fileData", $fileData);
		$this->client->addParam($kparams, "resume", $resume);
		$this->client->addParam($kparams, "finalChunk", $finalChunk);
		$this->client->addParam($kparams, "resumeAt", $resumeAt);
		$this->client->queueServiceActionCall("uploadtoken", "upload", $kparams, $kfiles);
		if ($this->client->isMultiRequest())
			return $this->client->getMultiRequestResult();
		$resultObject = $this->client->doQueue();
		$this->client->throwExceptionIfError($resultObject);
		$this->client->validateObjectType($resultObject, "BorhanUploadToken");
		return $resultObject;
	}
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanClient extends BorhanClientBase
{
	/**
	 * @var string
	 */
	protected $apiVersion = '3.1.6';

	/**
	 * Live Stream service lets you manage live stream entries
	 * @var BorhanLiveStreamService
	 */
	public $liveStream = null;

	/**
	 * 
	 * @var BorhanUploadTokenService
	 */
	public $uploadToken = null;

	/**
	 * Borhan client constructor
	 *
	 * @param BorhanConfiguration $config
	 */
	public function __construct(BorhanConfiguration $config)
	{
		parent::__construct($config);
		
		$this->liveStream = new BorhanLiveStreamService($this);
		$this->uploadToken = new BorhanUploadTokenService($this);
	}
	
}

