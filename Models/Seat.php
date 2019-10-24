<?php namespace Models;

class Seat{
    private $number;
    private $status;

    public function __construct($number,$status)
    {
        $this->number = $number;
        $this->status = $status;
    }

    public function getNumber(){
		return $this->number;
	}

	public function setNumber($number){
		$this->number = $number;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}
}