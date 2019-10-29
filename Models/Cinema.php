<?php

namespace Models;

class Cinema
{
	private $id;
	private $status;
	private $name;
	private $address;
	private $billBoard = array();
	private $seats = array();
	private $ticketPrice;

	public function __construct(){
		$this->status = true;
	}

	public function createSeats($cant)
	{
		for ($i = 1; $i <= $cant; $i++) {
			$seat = new Seat($i, false);
			array_push($this->seats, $seat);
		}
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

	public function getSeatsNumer(){
		return count($this->seats);
	}

	public function setSeats($seats){
		$this->seats = $seats;
	}

	public function getSeats(){
		return $this->seats;
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
}
