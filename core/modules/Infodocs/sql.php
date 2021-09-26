<?php

/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */

namespace RedCore\Infodocs;

class Sql {
	public static 
	   $sqlInfodocsAgents = '
			SELECT
				id,
				name,
				inn,
				group_ka,
				material,
				main_worker,
				other,
				params,
                _deleted
			FROM
				eds_karkas__infodocsagents
		';
		
	public static
		$sqlInfodocsMain = '
			SELECT
				id,
				title,
				param_link,
				params,
                _deleted
			FROM
				eds_karkas__infodocs
		';
	
	public static
		$sqlInfodocsWorks = '
			SELECT
				id,
				group,
				name,
				izm,
				krd,
				rnd,
				vldvstk,
				obj1,
				obj2,
				obj3,
				obj4,
				params,
                _deleted
			FROM
				eds_karkas__infodocsworks
		';
		
		public static
		$sqlInfodocsMaterials = '
			SELECT
				id,
				su,
				code,
				group,
				material,
				izm,
                _deleted
			FROM
				eds_karkas__infodocsmaterials
		';

}