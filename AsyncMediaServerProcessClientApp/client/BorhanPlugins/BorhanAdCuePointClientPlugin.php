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
require_once(dirname(__FILE__) . "/BorhanCuePointClientPlugin.php");

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAdCuePointOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const DURATION_ASC = "+duration";
	const END_TIME_ASC = "+endTime";
	const PARTNER_SORT_VALUE_ASC = "+partnerSortValue";
	const START_TIME_ASC = "+startTime";
	const TRIGGERED_AT_ASC = "+triggeredAt";
	const UPDATED_AT_ASC = "+updatedAt";
	const CREATED_AT_DESC = "-createdAt";
	const DURATION_DESC = "-duration";
	const END_TIME_DESC = "-endTime";
	const PARTNER_SORT_VALUE_DESC = "-partnerSortValue";
	const START_TIME_DESC = "-startTime";
	const TRIGGERED_AT_DESC = "-triggeredAt";
	const UPDATED_AT_DESC = "-updatedAt";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAdProtocolType
{
	const CUSTOM = "0";
	const VAST = "1";
	const VAST_2_0 = "2";
	const VPAID = "3";
}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAdCuePointBaseFilter extends BorhanCuePointFilter
{
	/**
	 * 
	 *
	 * @var BorhanAdProtocolType
	 */
	public $protocolTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $protocolTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $titleLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $titleMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $titleMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $endTimeGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $endTimeLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $durationGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $durationLessThanOrEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAdCuePointFilter extends BorhanAdCuePointBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAdCuePointClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanAdCuePointClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanAdCuePointClientPlugin($client);
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
		return 'adCuePoint';
	}
}

