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
class BorhanDocumentType
{
	const DOCUMENT = 11;
	const SWF = 12;
	const PDF = 13;
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentEntryOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const END_DATE_ASC = "+endDate";
	const MODERATION_COUNT_ASC = "+moderationCount";
	const NAME_ASC = "+name";
	const PARTNER_SORT_VALUE_ASC = "+partnerSortValue";
	const RANK_ASC = "+rank";
	const RECENT_ASC = "+recent";
	const START_DATE_ASC = "+startDate";
	const TOTAL_RANK_ASC = "+totalRank";
	const UPDATED_AT_ASC = "+updatedAt";
	const WEIGHT_ASC = "+weight";
	const CREATED_AT_DESC = "-createdAt";
	const END_DATE_DESC = "-endDate";
	const MODERATION_COUNT_DESC = "-moderationCount";
	const NAME_DESC = "-name";
	const PARTNER_SORT_VALUE_DESC = "-partnerSortValue";
	const RANK_DESC = "-rank";
	const RECENT_DESC = "-recent";
	const START_DATE_DESC = "-startDate";
	const TOTAL_RANK_DESC = "-totalRank";
	const UPDATED_AT_DESC = "-updatedAt";
	const WEIGHT_DESC = "-weight";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentFlavorParamsOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentFlavorParamsOutputOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanImageFlavorParamsOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanImageFlavorParamsOutputOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPdfFlavorParamsOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPdfFlavorParamsOutputOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSwfFlavorParamsOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSwfFlavorParamsOutputOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentEntry extends BorhanBaseEntry
{
	/**
	 * The type of the document
	 * 	 
	 *
	 * @var BorhanDocumentType
	 * @insertonly
	 */
	public $documentType = null;

	/**
	 * Comma separated asset params ids that exists for this media entry
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $assetParamsIds = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDocumentEntryBaseFilter extends BorhanBaseEntryFilter
{
	/**
	 * 
	 *
	 * @var BorhanDocumentType
	 */
	public $documentTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $documentTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $assetParamsIdsMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $assetParamsIdsMatchAnd = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentEntryFilter extends BorhanDocumentEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDocumentFlavorParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanImageFlavorParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPdfFlavorParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanSwfFlavorParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentFlavorParamsFilter extends BorhanDocumentFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanImageFlavorParamsFilter extends BorhanImageFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPdfFlavorParamsFilter extends BorhanPdfFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSwfFlavorParamsFilter extends BorhanSwfFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDocumentFlavorParamsOutputBaseFilter extends BorhanFlavorParamsOutputFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanImageFlavorParamsOutputBaseFilter extends BorhanFlavorParamsOutputFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPdfFlavorParamsOutputBaseFilter extends BorhanFlavorParamsOutputFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanSwfFlavorParamsOutputBaseFilter extends BorhanFlavorParamsOutputFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentFlavorParamsOutputFilter extends BorhanDocumentFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanImageFlavorParamsOutputFilter extends BorhanImageFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPdfFlavorParamsOutputFilter extends BorhanPdfFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSwfFlavorParamsOutputFilter extends BorhanSwfFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDocumentClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanDocumentClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanDocumentClientPlugin($client);
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
		return 'document';
	}
}

