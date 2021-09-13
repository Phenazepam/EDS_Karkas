<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\DocTypes;

class Sql {
	public static 
	   $sqlDocTypes = '
			SELECT
				id,
				title,
                _updated,
                _deleted
			FROM
				eds_karkas__docTypes
		';
	

}