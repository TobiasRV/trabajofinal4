<?php

namespace Controllers;

use Controllers\MovieTheaterController as MovieTheaterController;
use Controllers\ShowController as ShowController;
use Controllers\UserController as UserController;
use Models\Cinema as Cinema;

use DAOJson\CinemaDAO as CinemaDAO;
use DAOJson\MovieTheaterDAO as MovieTheaterRepository;
// use DAO\CinemaRepository as CinemaDAO;
// use DAO\MovieTheaterRepository as MovieTheaterRepository;

use Exception;
use PDOException;


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
        try {
            $cinemaList = $this->cinemaDAO->getAll();

            $result = null;
            if (is_array($cinemaList)) {
                foreach ($cinemaList as $cinema) {
                    if ($cinema->getName() == $cinemaName) {
                        $result = $cinema->getId();
                        break;
                    }
                }
            } else {
                if ($cinemaList->getName() == $cinemaName) {
                    $result = $cinemaList->getId();
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            return $result;
        }
    }
    public function getShowsByCinemaList($cinemaList = null)
    {

        $result = array();
        try {
            if ($cinemaList != false) {
                if (!is_array($cinemaList)) {
                    $aux = $cinemaList;
                    $cinemaList = array();
                    array_push($cinemaList, $aux);
                }
                foreach ($cinemaList as $cinema) {
                    $showsList = $this->showController->getShowListByCinema($cinema);
                    if ($showsList != false) {
                        if (!is_array($showsList)) {
                            $aux = $showsList;
                            $showsList = array();
                            array_push($showsList, $aux);
                        }
                        foreach ($showsList as $show) {
                            array_push($result, $show);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            return $result;
        }
    }

    public function getCinemaList($idMovieTheater)
    {
        $result = array();
        try {
            $cinemasArray = $this->cinemaDAO->getAll();
            if ($cinemasArray != null) {
                if (is_array($cinemasArray)) {
                    foreach ($cinemasArray as $cinema) {
                        if ($cinema->getIdMovieTheater() == $idMovieTheater)
                            array_push($result, $cinema);
                    }
                } else {
                    if ($cinemasArray->getIdMovieTheater() == $idMovieTheater)
                        array_push($result, $cinemasArray);
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {

            return $result;
        }
    }

    public function getListIdCinema($idMovieTheater)
    {

        $result = array();
        try {
            foreach ($this->cinemaDAO->getAll() as $cinema) {
                if ($cinema->getIdMovieTheater() == $idMovieTheater)
                    array_push($result, $cinema->getId());
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {

            return $result;
        }
    }


    public function createCinema($name, $seatsNumber, $price, $idMovieTheater)
    {
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->createSeats($seatsNumber);
        $cinema->setTicketPrice($price);
        $cinema->setIdMovieTheater($idMovieTheater);
        $cinema->setStatus(true);
        try {
            $this->cinemaDAO->Add($cinema);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function modifyCinema($id, $status, $name, $seatsNumber, $ticketPrice, $idMovieTheater)
    {
        $movieTheaterController = new MovieTheaterController();
        try {
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
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function viewModifyCinema($idCinema)
    {
        try {
            $cinema = $this->getCinemaById($idCinema);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {

            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "navAdmin.php");
            require_once(VIEWS_PATH . "modifycinema.php");
        }
    }


    public function deleteAllCinemaById($idCinemaList = array())
    {
        try {
            foreach ($idCinemaList as $idCinema) {
                $this->deleteCinemaById($idCinema);
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function deleteCinemaById($id)
    {
        try {
            $this->showController->deleteAllShowsById($id);
            $this->cinemaDAO->deleteFisico($id);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function deleteCinemaByMovieTheaterId($movieTheaterId)
    {
        try {
            $cinemaList = $this->cinemaDAO->getAll();
            foreach ($cinemaList as $cinema) {
                if ($cinema->getIdMovieTheater() == $movieTheaterId) {
                    $this->deleteCinemaById($cinema->getId());
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }
    public function deleteCinemaViewThree($id, $movieTheaterName)
    {
        $movieTheaterController = new MovieTheaterController();
        try {
            $this->deleteCinemaById($id);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            $movieTheaterController->viewCreateMovieTheaterThree($movieTheaterName);
        }
    }

    public function getSeats($idCinemaName)
    {
        try {
            $cinemaList = $this->cinemaDAO->getAll();

            $result = null;

            foreach ($cinemaList as $cinema) {
                if ($cinema->getId() == $idCinemaName) {
                    $result = $cinema->countSeats();
                    break;
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            return $result;
        }
    }

    public function getCinemaById($id)
    {
        try {
            $cinemaList = $this->cinemaDAO->getAll();
            $result = null;
            foreach ($cinemaList as $cinema) {
                if ($cinema->getId() == $id) {
                    $result = $cinema;
                    break;
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            return $result;
        }
    }


    public function showPrices()
    {
        try {
            $cinemasRepo = new CinemaDAO();
            $listadoC = $cinemasRepo->getAll();
            $movieTheatersRepo = new MovieTheaterRepository();
            $listadoMT = $movieTheatersRepo->getAll();
            $userControl = new UserController();

            if (!is_array($listadoC)) {
                $aux = $listadoC;
                $listadoC = array();
                array_push($listadoC, $aux);
            }
            if (!is_array($listadoMT)) {
                $aux = $listadoMT;
                $listadoMT = array();
                array_push($listadoMT, $aux);
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            if ($userControl->checkSession() != false) {
                if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navAdmin.php");
                    include_once(VIEWS_PATH . "prices.php");
                } else {
                    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navClient.php");
                        include_once(VIEWS_PATH . "prices.php");
                    }
                }
            } else {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "nav.php");
                include_once(VIEWS_PATH . "prices.php");
            }
        }
    }
}
