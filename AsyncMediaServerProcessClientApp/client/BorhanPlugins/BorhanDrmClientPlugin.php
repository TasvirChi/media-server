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
class BorhanDrmPolicyStatus
{
	const ACTIVE = 1;
	const DELETED = 2;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmProfileStatus
{
	const ACTIVE = 1;
	const DELETED = 2;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmDeviceOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const CREATED_AT_DESC = "-createdAt";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmLicenseScenario
{
	const PROTECTION = "playReady.PROTECTION";
	const PURCHASE = "playReady.PURCHASE";
	const RENTAL = "playReady.RENTAL";
	const SUBSCRIPTION = "playReady.SUBSCRIPTION";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmPolicyOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmProfileOrderBy
{
	const ID_ASC = "+id";
	const NAME_ASC = "+name";
	const ID_DESC = "-id";
	const NAME_DESC = "-name";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmProviderType
{
	const PLAY_READY = "playReady.PLAY_READY";
	const WIDEVINE = "widevine.WIDEVINE";
}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDrmDeviceBaseFilter extends BorhanFilter
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
	 * @var string
	 */
	public $partnerIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $deviceIdLike = null;

	/**
	 * 
	 *
	 * @var BorhanDrmProviderType
	 */
	public $providerEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $providerIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDrmPolicyBaseFilter extends BorhanFilter
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
	 * @var string
	 */
	public $partnerIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $nameLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $systemNameLike = null;

	/**
	 * 
	 *
	 * @var BorhanDrmProviderType
	 */
	public $providerEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $providerIn = null;

	/**
	 * 
	 *
	 * @var BorhanDrmPolicyStatus
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
	 * @var BorhanDrmLicenseScenario
	 */
	public $scenarioEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $scenarioIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDrmProfileBaseFilter extends BorhanFilter
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
	 * @var string
	 */
	public $idIn = null;

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
	public $nameLike = null;

	/**
	 * 
	 *
	 * @var BorhanDrmProviderType
	 */
	public $providerEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $providerIn = null;

	/**
	 * 
	 *
	 * @var BorhanDrmProfileStatus
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
class BorhanDrmDeviceFilter extends BorhanDrmDeviceBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmPolicyFilter extends BorhanDrmPolicyBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmProfileFilter extends BorhanDrmProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDrmClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanDrmClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanDrmClientPlugin($client);
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
		return 'drm';
	}
}

