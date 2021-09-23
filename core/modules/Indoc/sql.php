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
                step,
                step_role,
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
	 
	   public static
	   $sqlDocLog = '
			SELECT
				id,
                doc_id,
				action,
                comment,
                user_id,
                _updated,
                _deleted
			FROM
				eds_karkas__doclog
		';
	

}