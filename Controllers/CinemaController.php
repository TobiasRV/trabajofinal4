<?php

namespace Controllers;

ini_set("max_execution_time", 0);

use DAO\CinemaRepository as CinemaRepository;
use Controllers\MovieController as MovieController;
use Models\Cinema as Cinema;


class CinemaController
{

    private $cineDAO;

    public function __construct()
    {
        $this->cineDAO = new CinemaRepository();
    }

    public function formAddCinema()
    {
        $movieController = new MovieController();
        $nowPlaying = $movieController->getNowPlaying();

        // Traer todos los generos y guardarlos en un array
        
        require_once(VIEWS_PATH . "addcinema.php");
    }

    public function addCinema($name, $address, $seats, $price, $moviechecked = array())
    {
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->setAddress($address);
        $cinema->createSeats($seats);
        $cinema->setTicketPrice($price);

        $pelisPost = array();
        $pelisPost = $moviechecked;
        $arrayPeliculas = array();

        $movieController = new MovieController();

        foreach ($pelisPost as $title) {
            array_push($arrayPeliculas, $movieController->searchMovieByTitle($title));
        }
        
        $cinema->setBillBoard($arrayPeliculas);

        $this->cineDAO->Add($cinema);
        require_once(VIEWS_PATH . "listcinemas.php");
    }

    public function listCinemas(){
        require_once(VIEWS_PATH . "listcinemas.php");
    }

    public function deleteCinema($name){
        $this->cineDAO->deleteCinema($name);
        require_once(VIEWS_PATH . "listcinemas.php");
    }
}
