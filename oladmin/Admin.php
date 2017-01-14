<?php 
namespace OlAdmin;

class Admin{
	protected $username;
	protected $email;
	protected $password;
	protected $id;

	public function getId()
	{
	    return $this->id;
	}

	public function getUsername()
	{
	    return $this->username;
	}

	public function getEmail()
	{
	    return $this->email;
	}

	public function getPassword()
	{
	    return $this->password;
	}

}
