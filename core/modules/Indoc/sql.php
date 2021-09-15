<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Indoc;

class Sql {
	public static 
	   $sqlIndoc = '
			SELECT
				id,
				name_doc,
				reg_number,
                reg_date,
                resolution,
				params,
                _updated,
                _deleted
			FROM
				eds_karkas__document
		';
	
	 public static
	   $sqlDocTypes = '
			SELECT
				id,
				title,
                _updated,
                _deleted
			FROM
				eds_karkas__doctypes
		';
	

}