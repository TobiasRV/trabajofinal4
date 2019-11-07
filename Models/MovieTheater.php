<?php namespace Models;

class MovieTheater
{ 
	private $id;
	private $status;
	private $name;
	private $address;
    private $ticketPrice;
    private $billBoard = array();
	private $cinemas = array();

    public function __construct($id = null ,$status = null ,$name = null ,$address = null ,$ticketPrice = null)
    {
        $this->id = $id;
		$this->status = true;
    }
    
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setTicketPrice($ticketPrice)
	{
		$this->ticketPrice = $ticketPrice;
	}

	public function getTicketPrice()
	{
		return $this->ticketPrice;
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function getBillBoard()
	{
		return $this->billBoard;
	}

	public function setBillBoard($billBoard)
	{
		$this->billBoard = $billBoard;
    }
    

    public function getCinemas()
	{
		return $this->cinemas;
	}

	public function setCinemas($cinemas)
	{
		$this->cinemas = $cinemas;
	}
}
