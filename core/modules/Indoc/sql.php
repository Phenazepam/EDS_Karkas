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
				status,
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

	   public static
	   $sqlDocRoute = '
			SELECT
				id,
				doc_id,
				doc_type,
				role_id,
				user_id,
				step,
				step_order,
				iscurrent,
                _updated,
                _deleted
			FROM
				eds_karkas__docroute
		';

	   public static
	   $sqlRelatedDocs = '
			SELECT
				id,
				doc_id,
				relateddoc_id,
				type,
                _updated,
                _deleted
			FROM
				eds_karkas__relateddocs
		';
	

}