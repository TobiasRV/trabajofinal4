<?php

namespace Models;

use Models\Seat as Seat;

class Cinema
{
	private $id;
	private $status;
	private $name;
	private $seats = array();
	private $idMovieTheater;

	public function __construct()
	{	
		$this->status = true;
	}

	public function createSeats($seatsNumber)
	{
		$this->seats = array();
		
		for ($i = 1; $i <= $seatsNumber; $i++) {
			$seat = new Seat($i, false);
			array_push($this->seats, $seat);
		}
	}

	public function getIdMovieTheater(){
		return $this->idMovieTheater;
	}

	public function setIdMovieTheater($idMovieTheater){
		$this->idMovieTheater = $idMovieTheater;
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

	public function getSeats(){
		return $this->seats;
	}
	public function setSeats($seats){
		$this->seats = $seats;
	}

	public function getShows()
	{
		return $this->shows;
	}

	public function setShows($shows)
	{
		$this->shows = $shows;
    }
}
