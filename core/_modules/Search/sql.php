<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Search;

class Sql {
	public static 
	   $sqlIndoc = '
			SELECT
				id,
                name_doc,
                reg_number,
                reg_date,
                params,
                _updated,
                _deleted
			FROM
				eds_karkas__document
		';
	

}