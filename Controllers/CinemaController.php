<?php namespace Controllers;

use DAOJson\CinemaDAO as CinemaDAO;
use Models\Cinema as Cinema;

class CinemaController{
    private $cinemaDAO;
    
    public function __construct()
    { 
        $this->cinemaDAO = new CinemaDAO();
    }

    public function createCinema($name, $seatsNumber, $idMovieTheater)
    {
        $cinema = new Cinema();
        $cinema->setId($this->getNextId());
        $cinema->setName($name);
        $cinema->createSeats($seatsNumber);
        $cinema->setIdMovieTheater($idMovieTheater);

        $this->showDAO->Add($cinema);

    }

    public function getNextId()
    {
        $cinemaList = $this->cinemaDAO->getAll();
        $newId = count($cinemaList) + 1;
        return $newId;
    }

    public function modifyCinema($id, $status, $name, $seatsNumber, $idMovieTheater){
        $cinemaList = $this->cinemaDAO->getAll();

        foreach($cinemaList as $cinema){
            if($cinema->getId() == $id){
                $cinema->setStatus($status);
                $cinema->setName($name);
                $cinema->createSeats($seatsNumber);
                $cinema->setIdMovieTheater($idMovieTheater);
                break;
            }
        }
        $this->showDAO->saveList($cinemaList);
    }


}