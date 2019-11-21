<?php

namespace Controllers;

use Controllers\MovieTheaterController as MovieTheaterController;
use Controllers\ShowController as ShowController;
use Controllers\UserController as UserController;
use Models\Cinema as Cinema;

// use DAOJson\CinemaDAO as CinemaDAO;
// use DAOJson\MovieTheaterDAO as MovieTheaterRepository;
use DAO\CinemaRepository as CinemaDAO;
use DAO\MovieTheaterRepository as MovieTheaterRepository;


class CinemaController
{

    private $cinemaDAO;
    private $showController;

    public function __construct()
    {
        $this->cinemaDAO = new CinemaDAO();
        $this->showController = new ShowController();
    }

    public function getCinemaIdByName($cinemaName)
    {

        $cinemaList = $this->cinemaDAO->getAll();

        $result = null;
        if(is_array($cinemaList)){
            foreach ($cinemaList as $cinema) {
                if ($cinema->getName() == $cinemaName) {
                    $result = $cinema->getId();
                    break;
                }
            }
        }
        else{
            if ($cinemaList->getName() == $cinemaName) {
                $result = $cinemaList->getId();
            }
        }
        return $result;
    }

    public function getShowsByCinemaList($cinemaList = null)
    {

        $result = array();
        if($cinemaList != false){
            if(!is_array($cinemaList)){ 
                $aux = $cinemaList;
                $cinemaList = array();
                array_push($cinemaList,$aux);
            }
            foreach ($cinemaList as $cinema) 
            {
                $showsList = $this->showController->getShowListByCinema($cinema);
                if($showsList != false)
                {
                    if(!is_array($showsList)){
                        $aux = $showsList;
                        $showsList = array();
                        array_push($showsList,$aux);
                    }
                    foreach ($showsList as $show) {
                        array_push($result, $show);
                    }
                }
            }
        }
        return $result;
    }

    public function getCinemaList($idMovieTheater)
    {

        $result = array();
        $cinemasArray = $this->cinemaDAO->getAll();
        if($cinemasArray !=null){
            if(is_array($cinemasArray)){ 
                foreach ($cinemasArray as $cinema) {
                    if ($cinema->getIdMovieTheater() == $idMovieTheater)
                        array_push($result, $cinema);
                }       
            }   
            else{
                if ($cinemasArray->getIdMovieTheater() == $idMovieTheater)
                array_push($result, $cinemasArray);
             }
    }

        return $result;
    }

    public function getListIdCinema($idMovieTheater)
    {

        $result = array();

        foreach ($this->cinemaDAO->getAll() as $cinema) {
            if ($cinema->getIdMovieTheater() == $idMovieTheater)
                array_push($result, $cinema->getId());
        }

        return $result;
    }


    public function createCinema($name, $seatsNumber, $price, $idMovieTheater)
    {
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->createSeats($seatsNumber);
        $cinema->setTicketPrice($price);
        $cinema->setIdMovieTheater($idMovieTheater);
        $cinema->setStatus(true);

        $this->cinemaDAO->Add($cinema);
    }

    public function modifyCinema($id, $status, $name, $seatsNumber, $ticketPrice, $idMovieTheater)
    {
        $movieTheaterController = new MovieTheaterController();
        $cinemaList = $this->cinemaDAO->getAll();
        $cinemaAux = new Cinema();
        foreach ($cinemaList as $cinema) {
            if ($cinema->getId() == $id) {
                $cinemaAux->setId($id);
                $cinemaAux->setStatus($status);
                $cinemaAux->setName($name);
                $cinemaAux->setTicketPrice($ticketPrice);
                $cinemaAux->createSeats($seatsNumber);
                $cinemaAux->setIdMovieTheater($idMovieTheater);
                break;
            }
        }
        $this->cinemaDAO->edit($cinemaAux);
        
        $movieTheaterController->listCinemas();

    }

    public function viewModifyCinema($idCinema){
        $cinema = $this->getCinemaById($idCinema);

        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "navAdmin.php");

        require_once(VIEWS_PATH . "modifycinema.php");
    }
    

    public function deleteAllCinemaById($idCinemaList = array())
    {
        foreach ($idCinemaList as $idCinema) {
            $this->deleteCinemaById($idCinema);
        }
    }

    public function deleteCinemaById($id)
    {
        //aca pongo showdelete
        $this->showController->deleteAllShowsById($id);
        $this->cinemaDAO->deleteFisico($id);
    }

    

    public function deleteCinemaByMovieTheaterId($movieTheaterId)
    {
        $cinemaList = $this->cinemaDAO->getAll();
        foreach ($cinemaList as $cinema) {
            if ($cinema->getIdMovieTheater() == $movieTheaterId) {
                $this->deleteCinemaById($cinema->getId());
            }
        }
    }




    public function deleteCinemaViewThree($id, $movieTheaterName)
    {
        $movieTheaterController = new MovieTheaterController();
        $this->deleteCinemaById($id);
        $movieTheaterController->viewCreateMovieTheaterThree($movieTheaterName);
    }

    public function getSeats($idCinemaName)
    {

        $cinemaList = $this->cinemaDAO->getAll();

        $result = null;

        foreach ($cinemaList as $cinema) {
            if ($cinema->getId() == $idCinemaName) {
                $result = $cinema->countSeats();
                break;
            }
        }
        return $result;
    }

    public function getCinemaById($id){
        $cinemaList = $this->cinemaDAO->getAll();
        $result = null;
        foreach($cinemaList as $cinema){
            if($cinema->getId() == $id){
                $result = $cinema;
            break;
            }
        }
        return $result;
    }


    public function showPrices()
    {
        $cinemasRepo = new CinemaDAO();
        $listadoC = $cinemasRepo->getAll();
        $movieTheatersRepo = new MovieTheaterRepository();
        $listadoMT = $movieTheatersRepo->getAll();
        $userControl = new UserController();

        if(!is_array($listadoC))
        {
            $aux = $listadoC;
            $listadoC = array();
            array_push($listadoC,$aux);
        }
        if(!is_array($listadoMT))
        {
            $aux = $listadoMT;
            $listadoMT = array();
            array_push($listadoMT,$aux);
        }

        if ($userControl->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 1) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navAdmin.php");
                include_once(VIEWS_PATH . "prices.php");
            } 
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    include_once(VIEWS_PATH . "prices.php");
                }
            }
        } 
        else 
        {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "prices.php");
        }
    }
}
