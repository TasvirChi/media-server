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

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanResource extends BorhanObjectBase
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanContentResource extends BorhanResource
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAssetParamsResourceContainer extends BorhanResource
{
	/**
	 * The content resource to associate with asset params
	 * 	 
	 *
	 * @var BorhanContentResource
	 */
	public $resource;

	/**
	 * The asset params to associate with the reaource
	 * 	 
	 *
	 * @var int
	 */
	public $assetParamsId = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanOperationAttributes extends BorhanObjectBase
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanBaseEntry extends BorhanObjectBase
{
	/**
	 * Auto generated 10 characters alphanumeric string
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $id = null;

	/**
	 * Entry name (Min 1 chars)
	 * 	 
	 *
	 * @var string
	 */
	public $name = null;

	/**
	 * Entry description
	 * 	 
	 *
	 * @var string
	 */
	public $description = null;

	/**
	 * 
	 *
	 * @var int
	 * @readonly
	 */
	public $partnerId = null;

	/**
	 * The ID of the user who is the owner of this entry 
	 * 	 
	 *
	 * @var string
	 */
	public $userId = null;

	/**
	 * The ID of the user who created this entry 
	 * 	 
	 *
	 * @var string
	 * @insertonly
	 */
	public $creatorId = null;

	/**
	 * Entry tags
	 * 	 
	 *
	 * @var string
	 */
	public $tags = null;

	/**
	 * Entry admin tags can be updated only by administrators
	 * 	 
	 *
	 * @var string
	 */
	public $adminTags = null;

	/**
	 * Categories with no entitlement that this entry belongs to.
	 * 	 
	 *
	 * @var string
	 */
	public $categories = null;

	/**
	 * Categories Ids of categories with no entitlement that this entry belongs to
	 * 	 
	 *
	 * @var string
	 */
	public $categoriesIds = null;

	/**
	 * 
	 *
	 * @var BorhanEntryStatus
	 * @readonly
	 */
	public $status = null;

	/**
	 * Entry moderation status
	 * 	 
	 *
	 * @var BorhanEntryModerationStatus
	 * @readonly
	 */
	public $moderationStatus = null;

	/**
	 * Number of moderation requests waiting for this entry
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $moderationCount = null;

	/**
	 * The type of the entry, this is auto filled by the derived entry object
	 * 	 
	 *
	 * @var BorhanEntryType
	 */
	public $type = null;

	/**
	 * Entry creation date as Unix timestamp (In seconds)
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $createdAt = null;

	/**
	 * Entry update date as Unix timestamp (In seconds)
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $updatedAt = null;

	/**
	 * The calculated average rank. rank = totalRank / votes
	 * 	 
	 *
	 * @var float
	 * @readonly
	 */
	public $rank = null;

	/**
	 * The sum of all rank values submitted to the baseEntry.anonymousRank action
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $totalRank = null;

	/**
	 * A count of all requests made to the baseEntry.anonymousRank action
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $votes = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $groupId = null;

	/**
	 * Can be used to store various partner related data as a string 
	 * 	 
	 *
	 * @var string
	 */
	public $partnerData = null;

	/**
	 * Download URL for the entry
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $downloadUrl = null;

	/**
	 * Indexed search text for full text search
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $searchText = null;

	/**
	 * License type used for this entry
	 * 	 
	 *
	 * @var BorhanLicenseType
	 */
	public $licenseType = null;

	/**
	 * Version of the entry data
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $version = null;

	/**
	 * Thumbnail URL
	 * 	 
	 *
	 * @var string
	 * @insertonly
	 */
	public $thumbnailUrl = null;

	/**
	 * The Access Control ID assigned to this entry (null when not set, send -1 to remove)  
	 * 	 
	 *
	 * @var int
	 */
	public $accessControlId = null;

	/**
	 * Entry scheduling start date (null when not set, send -1 to remove)
	 * 	 
	 *
	 * @var int
	 */
	public $startDate = null;

	/**
	 * Entry scheduling end date (null when not set, send -1 to remove)
	 * 	 
	 *
	 * @var int
	 */
	public $endDate = null;

	/**
	 * Entry external reference id
	 * 	 
	 *
	 * @var string
	 */
	public $referenceId = null;

	/**
	 * ID of temporary entry that will replace this entry when it's approved and ready for replacement
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $replacingEntryId = null;

	/**
	 * ID of the entry that will be replaced when the replacement approved and this entry is ready
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $replacedEntryId = null;

	/**
	 * Status of the replacement readiness and approval
	 * 	 
	 *
	 * @var BorhanEntryReplacementStatus
	 * @readonly
	 */
	public $replacementStatus = null;

	/**
	 * Can be used to store various partner related data as a numeric value
	 * 	 
	 *
	 * @var int
	 */
	public $partnerSortValue = null;

	/**
	 * Override the default ingestion profile  
	 * 	 
	 *
	 * @var int
	 */
	public $conversionProfileId = null;

	/**
	 * IF not empty, points to an entry ID the should replace this current entry's id. 
	 * 	 
	 *
	 * @var string
	 */
	public $redirectEntryId = null;

	/**
	 * ID of source root entry, used for clipped, skipped and cropped entries that created from another entry
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $rootEntryId = null;

	/**
	 * ID of source root entry, used for defining entires association
	 *  	 
	 *
	 * @var string
	 */
	public $parentEntryId = null;

	/**
	 * clipping, skipping and cropping attributes that used to create this entry  
	 * 	 
	 *
	 * @var array of BorhanOperationAttributes
	 */
	public $operationAttributes;

	/**
	 * list of user ids that are entitled to edit the entry (no server enforcement) The difference between entitledUsersEdit and entitledUsersPublish is applicative only
	 * 	 
	 *
	 * @var string
	 */
	public $entitledUsersEdit = null;

	/**
	 * list of user ids that are entitled to publish the entry (no server enforcement) The difference between entitledUsersEdit and entitledUsersPublish is applicative only
	 * 	 
	 *
	 * @var string
	 */
	public $entitledUsersPublish = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanSearchItem extends BorhanObjectBase
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanFilter extends BorhanObjectBase
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $orderBy = null;

	/**
	 * 
	 *
	 * @var BorhanSearchItem
	 */
	public $advancedSearch;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamBitrate extends BorhanObjectBase
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $bitrate = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $width = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $height = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tags = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamConfiguration extends BorhanObjectBase
{
	/**
	 * 
	 *
	 * @var BorhanPlaybackProtocol
	 */
	public $protocol = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $url = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $publishUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $backupUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $streamName = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamPushPublishConfiguration extends BorhanObjectBase
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $publishUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $backupPublishUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $port = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanBaseEntryBaseFilter extends BorhanFilter
{
	/**
	 * This filter should be in use for retrieving only a specific entry (identified by its entryId).
	 * 	 
	 *
	 * @var string
	 */
	public $idEqual = null;

	/**
	 * This filter should be in use for retrieving few specific entries (string should include comma separated list of entryId strings).
	 * 	 
	 *
	 * @var string
	 */
	public $idIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $idNotIn = null;

	/**
	 * This filter should be in use for retrieving specific entries. It should include only one string to search for in entry names (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $nameLike = null;

	/**
	 * This filter should be in use for retrieving specific entries. It could include few (comma separated) strings for searching in entry names, while applying an OR logic to retrieve entries that contain at least one input string (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $nameMultiLikeOr = null;

	/**
	 * This filter should be in use for retrieving specific entries. It could include few (comma separated) strings for searching in entry names, while applying an AND logic to retrieve entries that contain all input strings (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $nameMultiLikeAnd = null;

	/**
	 * This filter should be in use for retrieving entries with a specific name.
	 * 	 
	 *
	 * @var string
	 */
	public $nameEqual = null;

	/**
	 * This filter should be in use for retrieving only entries which were uploaded by/assigned to users of a specific Borhan Partner (identified by Partner ID).
	 * 	 
	 *
	 * @var int
	 */
	public $partnerIdEqual = null;

	/**
	 * This filter should be in use for retrieving only entries within Borhan network which were uploaded by/assigned to users of few Borhan Partners  (string should include comma separated list of PartnerIDs)
	 * 	 
	 *
	 * @var string
	 */
	public $partnerIdIn = null;

	/**
	 * This filter parameter should be in use for retrieving only entries, uploaded by/assigned to a specific user (identified by user Id).
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
	 * @var string
	 */
	public $creatorIdEqual = null;

	/**
	 * This filter should be in use for retrieving specific entries. It should include only one string to search for in entry tags (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $tagsLike = null;

	/**
	 * This filter should be in use for retrieving specific entries. It could include few (comma separated) strings for searching in entry tags, while applying an OR logic to retrieve entries that contain at least one input string (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * This filter should be in use for retrieving specific entries. It could include few (comma separated) strings for searching in entry tags, while applying an AND logic to retrieve entries that contain all input strings (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

	/**
	 * This filter should be in use for retrieving specific entries. It should include only one string to search for in entry tags set by an ADMIN user (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $adminTagsLike = null;

	/**
	 * This filter should be in use for retrieving specific entries. It could include few (comma separated) strings for searching in entry tags, set by an ADMIN user, while applying an OR logic to retrieve entries that contain at least one input string (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $adminTagsMultiLikeOr = null;

	/**
	 * This filter should be in use for retrieving specific entries. It could include few (comma separated) strings for searching in entry tags, set by an ADMIN user, while applying an AND logic to retrieve entries that contain all input strings (no wildcards, spaces are treated as part of the string).
	 * 	 
	 *
	 * @var string
	 */
	public $adminTagsMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoriesMatchAnd = null;

	/**
	 * All entries within these categories or their child categories.
	 * 	 
	 *
	 * @var string
	 */
	public $categoriesMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoriesNotContains = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoriesIdsMatchAnd = null;

	/**
	 * All entries of the categories, excluding their child categories.
	 * 	 To include entries of the child categories, use categoryAncestorIdIn, or categoriesMatchOr.
	 * 	 
	 *
	 * @var string
	 */
	public $categoriesIdsMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoriesIdsNotContains = null;

	/**
	 * 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $categoriesIdsEmpty = null;

	/**
	 * This filter should be in use for retrieving only entries, at a specific {
	 *
	 * @var BorhanEntryStatus
	 */
	public $statusEqual = null;

	/**
	 * This filter should be in use for retrieving only entries, not at a specific {
	 *
	 * @var BorhanEntryStatus
	 */
	public $statusNotEqual = null;

	/**
	 * This filter should be in use for retrieving only entries, at few specific {
	 *
	 * @var string
	 */
	public $statusIn = null;

	/**
	 * This filter should be in use for retrieving only entries, not at few specific {
	 *
	 * @var string
	 */
	public $statusNotIn = null;

	/**
	 * 
	 *
	 * @var BorhanEntryModerationStatus
	 */
	public $moderationStatusEqual = null;

	/**
	 * 
	 *
	 * @var BorhanEntryModerationStatus
	 */
	public $moderationStatusNotEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $moderationStatusIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $moderationStatusNotIn = null;

	/**
	 * 
	 *
	 * @var BorhanEntryType
	 */
	public $typeEqual = null;

	/**
	 * This filter should be in use for retrieving entries of few {
	 *
	 * @var string
	 */
	public $typeIn = null;

	/**
	 * This filter parameter should be in use for retrieving only entries which were created at Borhan system after a specific time/date (standard timestamp format).
	 * 	 
	 *
	 * @var int
	 */
	public $createdAtGreaterThanOrEqual = null;

	/**
	 * This filter parameter should be in use for retrieving only entries which were created at Borhan system before a specific time/date (standard timestamp format).
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
	public $totalRankLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $totalRankGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $groupIdEqual = null;

	/**
	 * This filter should be in use for retrieving specific entries while search match the input string within all of the following metadata attributes: name, description, tags, adminTags.
	 * 	 
	 *
	 * @var string
	 */
	public $searchTextMatchAnd = null;

	/**
	 * This filter should be in use for retrieving specific entries while search match the input string within at least one of the following metadata attributes: name, description, tags, adminTags.
	 * 	 
	 *
	 * @var string
	 */
	public $searchTextMatchOr = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $accessControlIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $accessControlIdIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $startDateGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $startDateLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $startDateGreaterThanOrEqualOrNull = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $startDateLessThanOrEqualOrNull = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $endDateGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $endDateLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $endDateGreaterThanOrEqualOrNull = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $endDateLessThanOrEqualOrNull = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $referenceIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $referenceIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $replacingEntryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $replacingEntryIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $replacedEntryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $replacedEntryIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanEntryReplacementStatus
	 */
	public $replacementStatusEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $replacementStatusIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerSortValueGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerSortValueLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $rootEntryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $rootEntryIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $parentEntryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsNameMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsAdminTagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsAdminTagsNameMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsNameMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsAdminTagsMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsAdminTagsNameMultiLikeAnd = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanBaseEntryFilter extends BorhanBaseEntryBaseFilter
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $freeText = null;

	/**
	 * 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $isRoot = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoriesFullNameIn = null;

	/**
	 * All entries within this categoy or in child categories  
	 * 	 
	 *
	 * @var string
	 */
	public $categoryAncestorIdIn = null;

	/**
	 * The id of the original entry
	 * 	 
	 *
	 * @var string
	 */
	public $redirectFromEntryId = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPlayableEntryBaseFilter extends BorhanBaseEntryFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $lastPlayedAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $lastPlayedAtLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $durationLessThan = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $durationGreaterThan = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $durationLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $durationGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $durationTypeMatchOr = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPlayableEntryFilter extends BorhanPlayableEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMediaEntryBaseFilter extends BorhanPlayableEntryFilter
{
	/**
	 * 
	 *
	 * @var BorhanMediaType
	 */
	public $mediaTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $mediaTypeIn = null;

	/**
	 * 
	 *
	 * @var BorhanSourceType
	 */
	public $sourceTypeEqual = null;

	/**
	 * 
	 *
	 * @var BorhanSourceType
	 */
	public $sourceTypeNotEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $sourceTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $sourceTypeNotIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $mediaDateGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $mediaDateLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorParamsIdsMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorParamsIdsMatchAnd = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaEntryFilter extends BorhanMediaEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaEntryFilterForPlaylist extends BorhanMediaEntryFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $limit = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUrlResource extends BorhanContentResource
{
	/**
	 * Remote URL, FTP, HTTP or HTTPS 
	 * 	 
	 *
	 * @var string
	 */
	public $url = null;

	/**
	 * Force Import Job 
	 * 	 
	 *
	 * @var bool
	 */
	public $forceAsyncDownload = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanRemoteStorageResource extends BorhanUrlResource
{
	/**
	 * ID of storage profile to be associated with the created file sync, used for file serving URL composing. 
	 * 	 
	 *
	 * @var int
	 */
	public $storageProfileId = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUploadToken extends BorhanObjectBase
{
	/**
	 * Upload token unique ID
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $id = null;

	/**
	 * Partner ID of the upload token
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $partnerId = null;

	/**
	 * User id for the upload token
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $userId = null;

	/**
	 * Status of the upload token
	 * 	 
	 *
	 * @var BorhanUploadTokenStatus
	 * @readonly
	 */
	public $status = null;

	/**
	 * Name of the file for the upload token, can be empty when the upload token is created and will be updated internally after the file is uploaded
	 * 	 
	 *
	 * @var string
	 * @insertonly
	 */
	public $fileName = null;

	/**
	 * File size in bytes, can be empty when the upload token is created and will be updated internally after the file is uploaded
	 * 	 
	 *
	 * @var float
	 * @insertonly
	 */
	public $fileSize = null;

	/**
	 * Uploaded file size in bytes, can be used to identify how many bytes were uploaded before resuming
	 * 	 
	 *
	 * @var float
	 * @readonly
	 */
	public $uploadedFileSize = null;

	/**
	 * Creation date as Unix timestamp (In seconds)
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $createdAt = null;

	/**
	 * Last update date as Unix timestamp (In seconds)
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $updatedAt = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAccessControlBaseFilter extends BorhanFilter
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


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAccessControlProfileBaseFilter extends BorhanFilter
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


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAssetBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var string
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
	 * @var int
	 */
	public $sizeGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $sizeLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

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
	public $deletedAtGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $deletedAtLessThanOrEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAssetParamsBaseFilter extends BorhanFilter
{
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
	 * @var BorhanNullableBoolean
	 */
	public $isSystemDefaultEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAssetsParamsResourceContainers extends BorhanResource
{
	/**
	 * Array of resources associated with asset params ids
	 * 	 
	 *
	 * @var array of BorhanAssetParamsResourceContainer
	 */
	public $resources;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanBaseSyndicationFeedBaseFilter extends BorhanFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanBatchJobBaseFilter extends BorhanFilter
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
	public $idGreaterThanOrEqual = null;

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
	public $partnerIdNotIn = null;

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
	public $executionAttemptsGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $executionAttemptsLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $lockVersionGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $lockVersionLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $entryIdEqual = null;

	/**
	 * 
	 *
	 * @var BorhanBatchJobType
	 */
	public $jobTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $jobTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $jobTypeNotIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $jobSubTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $jobSubTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $jobSubTypeNotIn = null;

	/**
	 * 
	 *
	 * @var BorhanBatchJobStatus
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
	 * @var string
	 */
	public $statusNotIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $priorityGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $priorityLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $priorityEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $priorityIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $priorityNotIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $batchVersionGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $batchVersionLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $batchVersionEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $queueTimeGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $queueTimeLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $finishTimeGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $finishTimeLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var BorhanBatchJobErrorTypes
	 */
	public $errTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $errTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $errTypeNotIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $errNumberEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $errNumberIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $errNumberNotIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $estimatedEffortLessThan = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $estimatedEffortGreaterThan = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $urgencyLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $urgencyGreaterThanOrEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanBulkUploadBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $uploadedOnGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $uploadedOnLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $uploadedOnEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $statusIn = null;

	/**
	 * 
	 *
	 * @var BorhanBatchJobStatus
	 */
	public $statusEqual = null;

	/**
	 * 
	 *
	 * @var BorhanBulkUploadObjectType
	 */
	public $bulkUploadObjectTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $bulkUploadObjectTypeIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanCategoryBaseFilter extends BorhanFilter
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
	public $parentIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $parentIdIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $depthEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullNameEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullNameStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullNameIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullIdsEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullIdsStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullIdsMatchOr = null;

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
	 * @var string
	 */
	public $tagsLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var BorhanAppearInListType
	 */
	public $appearInListEqual = null;

	/**
	 * 
	 *
	 * @var BorhanPrivacyType
	 */
	public $privacyEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $privacyIn = null;

	/**
	 * 
	 *
	 * @var BorhanInheritanceType
	 */
	public $inheritanceTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $inheritanceTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $referenceIdEqual = null;

	/**
	 * 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $referenceIdEmpty = null;

	/**
	 * 
	 *
	 * @var BorhanContributionPolicyType
	 */
	public $contributionPolicyEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $membersCountGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $membersCountLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $pendingMembersCountGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $pendingMembersCountLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $privacyContextEqual = null;

	/**
	 * 
	 *
	 * @var BorhanCategoryStatus
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
	 * @var int
	 */
	public $inheritedParentIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $inheritedParentIdIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerSortValueGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerSortValueLessThanOrEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanCategoryEntryAdvancedFilter extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $categoriesMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoryEntryStatusIn = null;

	/**
	 * 
	 *
	 * @var BorhanCategoryEntryAdvancedOrderBy
	 */
	public $orderBy = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $categoryIdEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanCategoryEntryBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $categoryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoryIdIn = null;

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
	 * @var string
	 */
	public $categoryFullIdsStartsWith = null;

	/**
	 * 
	 *
	 * @var BorhanCategoryEntryStatus
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
class BorhanCategoryUserAdvancedFilter extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $memberIdEq = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $memberIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $memberPermissionsMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $memberPermissionsMatchAnd = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanCategoryUserBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $categoryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoryIdIn = null;

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
	 * @var BorhanCategoryUserPermissionLevel
	 */
	public $permissionLevelEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $permissionLevelIn = null;

	/**
	 * 
	 *
	 * @var BorhanCategoryUserStatus
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
	 * @var BorhanUpdateMethodType
	 */
	public $updateMethodEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $updateMethodIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoryFullIdsStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $categoryFullIdsEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $permissionNamesMatchAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $permissionNamesMatchOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $permissionNamesNotContains = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanClipAttributes extends BorhanOperationAttributes
{
	/**
	 * Offset in milliseconds
	 * 	 
	 *
	 * @var int
	 */
	public $offset = null;

	/**
	 * Duration in milliseconds
	 * 	 
	 *
	 * @var int
	 */
	public $duration = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDataCenterContentResource extends BorhanContentResource
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanConcatAttributes extends BorhanOperationAttributes
{
	/**
	 * The resource to be concatenated
	 * 	 
	 *
	 * @var BorhanDataCenterContentResource
	 */
	public $resource;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanControlPanelCommandBaseFilter extends BorhanFilter
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
	public $createdByIdEqual = null;

	/**
	 * 
	 *
	 * @var BorhanControlPanelCommandType
	 */
	public $typeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $typeIn = null;

	/**
	 * 
	 *
	 * @var BorhanControlPanelCommandTargetType
	 */
	public $targetTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $targetTypeIn = null;

	/**
	 * 
	 *
	 * @var BorhanControlPanelCommandStatus
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
abstract class BorhanConversionProfileAssetParamsBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $conversionProfileIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $conversionProfileIdIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $assetParamsIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $assetParamsIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanFlavorReadyBehaviorType
	 */
	public $readyBehaviorEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $readyBehaviorIn = null;

	/**
	 * 
	 *
	 * @var BorhanAssetParamsOrigin
	 */
	public $originEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $originIn = null;

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


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanConversionProfileBaseFilter extends BorhanFilter
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
	 * @var BorhanConversionProfileStatus
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
	 * @var BorhanConversionProfileType
	 */
	public $typeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $typeIn = null;

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
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $defaultEntryIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $defaultEntryIdIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDataEntry extends BorhanBaseEntry
{
	/**
	 * The data of the entry
	 * 	 
	 *
	 * @var string
	 */
	public $dataContent = null;

	/**
	 * indicator whether to return the object for get action with the dataContent field.
	 * 	 
	 *
	 * @var bool
	 * @insertonly
	 */
	public $retrieveDataContentByGet = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileBaseFilter extends BorhanFilter
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
	 * @var BorhanPlaybackProtocol
	 */
	public $streamerTypeEqual = null;

	/**
	 * 
	 *
	 * @var BorhanDeliveryStatus
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
class BorhanEntryCuePointSearchFilter extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $cuePointsFreeText = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $cuePointTypeIn = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $cuePointSubTypeEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanFileAssetBaseFilter extends BorhanFilter
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
	 * @var BorhanFileAssetObjectType
	 */
	public $fileAssetObjectTypeEqual = null;

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
	 * @var BorhanFileAssetStatus
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
class BorhanIndexAdvancedFilter extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $indexIdGreaterThan = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveChannelSegmentBaseFilter extends BorhanFilter
{
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
	 * @var BorhanLiveChannelSegmentStatus
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
	 * @var string
	 */
	public $channelIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $channelIdIn = null;

	/**
	 * 
	 *
	 * @var float
	 */
	public $startTimeGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var float
	 */
	public $startTimeLessThanOrEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamPushPublishRTMPConfiguration extends BorhanLiveStreamPushPublishConfiguration
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $userId = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $password = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $streamName = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $applicationName = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMediaInfoBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorAssetIdEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMediaServerBaseFilter extends BorhanFilter
{
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


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPartnerBaseFilter extends BorhanFilter
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
	 * @var string
	 */
	public $idNotIn = null;

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
	public $nameMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $nameMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $nameEqual = null;

	/**
	 * 
	 *
	 * @var BorhanPartnerStatus
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
	 * @var int
	 */
	public $partnerPackageEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerPackageGreaterThanOrEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $partnerPackageLessThanOrEqual = null;

	/**
	 * 
	 *
	 * @var BorhanPartnerGroupType
	 */
	public $partnerGroupTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $partnerNameDescriptionWebsiteAdminNameAdminEmailLike = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPermissionBaseFilter extends BorhanFilter
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
	 * @var BorhanPermissionType
	 */
	public $typeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $typeIn = null;

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
	public $nameIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $friendlyNameLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $descriptionLike = null;

	/**
	 * 
	 *
	 * @var BorhanPermissionStatus
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
	public $dependsOnPermissionNamesMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $dependsOnPermissionNamesMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

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


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPermissionItemBaseFilter extends BorhanFilter
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
	 * @var BorhanPermissionItemType
	 */
	public $typeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $typeIn = null;

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
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

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


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPlayableEntry extends BorhanBaseEntry
{
	/**
	 * Number of plays
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $plays = null;

	/**
	 * Number of views
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $views = null;

	/**
	 * The last time the entry was played
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $lastPlayedAt = null;

	/**
	 * The width in pixels
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $width = null;

	/**
	 * The height in pixels
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $height = null;

	/**
	 * The duration in seconds
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $duration = null;

	/**
	 * The duration in miliseconds
	 * 	 
	 *
	 * @var int
	 */
	public $msDuration = null;

	/**
	 * The duration type (short for 0-4 mins, medium for 4-20 mins, long for 20+ mins)
	 * 	 
	 *
	 * @var BorhanDurationType
	 * @readonly
	 */
	public $durationType = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPlaylist extends BorhanBaseEntry
{
	/**
	 * Content of the playlist - 
	 * 	 XML if the playlistType is dynamic 
	 * 	 text if the playlistType is static 
	 * 	 url if the playlistType is mRss 
	 * 	 
	 *
	 * @var string
	 */
	public $playlistContent = null;

	/**
	 * 
	 *
	 * @var array of BorhanMediaEntryFilterForPlaylist
	 */
	public $filters;

	/**
	 * Maximum count of results to be returned in playlist execution
	 * 	 
	 *
	 * @var int
	 */
	public $totalResults = null;

	/**
	 * Type of playlist
	 * 	 
	 *
	 * @var BorhanPlaylistType
	 */
	public $playlistType = null;

	/**
	 * Number of plays
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $plays = null;

	/**
	 * Number of views
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $views = null;

	/**
	 * The duration in seconds
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $duration = null;

	/**
	 * The url for this playlist
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $executeUrl = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanReportBaseFilter extends BorhanFilter
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
	public $systemNameEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $systemNameIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSearchCondition extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $field = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $value = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSearchOperator extends BorhanSearchItem
{
	/**
	 * 
	 *
	 * @var BorhanSearchOperatorType
	 */
	public $type = null;

	/**
	 * 
	 *
	 * @var array of BorhanSearchItem
	 */
	public $items;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanStorageProfileBaseFilter extends BorhanFilter
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
	 * @var BorhanStorageProfileStatus
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
	 * @var BorhanStorageProfileProtocol
	 */
	public $protocolEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $protocolIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanUiConfBaseFilter extends BorhanFilter
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
	 * @var string
	 */
	public $nameLike = null;

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
	 * @var BorhanUiConfObjType
	 */
	public $objTypeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $objTypeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

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
	 * @var BorhanUiConfCreationMode
	 */
	public $creationModeEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $creationModeIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $versionEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $versionMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $versionMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $partnerTagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $partnerTagsMultiLikeAnd = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanUploadTokenBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var string
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
	 * @var string
	 */
	public $userIdEqual = null;

	/**
	 * 
	 *
	 * @var BorhanUploadTokenStatus
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
	 * @var string
	 */
	public $fileNameEqual = null;

	/**
	 * 
	 *
	 * @var float
	 */
	public $fileSizeEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanUserBaseFilter extends BorhanFilter
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
	public $screenNameLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $screenNameStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $emailLike = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $emailStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

	/**
	 * 
	 *
	 * @var BorhanUserStatus
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
	 * @var string
	 */
	public $firstNameStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $lastNameStartsWith = null;

	/**
	 * 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $isAdminEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanUserLoginDataBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $loginEmailEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanUserRoleBaseFilter extends BorhanFilter
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
	 * @var string
	 */
	public $nameEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $nameIn = null;

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
	 * @var string
	 */
	public $descriptionLike = null;

	/**
	 * 
	 *
	 * @var BorhanUserRoleStatus
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
	public $tagsMultiLikeOr = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $tagsMultiLikeAnd = null;

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


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanWidgetBaseFilter extends BorhanFilter
{
	/**
	 * 
	 *
	 * @var string
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
	 * @var string
	 */
	public $sourceWidgetIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $rootWidgetIdEqual = null;

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
	public $entryIdEqual = null;

	/**
	 * 
	 *
	 * @var int
	 */
	public $uiConfIdEqual = null;

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
	 * @var string
	 */
	public $partnerDataLike = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAccessControlFilter extends BorhanAccessControlBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAccessControlProfileFilter extends BorhanAccessControlProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAssetFilter extends BorhanAssetBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAssetParamsFilter extends BorhanAssetParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAssetResource extends BorhanContentResource
{
	/**
	 * ID of the source asset 
	 * 	 
	 *
	 * @var string
	 */
	public $assetId = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanBaseSyndicationFeedFilter extends BorhanBaseSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanBatchJobFilter extends BorhanBatchJobBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanBulkUploadFilter extends BorhanBulkUploadBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanCategoryEntryFilter extends BorhanCategoryEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanCategoryFilter extends BorhanCategoryBaseFilter
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $freeText = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $membersIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $nameOrReferenceIdStartsWith = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $managerEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $memberEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $fullNameStartsWithIn = null;

	/**
	 * not includes the category itself (only sub categories)
	 * 	 
	 *
	 * @var string
	 */
	public $ancestorIdIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $idOrInheritedParentIdIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanCategoryUserFilter extends BorhanCategoryUserBaseFilter
{
	/**
	 * Return the list of categoryUser that are not inherited from parent category - only the direct categoryUsers.
	 * 	 
	 *
	 * @var bool
	 */
	public $categoryDirectMembers = null;

	/**
	 * Free text search on user id or screen name
	 * 	 
	 *
	 * @var string
	 */
	public $freeText = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanControlPanelCommandFilter extends BorhanControlPanelCommandBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanConversionProfileFilter extends BorhanConversionProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanConversionProfileAssetParamsFilter extends BorhanConversionProfileAssetParamsBaseFilter
{
	/**
	 * 
	 *
	 * @var BorhanConversionProfileFilter
	 */
	public $conversionProfileIdFilter;

	/**
	 * 
	 *
	 * @var BorhanAssetParamsFilter
	 */
	public $assetParamsIdFilter;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileFilter extends BorhanDeliveryProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanEntryResource extends BorhanContentResource
{
	/**
	 * ID of the source entry 
	 * 	 
	 *
	 * @var string
	 */
	public $entryId = null;

	/**
	 * ID of the source flavor params, set to null to use the source flavor
	 * 	 
	 *
	 * @var int
	 */
	public $flavorParamsId = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanFileAssetFilter extends BorhanFileAssetBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanFileSyncResource extends BorhanContentResource
{
	/**
	 * The object type of the file sync object 
	 * 	 
	 *
	 * @var int
	 */
	public $fileSyncObjectType = null;

	/**
	 * The object sub-type of the file sync object 
	 * 	 
	 *
	 * @var int
	 */
	public $objectSubType = null;

	/**
	 * The object id of the file sync object 
	 * 	 
	 *
	 * @var string
	 */
	public $objectId = null;

	/**
	 * The version of the file sync object 
	 * 	 
	 *
	 * @var string
	 */
	public $version = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveChannelSegmentFilter extends BorhanLiveChannelSegmentBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaEntry extends BorhanPlayableEntry
{
	/**
	 * The media type of the entry
	 * 	 
	 *
	 * @var BorhanMediaType
	 * @insertonly
	 */
	public $mediaType = null;

	/**
	 * Override the default conversion quality  
	 * 	 
	 *
	 * @var string
	 * @insertonly
	 */
	public $conversionQuality = null;

	/**
	 * The source type of the entry 
	 * 	 
	 *
	 * @var BorhanSourceType
	 * @insertonly
	 */
	public $sourceType = null;

	/**
	 * The search provider type used to import this entry
	 * 	 
	 *
	 * @var BorhanSearchProviderType
	 * @insertonly
	 */
	public $searchProviderType = null;

	/**
	 * The ID of the media in the importing site
	 * 	 
	 *
	 * @var string
	 * @insertonly
	 */
	public $searchProviderId = null;

	/**
	 * The user name used for credits
	 * 	 
	 *
	 * @var string
	 */
	public $creditUserName = null;

	/**
	 * The URL for credits
	 * 	 
	 *
	 * @var string
	 */
	public $creditUrl = null;

	/**
	 * The media date extracted from EXIF data (For images) as Unix timestamp (In seconds)
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $mediaDate = null;

	/**
	 * The URL used for playback. This is not the download URL.
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $dataUrl = null;

	/**
	 * Comma separated flavor params ids that exists for this media entry
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $flavorParamsIds = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaInfoFilter extends BorhanMediaInfoBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaServerFilter extends BorhanMediaServerBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMixEntry extends BorhanPlayableEntry
{
	/**
	 * Indicates whether the user has submited a real thumbnail to the mix (Not the one that was generated automaticaly)
	 * 	 
	 *
	 * @var bool
	 * @readonly
	 */
	public $hasRealThumbnail = null;

	/**
	 * The editor type used to edit the metadata
	 * 	 
	 *
	 * @var BorhanEditorType
	 */
	public $editorType = null;

	/**
	 * The xml data of the mix
	 * 	 
	 *
	 * @var string
	 */
	public $dataContent = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanOperationResource extends BorhanContentResource
{
	/**
	 * Only BorhanEntryResource and BorhanAssetResource are supported
	 * 	 
	 *
	 * @var BorhanContentResource
	 */
	public $resource;

	/**
	 * 
	 *
	 * @var array of BorhanOperationAttributes
	 */
	public $operationAttributes;

	/**
	 * ID of alternative asset params to be used instead of the system default flavor params 
	 * 	 
	 *
	 * @var int
	 */
	public $assetParamsId = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPartnerFilter extends BorhanPartnerBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPermissionFilter extends BorhanPermissionBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPermissionItemFilter extends BorhanPermissionItemBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanRemoteStorageResources extends BorhanContentResource
{
	/**
	 * Array of remote stoage resources 
	 * 	 
	 *
	 * @var array of BorhanRemoteStorageResource
	 */
	public $resources;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanReportFilter extends BorhanReportBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSearchComparableCondition extends BorhanSearchCondition
{
	/**
	 * 
	 *
	 * @var BorhanSearchConditionComparison
	 */
	public $comparison = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanStorageProfileFilter extends BorhanStorageProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanStringResource extends BorhanContentResource
{
	/**
	 * Textual content
	 * 	 
	 *
	 * @var string
	 */
	public $content = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUiConfFilter extends BorhanUiConfBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUploadTokenFilter extends BorhanUploadTokenBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUserFilter extends BorhanUserBaseFilter
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $idOrScreenNameStartsWith = null;

	/**
	 * 
	 *
	 * @var string
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
	 * @var BorhanNullableBoolean
	 */
	public $loginEnabledEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $roleIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $roleIdsEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $roleIdsIn = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $firstNameOrLastNameStartsWith = null;

	/**
	 * Permission names filter expression
	 * 	 
	 *
	 * @var string
	 */
	public $permissionNamesMultiLikeOr = null;

	/**
	 * Permission names filter expression
	 * 	 
	 *
	 * @var string
	 */
	public $permissionNamesMultiLikeAnd = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUserLoginDataFilter extends BorhanUserLoginDataBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUserRoleFilter extends BorhanUserRoleBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWidgetFilter extends BorhanWidgetBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAdminUserBaseFilter extends BorhanUserFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAmazonS3StorageProfileBaseFilter extends BorhanStorageProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanApiActionPermissionItemBaseFilter extends BorhanPermissionItemFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanApiParameterPermissionItemBaseFilter extends BorhanPermissionItemFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanAssetParamsOutputBaseFilter extends BorhanAssetParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanBatchJobFilterExt extends BorhanBatchJobFilter
{
	/**
	 * 
	 *
	 * @var string
	 */
	public $jobTypeAndSubTypeIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDataEntryBaseFilter extends BorhanBaseEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileAkamaiHttpBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileGenericAppleHttpBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileGenericHdsBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileGenericHttpBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileGenericSilverLightBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileLiveAppleHttpBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileRtmpBaseFilter extends BorhanDeliveryProfileFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanFlavorAssetBaseFilter extends BorhanAssetFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $flavorParamsIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorParamsIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanFlavorAssetStatus
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
	 * @var string
	 */
	public $statusNotIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanFlavorParamsBaseFilter extends BorhanAssetParamsFilter
{
	/**
	 * 
	 *
	 * @var BorhanContainerFormat
	 */
	public $formatEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanGenericSyndicationFeedBaseFilter extends BorhanBaseSyndicationFeedFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanGoogleVideoSyndicationFeedBaseFilter extends BorhanBaseSyndicationFeedFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanITunesSyndicationFeedBaseFilter extends BorhanBaseSyndicationFeedFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveEntry extends BorhanMediaEntry
{
	/**
	 * The message to be presented when the stream is offline
	 * 	 
	 *
	 * @var string
	 */
	public $offlineMessage = null;

	/**
	 * Recording Status Enabled/Disabled
	 * 	 
	 *
	 * @var BorhanRecordStatus
	 * @insertonly
	 */
	public $recordStatus = null;

	/**
	 * DVR Status Enabled/Disabled
	 * 	 
	 *
	 * @var BorhanDVRStatus
	 * @insertonly
	 */
	public $dvrStatus = null;

	/**
	 * Window of time which the DVR allows for backwards scrubbing (in minutes)
	 * 	 
	 *
	 * @var int
	 * @insertonly
	 */
	public $dvrWindow = null;

	/**
	 * Elapsed recording time (in msec) up to the point where the live stream was last stopped (unpublished).
	 * 	 
	 *
	 * @var int
	 */
	public $lastElapsedRecordingTime = null;

	/**
	 * Array of key value protocol->live stream url objects
	 * 	 
	 *
	 * @var array of BorhanLiveStreamConfiguration
	 */
	public $liveStreamConfigurations;

	/**
	 * Recorded entry id
	 * 	 
	 *
	 * @var string
	 */
	public $recordedEntryId = null;

	/**
	 * Flag denoting whether entry should be published by the media server
	 * 	 
	 *
	 * @var BorhanLivePublishStatus
	 */
	public $pushPublishEnabled = null;

	/**
	 * Array of publish configurations
	 * 	 
	 *
	 * @var array of BorhanLiveStreamPushPublishConfiguration
	 */
	public $publishConfigurations;

	/**
	 * The first time in which the entry was broadcast
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $firstBroadcast = null;

	/**
	 * The Last time in which the entry was broadcast
	 * 	 
	 *
	 * @var int
	 * @readonly
	 */
	public $lastBroadcast = null;

	/**
	 * The time (unix timestamp in milliseconds) in which the entry broadcast started or 0 when the entry is off the air
	 * 	 
	 *
	 * @var float
	 */
	public $currentBroadcastStartTime = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanPlaylistBaseFilter extends BorhanBaseEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanServerFileResource extends BorhanDataCenterContentResource
{
	/**
	 * Full path to the local file 
	 * 	 
	 *
	 * @var string
	 */
	public $localFilePath = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanSshUrlResource extends BorhanUrlResource
{
	/**
	 * SSH private key
	 * 	 
	 *
	 * @var string
	 */
	public $privateKey = null;

	/**
	 * SSH public key
	 * 	 
	 *
	 * @var string
	 */
	public $publicKey = null;

	/**
	 * Passphrase for SSH keys
	 * 	 
	 *
	 * @var string
	 */
	public $keyPassphrase = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanThumbAssetBaseFilter extends BorhanAssetFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $thumbParamsIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $thumbParamsIdIn = null;

	/**
	 * 
	 *
	 * @var BorhanThumbAssetStatus
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
	 * @var string
	 */
	public $statusNotIn = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanThumbParamsBaseFilter extends BorhanAssetParamsFilter
{
	/**
	 * 
	 *
	 * @var BorhanContainerFormat
	 */
	public $formatEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanTubeMogulSyndicationFeedBaseFilter extends BorhanBaseSyndicationFeedFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanUploadedFileTokenResource extends BorhanDataCenterContentResource
{
	/**
	 * Token that returned from upload.upload action or uploadToken.add action. 
	 * 	 
	 *
	 * @var string
	 */
	public $token = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanWebcamTokenResource extends BorhanDataCenterContentResource
{
	/**
	 * Token that returned from media server such as FMS or red5.
	 * 	 
	 *
	 * @var string
	 */
	public $token = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanYahooSyndicationFeedBaseFilter extends BorhanBaseSyndicationFeedFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAdminUserFilter extends BorhanAdminUserBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAmazonS3StorageProfileFilter extends BorhanAmazonS3StorageProfileBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanApiActionPermissionItemFilter extends BorhanApiActionPermissionItemBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanApiParameterPermissionItemFilter extends BorhanApiParameterPermissionItemBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanAssetParamsOutputFilter extends BorhanAssetParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDataEntryFilter extends BorhanDataEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileAkamaiHttpFilter extends BorhanDeliveryProfileAkamaiHttpBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileGenericAppleHttpFilter extends BorhanDeliveryProfileGenericAppleHttpBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileGenericHdsFilter extends BorhanDeliveryProfileGenericHdsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileGenericHttpFilter extends BorhanDeliveryProfileGenericHttpBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileGenericSilverLightFilter extends BorhanDeliveryProfileGenericSilverLightBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileLiveAppleHttpFilter extends BorhanDeliveryProfileLiveAppleHttpBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileRtmpFilter extends BorhanDeliveryProfileRtmpBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanFlavorAssetFilter extends BorhanFlavorAssetBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanFlavorParamsFilter extends BorhanFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericSyndicationFeedFilter extends BorhanGenericSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGoogleVideoSyndicationFeedFilter extends BorhanGoogleVideoSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanITunesSyndicationFeedFilter extends BorhanITunesSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveChannel extends BorhanLiveEntry
{
	/**
	 * Playlist id to be played
	 * 	 
	 *
	 * @var string
	 */
	public $playlistId = null;

	/**
	 * Indicates that the segments should be repeated for ever
	 * 	 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $repeat = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamEntry extends BorhanLiveEntry
{
	/**
	 * The stream id as provided by the provider
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $streamRemoteId = null;

	/**
	 * The backup stream id as provided by the provider
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $streamRemoteBackupId = null;

	/**
	 * Array of supported bitrates
	 * 	 
	 *
	 * @var array of BorhanLiveStreamBitrate
	 */
	public $bitrates;

	/**
	 * 
	 *
	 * @var string
	 */
	public $primaryBroadcastingUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $secondaryBroadcastingUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $primaryRtspBroadcastingUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $secondaryRtspBroadcastingUrl = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $streamName = null;

	/**
	 * The stream url
	 * 	 
	 *
	 * @var string
	 */
	public $streamUrl = null;

	/**
	 * HLS URL - URL for live stream playback on mobile device
	 * 	 
	 *
	 * @var string
	 */
	public $hlsStreamUrl = null;

	/**
	 * URL Manager to handle the live stream URL (for instance, add token)
	 * 	 
	 *
	 * @var string
	 */
	public $urlManager = null;

	/**
	 * The broadcast primary ip
	 * 	 
	 *
	 * @var string
	 */
	public $encodingIP1 = null;

	/**
	 * The broadcast secondary ip
	 * 	 
	 *
	 * @var string
	 */
	public $encodingIP2 = null;

	/**
	 * The broadcast password
	 * 	 
	 *
	 * @var string
	 */
	public $streamPassword = null;

	/**
	 * The broadcast username
	 * 	 
	 *
	 * @var string
	 * @readonly
	 */
	public $streamUsername = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanPlaylistFilter extends BorhanPlaylistBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanThumbAssetFilter extends BorhanThumbAssetBaseFilter
{
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
class BorhanThumbParamsFilter extends BorhanThumbParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanTubeMogulSyndicationFeedFilter extends BorhanTubeMogulSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanYahooSyndicationFeedFilter extends BorhanYahooSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanDeliveryProfileGenericRtmpBaseFilter extends BorhanDeliveryProfileRtmpFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanFlavorParamsOutputBaseFilter extends BorhanFlavorParamsFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $flavorParamsIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorParamsVersionEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorAssetIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $flavorAssetVersionEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanGenericXsltSyndicationFeedBaseFilter extends BorhanGenericSyndicationFeedFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveAssetBaseFilter extends BorhanFlavorAssetFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamAdminEntry extends BorhanLiveStreamEntry
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMediaFlavorParamsBaseFilter extends BorhanFlavorParamsFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMixEntryBaseFilter extends BorhanPlayableEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanThumbParamsOutputBaseFilter extends BorhanThumbParamsFilter
{
	/**
	 * 
	 *
	 * @var int
	 */
	public $thumbParamsIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $thumbParamsVersionEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $thumbAssetIdEqual = null;

	/**
	 * 
	 *
	 * @var string
	 */
	public $thumbAssetVersionEqual = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanDeliveryProfileGenericRtmpFilter extends BorhanDeliveryProfileGenericRtmpBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanFlavorParamsOutputFilter extends BorhanFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanGenericXsltSyndicationFeedFilter extends BorhanGenericXsltSyndicationFeedBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveAssetFilter extends BorhanLiveAssetBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveParamsFilter extends BorhanLiveParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaFlavorParamsFilter extends BorhanMediaFlavorParamsBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMixEntryFilter extends BorhanMixEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanThumbParamsOutputFilter extends BorhanThumbParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveEntryBaseFilter extends BorhanMediaEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanMediaFlavorParamsOutputBaseFilter extends BorhanFlavorParamsOutputFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveEntryFilter extends BorhanLiveEntryBaseFilter
{
	/**
	 * 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $isLive = null;

	/**
	 * 
	 *
	 * @var BorhanNullableBoolean
	 */
	public $isRecordedEntryIdEmpty = null;


}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanMediaFlavorParamsOutputFilter extends BorhanMediaFlavorParamsOutputBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveChannelBaseFilter extends BorhanLiveEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveStreamEntryBaseFilter extends BorhanLiveEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveChannelFilter extends BorhanLiveChannelBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamEntryFilter extends BorhanLiveStreamEntryBaseFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
abstract class BorhanLiveStreamAdminEntryBaseFilter extends BorhanLiveStreamEntryFilter
{

}

/**
 * @package Borhan
 * @subpackage Client
 */
class BorhanLiveStreamAdminEntryFilter extends BorhanLiveStreamAdminEntryBaseFilter
{

}

