<?php namespace KlinkDMS\Exceptions;


use Exception;
use KlinkDMS\Group;


/**
* States that a @see Group with the same uniqueness attributes already exists
*/
final class GroupAlreadyExistsException extends Exception
{
	

	function __construct($groupName, Group $parent = null) {
		parent::__construct( 
			is_null($parent) ? trans('errors.group_already_exists_exception.only_name', ['name' => $groupName]) : trans('errors.group_already_exists_exception.name_and_parent', ['name' => $groupName, 'parent' => $parent->name]), 21 );
	}
	
}