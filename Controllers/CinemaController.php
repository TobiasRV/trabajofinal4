<?php

namespace Controllers;

use Controllers\MovieTheaterController as MovieTheaterController;
use Controllers\ShowController as ShowController;
use Models\Cinema as Cinema;

use DAOJson\CinemaDAO as CinemaDAO;
//use DAO\CinemaRepository as CinemaDAO;


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

        foreach ($cinemaList as $cinema) {
            if ($cinema->getName() == $cinemaName) {
                $result = $cinema->getId();
                break;
            }
        }
        return $result;
    }

    public function getShowsByCinemaList($cinemaList = array())
    {

        $result = array();

        foreach ($cinemaList as $cinema) {
            $showsList = $this->showController->getShowListByCinema($cinema);
            foreach ($showsList as $show) {
                array_push($result, $show);
            }
        }

        return $result;
    }

    public function getCinemaList($idMovieTheater)
    {

        $result = array();

        foreach ($this->cinemaDAO->getAll() as $cinema) {
            if ($cinema->getIdMovieTheater() == $idMovieTheater)
                array_push($result, $cinema);
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
        $cinema->setId($this->getNextId());
        $cinema->setName($name);
        $cinema->createSeats($seatsNumber);
        $cinema->setTicketPrice($price);
        $cinema->setIdMovieTheater($idMovieTheater);

        $this->cinemaDAO->Add($cinema);
    }

    public function getNextId()
    {
        $cinemaList = $this->cinemaDAO->getAll();

        if (empty($cinemaList)) {
            $newId = 1;
        } else {
            $lastElement = end($cinemaList);
            $newId = $lastElement->getId() + 1;
        }
        return $newId;
    }

    public function modifyCinema($id, $status, $name, $seatsNumber, $idMovieTheater)
    {
        $cinemaList = $this->cinemaDAO->getAll();

        foreach ($cinemaList as $cinema) {
            if ($cinema->getId() == $id) {
                $cinema->setStatus($status);
                $cinema->setName($name);
                $cinema->createSeats($seatsNumber);
                $cinema->setIdMovieTheater($idMovieTheater);
                break;
            }
        }
        $this->showDAO->saveList($cinemaList);
    }

    public function deleteAllCinemaById($idCinemaList = array())
    {
        foreach ($idCinemaList as $idCinema) {
            $this->deleteCinemaById($idCinema);
        }
    }

    public function deleteCinemaByMovieTheaterId($movieTheaterId)
    {

        $cinemaList = $this->cinemaDAO->getAll();

        foreach ($cinemaList as $cinema) {
            if ($cinema->getIdMovieTheater() == $movieTheaterId) {
                $this->showController->deleteAllShowsById($cinema->getId());
                $idToDelete = array_search($cinema, $cinemaList);
                unset($cinemaList[$idToDelete]);
            }
        }

        $this->cinemaDAO->saveNewList($cinemaList);
    }

    public function deleteCinemaById($id)
    {

        $cinemaList = $this->cinemaDAO->getAll();

        foreach ($cinemaList as $cinema) {
            if ($cinema->getId() == $id) {
                $this->showController->deleteAllShowsById($id);
                $idToDelete = array_search($cinema, $cinemaList);
                unset($cinemaList[$idToDelete]);
                break;
            }
        }

        $this->cinemaDAO->saveNewList($cinemaList);
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
}
