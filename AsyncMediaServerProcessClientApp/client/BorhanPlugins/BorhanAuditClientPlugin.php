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
require_once(dirname(__FILE__) . "/../BorhanClientBase.php");
require_once(dirname(__FILE__) . "/../BorhanEnums.php");
require_once(dirname(__FILE__) . "/../BorhanTypes.php");

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditTrailContext
{
	const CLIENT = -1;
	const SCRIPT = 0;
	const PS2 = 1;
	const API_V3 = 2;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditTrailStatus
{
	const PENDING = 1;
	const READY = 2;
	const FAILED = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditTrailAction
{
	const CHANGED = "CHANGED";
	const CONTENT_VIEWED = "CONTENT_VIEWED";
	const COPIED = "COPIED";
	const CREATED = "CREATED";
	const DELETED = "DELETED";
	const FILE_SYNC_CREATED = "FILE_SYNC_CREATED";
	const RELATION_ADDED = "RELATION_ADDED";
	const RELATION_REMOVED = "RELATION_REMOVED";
	const VIEWED = "VIEWED";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditTrailObjectType
{
	const BATCH_JOB = "BatchJob";
	const EMAIL_INGESTION_PROFILE = "EmailIngestionProfile";
	const FILE_SYNC = "FileSync";
	const KSHOW_KUSER = "KshowKuser";
	const METADATA = "Metadata";
	const METADATA_PROFILE = "MetadataProfile";
	const PARTNER = "Partner";
	const PERMISSION = "Permission";
	const UPLOAD_TOKEN = "UploadToken";
	const USER_LOGIN_DATA = "UserLoginData";
	const USER_ROLE = "UserRole";
	const ACCESS_CONTROL = "accessControl";
	const CATEGORY = "category";
	const CONVERSION_PROFILE_2 = "conversionProfile2";
	const ENTRY = "entry";
	const FLAVOR_ASSET = "flavorAsset";
	const FLAVOR_PARAMS = "flavorParams";
	const FLAVOR_PARAMS_CONVERSION_PROFILE = "flavorParamsConversionProfile";
	const FLAVOR_PARAMS_OUTPUT = "flavorParamsOutput";
	const KSHOW = "kshow";
	const KUSER = "kuser";
	const MEDIA_INFO = "mediaInfo";
	const MODERATION = "moderation";
	const ROUGHCUT = "roughcutEntry";
	const SYNDICATION = "syndicationFeed";
	const THUMBNAIL_ASSET = "thumbAsset";
	const THUMBNAIL_PARAMS = "thumbParams";
	const THUMBNAIL_PARAMS_OUTPUT = "thumbParamsOutput";
	const UI_CONF = "uiConf";
	const WIDGET = "widget";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditTrailOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const PARSED_AT_ASC = "+parsedAt";
	const CREATED_AT_DESC = "-createdAt";
	const PARSED_AT_DESC = "-parsedAt";
}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAuditTrailBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $idEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $createdAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $createdAtLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $parsedAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $parsedAtLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var BorhanAuditTrailStatus
	 */
	public $statusEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $statusIn = null;

	/**
	 * 
	 *
	 * @var BorhanAuditTrailObjectType
	 */
	public $auditObjectTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $auditObjectTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $objectIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $objectIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $relatedObjectIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $relatedObjectIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanAuditTrailObjectType
	 */
	public $relatedObjectTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $relatedObjectTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $entryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $entryIdIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $masterPartnerIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $masterPartnerIdIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $partnerIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $requestIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $requestIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $userIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $userIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanAuditTrailAction
	 */
	public $actionEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $actionIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $ksEqual = null;

	/**
	 * 
	 *
	 * @var BorhanAuditTrailContext
	 */
	public $contextEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $contextIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $entryPointEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $entryPointIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $serverNameEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $serverNameIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $ipAddressEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $ipAddressIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $clientTagEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditTrailFilter extends BorhanAuditTrailBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAuditClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanAuditClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanAuditClientPlugin($client);
	}

	/**
	 * @return array<BorhanServiceBase>
	 */
	public function getServices()
	{
		$services = array(
		);
		return $services;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'audit';
	}
}

