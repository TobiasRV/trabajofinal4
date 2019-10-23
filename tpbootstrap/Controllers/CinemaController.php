<?php

namespace Controllers;

ini_set("max_execution_time", 0);

use DAO\CinemaRepository as CinemaRepository;
use Controllers\MovieController as movieController;
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
        require_once(VIEWS_PATH . "addcinema.php");
    }

    public function addCinema()
    {
        if ($_POST) {

            $cinema = new Cinema();
            $cinema->setName($_POST['name']);
            $cinema->setAddress($_POST['address']);
            $cinema->createSeats($_POST['seats']);
            $cinema->setTicketPrice($_POST['price']);

            $pelisPost = array();
            $pelisPost = $_POST['moviechecked'];
            $arrayPeliculas = array();

            $movieController = new movieController();

            foreach ($pelisPost as $title) {
                array_push($arrayPeliculas, $movieController->searchMovieByTitle($title));
            }
            
            $cinema->setBillBoard($arrayPeliculas);

            $this->cineDAO->Add($cinema);
            require_once(VIEWS_PATH . "listcinemas.php");
        }
    }

    public function listCinemas(){
        require_once(VIEWS_PATH . "listcinemas.php");
    }

    public function deleteCinema($name){
        $this->cineDAO->deleteCinema($name);
        require_once(VIEWS_PATH . "listcinemas.php");
    }
}
