<?php

namespace Controllers;

use Controllers\CinemaController as CinemaController;
use Controllers\ShowController as ShowController;
use Controllers\MovieController as MovieController;
use Models\MovieTheater as MovieTheater;

//use DAOJson\MovieTheaterDAO as MovieTheaterDAO;
use DAO\MovieTheaterRepository as MovieTheaterDAO;

use Exception;
use PDOException;

class MovieTheaterController
{

    private $movieTheaterDAO;
    private $movieController;
    private $cinemaController;
    private $showController;

    public function __construct()
    {
        $this->showController = new ShowController();
        $this->movieTheaterDAO = new MovieTheaterDAO();
        $this->movieController = new MovieController();
        $this->cinemaController = new CinemaController();
    }

    public function getMovieTheaterList()
    {
        try {
            return $this->movieTheaterDAO->getAll();
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }


    public function createMovieTheater($name, $address, $cinemas = array(), $moviechecked = array())
    {
        $flag = $this->checkNameAvailablity($name);
        $msj = null;
        if ($flag == 1) {
            $movieTheater = new MovieTheater();
            $movieTheater->setName($name);
            $movieTheater->setAddress($address);
            $movieTheater->setCinemas($cinemas);
            $movieTheater->setBillBoard($moviechecked);


            $this->movieTheaterDAO->Add($movieTheater);
        } else {
            $msj = "Ya existe un cine con ese nombre";
        }
        return $msj;
    }

    public function modifyMovieTheater($id, $status = null, $name = null, $address = null, $cinemas = array(), $billBoard = array())
    {
        $mt = new MovieTheater();
        $mt->setId($id);
        $mt->setStatus($status);
        $mt->setName($name);
        $mt->setAddress($address);
        $mt->setCinemas($cinemas);
        $mt->setBillboard($billBoard);
        try {
            $this->movieTheaterDAO->edit($mt);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function modifyMovieTheaterFromList($id, $name = null, $address = null, $status = null, $billBoard = array())
    {
        $mt = new MovieTheater();
        $mt->setId($id);
        $mt->setStatus($status);
        $mt->setName($name);
        $mt->setAddress($address);
        $mt->setBillboard($billBoard);
        try {
            $this->movieTheaterDAO->edit($mt);
            $this->listCinemas();
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function modifyBillBoard($id, $billBoard = array())
    {
        $this->movieTheaterDAO->editBillBoard($id, $billBoard);
    }


    public function getShowsOfAllMovieTheater()
    {
        try {
            $movieTheaterList = $this->getAvailableMovieTheaterList();
            $result = array();
            foreach ($movieTheaterList as $movieTheater) {
                $showsMovieTheater =  $this->getShowsByMovieTheater($movieTheater->getName());
                foreach ($showsMovieTheater as $show) {
                    array_push($result, $show);
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

    public function getShowsByMovieTheater($movieTheaterId)
    {
        try {
            $movieTheaterList = $this->movieTheaterDAO->getAll();
            $result = array();
            foreach ($movieTheaterList as $movieTheater) {
                if ($movieTheater->getName() == $movieTheaterId) {
                    $result = $this->cinemaController->getShowsByCinemaList($movieTheater->getCinemas());
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


    

    public function checkNameAvailablity($movieTheaterId)
    {
        try {
            $movieTheaterList = $this->movieTheaterDAO->getAll();
            $result = 1;
            if ($movieTheaterList != null) {
                if (!is_array($movieTheaterList)) {
                    $aux = $movieTheaterList;
                    $movieTheaterList = array();
                    array_push($movieTheaterList, $aux);
                }
                foreach ($movieTheaterList as $movieTheater) {
                    if ($movieTheater->getName() == $movieTheaterId) {

                        $result = 0;
                        break;
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

    public function getNameById($id)
    {
        try {
            $movieTheaterList = $this->getMovieTheaterList();
            $result = null;
            foreach ($movieTheaterList as $movieTheater) {
                if ($movieTheater->getId() == $id) {
                    $result = $movieTheater->getName();
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

    public function getIdByName($name)
    {
        try {
            $movieTheaterList = $this->movieTheaterDAO->getAll();
            $result = array();
            if (is_array($movieTheaterList)) {
                foreach ($movieTheaterList as $movieTheater) {
                    if ($movieTheater->getName() == $name) {
                        $result = $movieTheater->getId();
                        break;
                    }
                }
            } else {
                if ($movieTheaterList->getName() == $name)
                    $result = $movieTheaterList->getId();
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



    public function viewCreateMovieTheaterOne($msj = null)
    {
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "navAdmin.php");
        require_once(VIEWS_PATH . "addmovietheaterone.php");
    }



    public function viewAddBillBoard($movieTheaterId, $moviechecked = array())
    {
        try {
            $nowPlaying = $this->movieController->getNowPlaying();
            $arrayGeneros = $this->movieController->getGenres();
            $this->modifyMovieTheater($this->getIdByName($movieTheaterId), null, null, null, null, $moviechecked);

            $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterId));
            $movieTheaterBillBoard = array();
            if (is_array($movieTheater->getBillBoard())) {
                foreach ($movieTheater->getBillBoard() as $idMovie) {
                    array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
                }
            } else {
                array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
            }
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
            require_once(VIEWS_PATH . "addmovietheatertwo.php");
        }
    }

    public function viewCreateMovieTheaterTwo($name, $address, $arrayMovies = array(), $cinemas = array())
    {
  
            $msj = $this->createMovieTheater($name, $address);
            if ($msj == null) {
                $nowPlaying = $this->movieController->getNowPlaying();
                $arrayGeneros = $this->movieController->getGenres();
                $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($name));
                $movieTheaterBillBoard = array();
                if ($movieTheater != false) {
                    foreach ($movieTheater->getBillBoard() as $idMovie) {
                        array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
                    }
                }
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "navAdmin.php");

                require_once(VIEWS_PATH . "addmovietheatertwo.php");
            } else {
                $this->viewCreateMovieTheaterOne($msj);
            }
        
    }

    public function deleteMovieTheaterById($id)
    {
        try {
            $this->cinemaController->deleteCinemaByMovieTheaterId($id);
            $this->movieTheaterDAO->deleteFisico($id);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function backToViewOne($movieTheaterId)
    {
        $this->deleteMovieTheaterById($this->getIdByName($movieTheaterId));
        $this->viewCreateMovieTheaterOne();
    }

    public function getBillBoardByMovieTheaterId($movieTheaterId)
    {
        $movieTheater = $this->getMovieTheaterByName($movieTheaterId);
        return $movieTheater->getBillBoard();
    }

    public function getBillBoardByMovieTheaterName($movieTheaterName)
    {
        $movieTheater = $this->getMovieTheaterByName($movieTheaterName);
        return $movieTheater->getBillBoard();
    }

    public function getMovieTheaterByName($movieTheaterId)
    {
        try {
            $movieTheaterList = $this->getMovieTheaterList();
            $result = null;
            if (is_array($movieTheaterList)) {
                foreach ($movieTheaterList as $movieTheater) {
                    if ($movieTheater->getName() == $movieTheaterId) {
                        $result = $movieTheater;
                        break;
                    }
                }
            } else {
                if ($movieTheater->getName() == $movieTheaterList) {
                    $result = $movieTheater;
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

    public function getMovieTheaterById($movieTheaterId)
    {
        try {
            $movieTheaterList = $this->getMovieTheaterList();
            $result = null;
            if (is_array($movieTheaterList)) {
                foreach ($movieTheaterList as $movieTheater) {
                    if ($movieTheater->getId() == $movieTheaterId) {
                        $result = $movieTheater;
                        break;
                    }
                }
            } else {
                if ($movieTheater->getName() == $movieTheaterList) {
                    $result = $movieTheater;
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
    public function viewCreateMovieTheaterThree($movieTheaterId)
    {
        try {
            $cinemaList = $this->cinemaController->getCinemaList($this->getIdByName($movieTheaterId));
            $arrayGeneros = $this->movieController->getGenres();
            $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterId));
            $movieTheaterBillBoard = array();
            if (is_array($movieTheater->getBillBoard())) {
                foreach ($movieTheater->getBillBoard() as $idMovie) {
                    array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
                }
            } else {
                array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
            }
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
            require_once(VIEWS_PATH . "addmovietheaterthree.php");
        }
    }
    public function viewAddCinema($movieTheaterId, $cinemaName, $seats, $price)
    {

        $this->cinemaController->createCinema($cinemaName, $seats, $price, $this->getIdByName($movieTheaterId));
        $cinemaList = $this->cinemaController->getCinemaList($this->getIdByName($movieTheaterId));

        $arrayGeneros = $this->movieController->getGenres();
        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterId));
        $movieTheaterBillBoard = array();

        if (is_array($movieTheater->getBillBoard())) {
            foreach ($movieTheater->getBillBoard() as $idMovie) {
                array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
            }
        } else {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
        }
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "navAdmin.php");

        require_once(VIEWS_PATH . "addmovietheaterthree.php");
    }

    public function viewCreateMovieTheaterFour($movieTheaterId)
    {

        $cinemaList = $this->cinemaController->getCinemaList($this->getIdByName($movieTheaterId));
        $arrayGeneros = $this->movieController->getGenres();
        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterId));
        $movieTheaterBillBoard = array();

        if (is_array($movieTheater->getBillBoard())) {
            foreach ($movieTheater->getBillBoard() as $idMovie) {
                array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
            }
        } else {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
        }

        $this->modifyMovieTheater($this->getIdByName($movieTheaterId), null, null, null, $this->cinemaController->getListIdCinema($this->getIdByName($movieTheaterId)), null);
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "navAdmin.php");

        require_once(VIEWS_PATH . "addmovietheaterfour.php");
    }



    public function listCinemas()
    {

        try {
            $nowPlaying = $this->movieController->getNowPlaying();
            $movieTheaterList = $this->getMovieTheaterList();
            $arrayGeneros = $this->movieController->getGenres();
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
            require_once(VIEWS_PATH . "listcinemas.php");
        }
    }

    public function getAvailableMovieTheaterList()
    {
        $result = array();
        try {
            $movieTheaterList = $this->movieTheaterDAO->getAll();
            foreach ($movieTheaterList as $movieTheater) {
                if ($movieTheater->getStatus() == 1) {
                    array_push($result, $movieTheater);
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
}
