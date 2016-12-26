<?php

namespace Model\Model;

use Model\Model\Base\Participant as BaseParticipant;
use Model\Model\ChallanQuery;

/**
 * Skeleton subclass for representing a row from the 'participant' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Participant extends BaseParticipant
{
	public function isPaid(){
		// $stmt = $mpdo->prepare("select PaymentStatus from challan where ChallanID = ")
		$challan = ChallanQuery::create()->filterByChallanId($this->registrationchallanid)->findOne();
		return $challan->getPaymentStatus();
	}

}
