<?php

namespace Models;

class Cinema
{
	private $id;
	private $status;
	private $name;
	private $seats;
	private $idMovieTheater;

	public function __construct($id = null,$status = null,$name = null, $seats = null)
	{	
		$this->id = $id;
		$this->status = true;
		$this->name = $name;
		$this->seats = $seats;
	}

	// public function createSeats($cant)
	// {
	// 	for ($i = 1; $i <= $cant; $i++) {
	// 		$seat = new Seat($i, false);
	// 		array_push($this->seats, $seat);
	// 	}
	// }

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
