<?php namespace Models;

class Show
{
    private $id;
    private $date;
    private $id_cinema;
    private $id_movie;

    public function __construct($id=null, $date=null, $id_cinema=null, $id_movie=null)
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id=$id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date=$date;
    }

    public function getId_cinema()
    {
        return $this->id_cinema;
    }

    public function setId_cinema($id_cinema)
    {
        $this->id_cinema=$id_cinema;
    }

    public function getId_movie()
    {
        return $this->id_movie;
    }

    public function setId_movie($id_movie)
    {
        $this->id_movie=$id_movie;
    }
}