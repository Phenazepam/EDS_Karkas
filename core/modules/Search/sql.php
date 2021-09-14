<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Search;

class Sql {
	public static 
	   $sqlSearch = '
			SELECT
				id,
				name,
                reg_number,
				date_create,
                Status
			FROM
				search
		';
	

}