<?php 
namespace OlAdmin;
// require_once(__DIR__."/bootstrap.php");

use OlAdmin\Admin;
class Auth{
	protected $admin;
	private $mpdo;

	public function __construct($mpdo){
		$this->mpdo = $mpdo;
	}

	public function login($username, $password){
		$stmt = $this->mpdo->prepare("select * from admins where username=?");
		$stmt->execute([$username]);
		if(!$stmt->rowCount()){
			return false;
		}
		$admin = $stmt->fetchAll(\PDO::FETCH_CLASS, Admin::class)[0];

		if(!password_verify($password, $admin->getPassword())){
			return false;
		}
		$this->admin = $admin;
		$_SESSION['admin'] = $admin->getUsername();
		return $this->admin;
	}
	protected function getFromSession(){
		$stmt = $this->mpdo->prepare("select * from admins where username = ?");
		$stmt->execute([$_SESSION['admin']]);
		return $this->admin = $stmt->fetchAll(\PDO::FETCH_CLASS, Admin::class)[0];
	}
	public function getAdmin(){
		if(!$this->admin){
			return $this->getFromSession();
		}
		return $this->admin;
	}

	public function logout(){
		if($this->isAdmin())
			unset($_SESSION['admin']);
	}

	public function isAdmin(){
		return isset($_SESSION['admin']);
	}

	public function onlyAdmin($url = "/oladmin/login"){
		if(!$this->isAdmin())
			\App\redirect($url);
	}

	public function onlyNotAdmin($ul = "/oladmin"){
		if($this->isAdmin())
			\App\redirect($url);
	}


}


?>