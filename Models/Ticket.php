<?php namespace Models;

class Ticket{
    private $idTicket;
    private $idPurchase;
    

    public function __construct($idTicket=null, $idPurchase=null)
    {
        
    }

    public function getIdTicket(){
		return $this->idTicket;
	}

	public function setIdTicket($idTicket){
		$this->idTic$idTicket = $idTicket;
	}

	public function getIdPurchase(){
		return $this->idPurchase;
	}

	public function setIdPurchase($idPurchase){
		$this->idPurchase = $idPurchase;
	}

}