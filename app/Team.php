<?php 
namespace App;
require_once(__DIR__."/../bootstrap.php");
use PDO;
/**
 * Teams class
 */
class Team
{
	private $TeamID;
	private $SportID;
	private $TeamName;
	private $HeadCNIC;
	private $ChallanID;
	private $AmountPayable;
	private $DueData;
	private $PaymentStatus;
	private $auth;
	private $conn;

	public function __construct($auth, $conn)
	{
		$this->auth = $auth;
		$this->conn = $conn;
	}

	public function members(){
		$members = [];
		$memberIDs = [];
		$stmt = $this->conn->prepare("select ParticipantID from sportsparticipants where TeamID = ?");
		$stmt->execute([$this->TeamID]);
		$stmt->bindColumn(1,$participantid);
		while($stmt->fetch(PDO::FETCH_BOUND)){
			$memberIDs[] = $participantid;
		}
		foreach($memberIDs as $memberID){
			$stmt = $this->conn->prepare("select * from participant where ParticipantID = ?");
			$stmt->execute([$memberID]);
			$members[] = $stmt->fetchObject();
		}
		return $members;
	}

	public function __get($name){
		return $this->$name;
	}

	public function challan(){
		$stmt = $this->conn->prepare("select * from challan where ChallanID = ?");
		$stmt->execute([$this->ChallanID]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}
