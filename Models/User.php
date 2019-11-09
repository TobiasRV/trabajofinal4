<?php namespace Models;

class User{
	private $id;
    private $userName;
    private $password;
    private $email;
    private $firstname;
    private $lastname;
    private $permissions; //asignar un id dependiendo del rol, en un futuro pueden existir mas roles como gerente, empleado, etc
	//1 Admin, 2 Client
	private $tickets = array();
	private $dni;
	private $creditCards = array();

    public function __construct($userName=null, $password=null, $email=null, $firstname=null, $lastname=null, $permissions=null, $dni=null)
    {

	}

	public function getId(){
		return $this->id;
	}

	
	public function setId($id){
		$this->id=$id;
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

	public function getDni(){
		return $this->dni;
	}

	public function setDni($dni){
		$this->dni = $dni;
	}

	public function getCreditCards(){
		return $this->creditCards;
	}

	public function setCreditCards($creditCards){
		$this->creditCards = $creditCards;
	}
}