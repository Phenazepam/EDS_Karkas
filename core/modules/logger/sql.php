<?php

/**
 * @copyright 2019
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Logger;

class Sql {
	public static 
		$sqlLogs = '
			SELECT
				id,
                e_type,
                action,
				message,
				user_id,
				params,
                _updated,
                _deleted
			FROM
				eds_karkas__log
		';
}