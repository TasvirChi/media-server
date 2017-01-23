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
class BorhanMetadataProfileCreateMode
{
	const API = 1;
	const BMC = 2;
	const APP = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataProfileStatus
{
	const ACTIVE = 1;
	const DEPRECATED = 2;
	const TRANSFORMING = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataStatus
{
	const VALID = 1;
	const INVALID = 2;
	const DELETED = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataObjectType
{
	const AD_CUE_POINT = "adCuePointMetadata.AdCuePoint";
	const ANNOTATION = "annotationMetadata.Annotation";
	const CODE_CUE_POINT = "codeCuePointMetadata.CodeCuePoint";
	const THUMB_CUE_POINT = "thumbCuePointMetadata.thumbCuePoint";
	const ENTRY = "1";
	const CATEGORY = "2";
	const USER = "3";
	const PARTNER = "4";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const METADATA_PROFILE_VERSION_ASC = "+metadataProfileVersion";
	const UPDATED_AT_ASC = "+updatedAt";
	const VERSION_ASC = "+version";
	const CREATED_AT_DESC = "-createdAt";
	const METADATA_PROFILE_VERSION_DESC = "-metadataProfileVersion";
	const UPDATED_AT_DESC = "-updatedAt";
	const VERSION_DESC = "-version";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataProfileOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const UPDATED_AT_ASC = "+updatedAt";
	const CREATED_AT_DESC = "-createdAt";
	const UPDATED_AT_DESC = "-updatedAt";
}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMetadataBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerIdEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $metadataProfileIdEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $metadataProfileVersionEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $metadataProfileVersionGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $metadataProfileVersionLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var BorhanMetadataObjectType
	 */
	public $metadataObjectTypeEqual = null;

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
	 * @var int
	 */
	public $versionEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $versionGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $versionLessThanOrEqual = null;

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
	public $updatedAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $updatedAtLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var BorhanMetadataStatus
	 */
	public $statusEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $statusIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMetadataProfileBaseFilter extends BorhanFilter
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
	public $partnerIdEqual = null;

	/**
	 * 
	 *
	 * @var BorhanMetadataObjectType
	 */
	public $metadataObjectTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $metadataObjectTypeIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $versionEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $nameEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $systemNameEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $systemNameIn = null;

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
	public $updatedAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $updatedAtLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var BorhanMetadataProfileStatus
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
	 * @var BorhanMetadataProfileCreateMode
	 */
	public $createModeEqual = null;

	/**
	 * 
	 *
	 * @var BorhanMetadataProfileCreateMode
	 */
	public $createModeNotEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $createModeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $createModeNotIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataFilter extends BorhanMetadataBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataProfileFilter extends BorhanMetadataProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataSearchItem extends BorhanSearchOperator
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $metadataProfileId = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $orderBy = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMetadataClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanMetadataClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanMetadataClientPlugin($client);
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
		return 'metadata';
	}
}

