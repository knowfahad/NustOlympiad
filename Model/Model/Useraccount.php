<?php

namespace Model\Model;

use Model\Model\Base\Useraccount as BaseUseraccount;

/**
 * Skeleton subclass for representing a row from the 'useraccount' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Useraccount extends BaseUseraccount
{
	public function isVerified(){
		return $this->getAccountstatus();
	}
}
