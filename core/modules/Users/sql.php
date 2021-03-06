<?php

/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Users;

class Sql {
	public static 
		$sqlUsers = '
			SELECT
				id,
				login,
				password,
				role,
                device_key,
				token_key,
				params
			FROM
				eds_karkas__users
		';
	public static 
		$sqlAccessMatrix = '
			SELECT
				id,
				doctype,
				roles,
                _deleted
			FROM
				eds_karkas__accessmatrix
		';
	public static 
		$sqlDocTypeRoleMatrix = '
			SELECT
				id,
				doctype,
				step_order,
				step,
				role
			FROM
				eds_karkas__doctyperolematrix
		';
	

	
}