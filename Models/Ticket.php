<?php namespace Models;

class Ticket{
    private $price;
    private $id;
    private $cinema;
    private $seat;
    private $movie;
    private $date;

    public function __construct($price=null, $id=null, $cinema=null, $seat=null, $movie=null, $date=null)
    {
        
    }

    public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getCinema(){
		return $this->cinema;
	}

	public function setCinema($cinema){
		$this->cinema = $cinema;
	}

	public function getSeat(){
		return $this->seat;
	}

	public function setSeat($seat){
		$this->seat = $seat;
	}

	public function getMovie(){
		return $this->movie;
	}

	public function setMovie($movie){
		$this->movie = $movie;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

}