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
require_once(dirname(__FILE__) . "/BorhanDrmClientPlugin.php");

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineFlavorAssetOrderBy
{
	const CREATED_AT_ASC = "+createdAt";
	const DELETED_AT_ASC = "+deletedAt";
	const SIZE_ASC = "+size";
	const UPDATED_AT_ASC = "+updatedAt";
	const CREATED_AT_DESC = "-createdAt";
	const DELETED_AT_DESC = "-deletedAt";
	const SIZE_DESC = "-size";
	const UPDATED_AT_DESC = "-updatedAt";
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineFlavorParamsOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineFlavorParamsOutputOrderBy
{
}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineProfileOrderBy
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
abstract class BorhanWidevineProfileBaseFilter extends BorhanDrmProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineProfileFilter extends BorhanWidevineProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanWidevineFlavorAssetBaseFilter extends BorhanFlavorAssetFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanWidevineFlavorParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineFlavorAssetFilter extends BorhanWidevineFlavorAssetBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineFlavorParamsFilter extends BorhanWidevineFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanWidevineFlavorParamsOutputBaseFilter extends BorhanFlavorParamsOutputFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineFlavorParamsOutputFilter extends BorhanWidevineFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidevineClientPlugin extends BorhanClientPlugin
{
	protected function __construct(BorhanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return BorhanWidevineClientPlugin
	 */
	public static function get(BorhanClient $client)
	{
		return new BorhanWidevineClientPlugin($client);
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
		return 'widevine';
	}
}

