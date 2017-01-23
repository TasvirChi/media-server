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
require_once(dirname(__FILE__) . "/BorhanMetadataClientPlugin.php");

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDistributionAction
{
	const SUBMIT = 1;
	const UPDATE = 2;
	const DELETE = 3;
	const FETCH_REPORT = 4;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDistributionProfileStatus
{
	const DISABLED = 1;
	const ENABLED = 2;
	const DELETED = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanEntryDistributionFlag
{
	const NONE = 0;
	const SUBMIT_REQUIRED = 1;
	const DELETE_REQUIRED = 2;
	const UPDATE_REQUIRED = 3;
	const ENABLE_REQUIRED = 4;
	const DISABLE_REQUIRED = 5;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanEntryDistributionStatus
{
	const PENDING = 0;
	const QUEUED = 1;
	const READY = 2;
	const DELETED = 3;
	const SUBMITTING = 4;
	const UPDATING = 5;
	const DELETING = 6;
	const ERROR_SUBMITTING = 7;
	const ERROR_UPDATING = 8;
	const ERROR_DELETING = 9;
	const REMOVED = 10;
	const IMPORT_SUBMITTING = 11;
	const IMPORT_UPDATING = 12;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanEntryDistributionSunStatus
{
	const BEFORE_SUNRISE = 1;
	const AFTER_SUNRISE = 2;
	const AFTER_SUNSET = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericDistributionProviderStatus
{
	const ACTIVE = 2;
	const DELETED = 3;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanConfigurableDistributionProfileOrderBy
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
class BorhanDistributionProfileOrderBy
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
class BorhanDistributionProviderOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDistributionProviderType
{
	const ATT_UVERSE = "attUverseDistribution.ATT_UVERSE";
	const AVN = "avnDistribution.AVN";
	const COMCAST_MRSS = "comcastMrssDistribution.COMCAST_MRSS";
	const CROSS_BORHAN = "crossBorhanDistribution.CROSS_BORHAN";
	const DAILYMOTION = "dailymotionDistribution.DAILYMOTION";
	const DOUBLECLICK = "doubleClickDistribution.DOUBLECLICK";
	const FREEWHEEL = "freewheelDistribution.FREEWHEEL";
	const FREEWHEEL_GENERIC = "freewheelGenericDistribution.FREEWHEEL_GENERIC";
	const FTP = "ftpDistribution.FTP";
	const FTP_SCHEDULED = "ftpDistribution.FTP_SCHEDULED";
	const HULU = "huluDistribution.HULU";
	const IDETIC = "ideticDistribution.IDETIC";
	const METRO_PCS = "metroPcsDistribution.METRO_PCS";
	const MSN = "msnDistribution.MSN";
	const NDN = "ndnDistribution.NDN";
	const PODCAST = "podcastDistribution.PODCAST";
	const QUICKPLAY = "quickPlayDistribution.QUICKPLAY";
	const SYNACOR_HBO = "synacorHboDistribution.SYNACOR_HBO";
	const TIME_WARNER = "timeWarnerDistribution.TIME_WARNER";
	const TVCOM = "tvComDistribution.TVCOM";
	const TVINCI = "tvinciDistribution.TVINCI";
	const UVERSE_CLICK_TO_ORDER = "uverseClickToOrderDistribution.UVERSE_CLICK_TO_ORDER";
	const UVERSE = "uverseDistribution.UVERSE";
	const VERIZON_VCAST = "verizonVcastDistribution.VERIZON_VCAST";
	const YAHOO = "yahooDistribution.YAHOO";
	const YOUTUBE = "youTubeDistribution.YOUTUBE";
	const YOUTUBE_API = "youtubeApiDistribution.YOUTUBE_API";
	const GENERIC = "1";
	const SYNDICATION = "2";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanEntryDistributionOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const SUBMITTED_AT_ASC = "+submittedAt";
	const SUNRISE_ASC = "+sunrise";
	const SUNSET_ASC = "+sunset";
	const UPDATED_AT_ASC = "+updatedAt";
	const CREATED_AT_DESC = "-createdAt";
	const SUBMITTED_AT_DESC = "-submittedAt";
	const SUNRISE_DESC = "-sunrise";
	const SUNSET_DESC = "-sunset";
	const UPDATED_AT_DESC = "-updatedAt";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericDistributionProfileOrderBy
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
class BorhanGenericDistributionProviderActionOrderBy
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
class BorhanGenericDistributionProviderOrderBy
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
class BorhanSyndicationDistributionProfileOrderBy
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
class BorhanSyndicationDistributionProviderOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanContentDistributionSearchItem extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var bool
	 */
	public $noDistributionProfiles = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $distributionProfileId = null;

	/**
	 * 
	 *
	 * @var BorhanEntryDistributionSunStatus
	 */
	public $distributionSunStatus = null;

	/**
	 * 
	 *
	 * @var BorhanEntryDistributionFlag
	 */
	public $entryDistributionFlag = null;

	/**
	 * 
	 *
	 * @var BorhanEntryDistributionStatus
	 */
	public $entryDistributionStatus = null;

	/**
	 * 
	 *
	 * @var bool
	 */
	public $hasEntryDistributionValidationErrors = null;

	/**
	 * Comma seperated validation error types
	 * 	 
	 *
	 * @var string
	 */
	public $entryDistributionValidationErrors = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDistributionProfileBaseFilter extends BorhanFilter
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
	 * @var BorhanDistributionProfileStatus
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
abstract class BorhanDistributionProviderBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var BorhanDistributionProviderType
	 */
	public $typeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $typeIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanEntryDistributionBaseFilter extends BorhanFilter
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
	 * @var int
	 */
	public $submittedAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $submittedAtLessThanOrEqual = null;

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
	public $distributionProfileIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $distributionProfileIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanEntryDistributionStatus
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
	 * @var BorhanEntryDistributionFlag
	 */
	public $dirtyStatusEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $dirtyStatusIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $sunriseGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $sunriseLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $sunsetGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $sunsetLessThanOrEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanGenericDistributionProviderActionBaseFilter extends BorhanFilter
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
	 * @var int
	 */
	public $genericDistributionProviderIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $genericDistributionProviderIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanDistributionAction
	 */
	public $actionEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $actionIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDistributionProfileFilter extends BorhanDistributionProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDistributionProviderFilter extends BorhanDistributionProviderBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanEntryDistributionFilter extends BorhanEntryDistributionBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericDistributionProviderActionFilter extends BorhanGenericDistributionProviderActionBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanConfigurableDistributionProfileBaseFilter extends BorhanDistributionProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanGenericDistributionProfileBaseFilter extends BorhanDistributionProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanGenericDistributionProviderBaseFilter extends BorhanDistributionProviderFilter
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
	 * @var BorhanNullableBoolean
	 */
	public $isDefaultEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $isDefaultIn = null;

	/**
	 * 
	 *
	 * @var BorhanGenericDistributionProviderStatus
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
abstract class BorhanSyndicationDistributionProfileBaseFilter extends BorhanDistributionProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanSyndicationDistributionProviderBaseFilter extends BorhanDistributionProviderFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanConfigurableDistributionProfileFilter extends BorhanConfigurableDistributionProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericDistributionProfileFilter extends BorhanGenericDistributionProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericDistributionProviderFilter extends BorhanGenericDistributionProviderBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSyndicationDistributionProfileFilter extends BorhanSyndicationDistributionProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSyndicationDistributionProviderFilter extends BorhanSyndicationDistributionProviderBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanContentDistributionClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanContentDistributionClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanContentDistributionClientPlugin($client);
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
		return 'contentDistribution';
	}
}

