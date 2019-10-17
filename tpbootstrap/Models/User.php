<?php namespace Models;

class User{
    private $userName;
    private $password;
    private $email;
    private $firstname;
    private $lastname;
    private $permissions;
    private $tickets = array();

    public function __construct()
    {
        
    }

    public function getUserName(){
		return $this->userName;
	}

	public function setUserName($userName){
		$this->userName = $userName;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getFirstname(){
		return $this->firstname;
	}

	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}

	public function getLastname(){
		return $this->lastname;
	}

	public function setLastname($lastname){
		$this->lastname = $lastname;
	}

	public function getPermissions(){
		return $this->permissions;
	}

	public function setPermissions($permissions){
		$this->permissions = $permissions;
	}

	public function getTickets(){
		return $this->tickets;
	}

	public function setTickets($tickets){
		$this->tickets = $tickets;
	}
}