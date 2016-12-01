<?php 
namespace App;
require_once("../bootstrap.php");

class Register{
	private $conn;
	public function __construct($data){
		$this->conn = new mysqli($dbconf['host'], $dbconf['username'], $dbconf['pwd'], $dbconf['dbname']);
		$data
	}




}
