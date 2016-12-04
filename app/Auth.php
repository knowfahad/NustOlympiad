<?php 
namespace App;
require_once (__DIR__.'/../bootstrap.php');

use Model\Model\ParticipantQuery;
use Model\Model\Useraccount;
use Model\Model\UseraccountQuery;

/**
* Class to login/logout and other auth operations
*/
class Auth
{
	private $userquery;
	private $user;
	function __construct()
	{
		$this->userquery = new UseraccountQuery();
	}

	public function login($username, $password){
		if($this->loggedIn())
			return 0;
		$user = $this->userquery->filterByUsername($username)
						->findOne();
		if(!$user)
			return false;
		if(!password_verify($password, $user->getPassword())){
			return false;
		}
		$_SESSION['username'] = $user->getUsername();
		return true;
	}
	private function queryUser(){
		$this->user = $this->userquery->findPK($_SESSION['username']);
		return $this->user;
	}
	public function User(){
		if($this->isGuest()){
			return false;
		}
		if(!$this->user)
			return $this->queryUser();
		return $this->user;
	}

	public function isGuest(){
		return !isset($_SESSION['username']);
	}

	public function loggedIn(){
		return !$this->isGuest();
	}

	public function logout(){
		if($this->isGuest())
			return 0;
		unset($_SESSION['username']);
		return 1;
	}

	public function getParticipant(){
		$cnic = $this->User()->getParticipantCNIC();
		return  ParticipantQuery::create()->filterByCNIC($cnic)->findOne();
	}

	public function onlyLoggedIn($url = null){
		if(!$url)
			$url = '/login';
		if($this->isGuest())
			\App\redirect($url);
		// exit();
	}
	public function onlyGuests($url = null){
		if(!$url)
			$url = '/dashboard';
		if($this->isGuest())
			\App\redirect($url);
	}

	public function onlyVerified(){
		if(!$this->user->isVerified())
			\App\redirect('/dashboard');
	}

	public function getCNIC(){
		return $this->getParticipant()->getCNIC();
	}
}
