<?php namespace Models;

class Show
{
    private $id;
    private $date;
    private $time;
    private $seats;
    private $status;
    private $idCinema;
    private $idMovie;

    
    public function __construct()
    {
        $this->status = 1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id=$id;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time=$time;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status=$status;
    }
    public function getSeats()
    {
        return $this->seats;
    }

    public function setSeats($seats)
    {
        $this->seats=$seats;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date=$date;
    }

    public function getIdCinema()
    {
        return $this->idCinema;
    }

    public function setIdCinema($idCinema)
    {
        $this->idCinema=$idCinema;
    }

    public function getIdMovie()
    {
        return $this->idMovie;
    }

    public function setIdMovie($idMovie)
    {
        $this->idMovie=$idMovie;
    }
}