<?php

namespace Controllers;

use Controllers\CinemaController as CinemaController;
use Controllers\ShowController as ShowController;
use Controllers\MovieController as MovieController;
use Models\MovieTheater as MovieTheater;

use DAOJson\MovieTheaterDAO as MovieTheaterDAO;
//use DAO\MovieTheaterRepository as MovieTheaterDAO;

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
        return $this->movieTheaterDAO->getAll();
    }



    //hacer
    public function createMovieTheater($name, $address, $cinemas = array(), $moviechecked = array())
    {
        $movieTheater = new MovieTheater();
        $movieTheater->setName($name);
        $movieTheater->setAddress($address);
        $movieTheater->setCinemas($cinemas);
        $movieTheater->setBillBoard($moviechecked);

        $this->movieTheaterDAO->Add($movieTheater);
    }

    //hacer
    public function modifyMovieTheater($id, $status = null, $name = null, $address = null, $ticketPrice = null, $cinemas = array(), $billBoard = array())
    {
    //Mande la logica de esta funcion al dao, en BD no puedo borrar todo y reemplazarlo por el tema de los ids
      $mt = new MovieTheater();
      $mt->setId($id);
      $mt->setStatus($status);
      $mt->setName($name);
      $mt->setAddress($address);
      $mt->setCinemas($cinemas);
      $mt->setBillboard($billBoard);
      $this->movieTheaterDAO->edit($mt);
    }

    //listo
    public function modifyBillBoard($id, $billBoard = array())
    {
        $this->movieTheaterDAO->editBillBoard($id,$billBoard);
    }


    public function getShowsOfAllMovieTheater()
    {
        $movieTheaterList = $this->getMovieTheaterList();
        $result = array();
        foreach ($movieTheaterList as $movieTheater) {
            $showsMovieTheater =  $this->getShowsByMovieTheater($movieTheater->getName());
            foreach($showsMovieTheater as $show){
                array_push($result, $show );
            }
        }

        return $result;
    }

    public function getShowsByMovieTheater($movieTheaterName)
    {
        $movieTheaterList = $this->movieTheaterDAO->getAll();

        $result = array();

        foreach ($movieTheaterList as $movieTheater) {
            if ($movieTheater->getName() == $movieTheaterName) {
                $result = $this->cinemaController->getShowsByCinemaList($movieTheater->getCinemas());
                break;
            }
        }

        return $result;
    }


    public function getMovieTheathersNameOfMovie($movieId){

        $showList = $this->getShowsOfAllMovieTheater();

        $movieTheaterNameList = array();

        foreach($showList as $show){
            if($movieId == $show->getIdMovie()){
                $cinema = $this->cinemaController->getCinemaById($show->getIdCinema());
                array_push($movieTheaterNameList, $this->getNameById($cinema->getIdMovieTheater()));
            }
        }

        return $movieTheaterNameList;
    }

    public function checkNameAvailablity($movieTheaterName)
    {
        $movieTheaterList = $this->movieTheaterDAO->getAll();
        $result = true;
        foreach ($movieTheaterList as $movieTheater) {
            if ($movieTheater->getName() == $movieTheaterName) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    public function getNameById($id){
        $movieTheaterList = $this->getMovieTheaterList();

        $result = null; 

        foreach($movieTheaterList as $movieTheater){
            if($movieTheater->getId() == $id){
                $result = $movieTheater->getName();
            break;
            }
        }
        return $result;
    }
    
    public function getIdByName($name)
    {
        $movieTheaterList = $this->movieTheaterDAO->getAll();
        $result = array();
        if(is_array($movieTheaterList)){  
            foreach ($movieTheaterList as $movieTheater) {
                if ($movieTheater->getName() == $name) {
                    $result = $movieTheater->getId();
                    break;
                }
            }
        }
        else{ 
            if ($movieTheaterList->getName() == $name) 
            $result = $movieTheaterList->getId();
         }
        return $result;
    }



    public function viewCreateMovieTheaterOne()
    {
        require_once(VIEWS_PATH . "addmovietheaterone.php");
    }



    public function viewAddBillBoard($movieTheaterName, $moviechecked = array())
    {

        $nowPlaying = $this->movieController->getNowPlaying();
        $arrayGeneros = $this->movieController->getGenres();

        $this->modifyMovieTheater($this->getIdByName($movieTheaterName), null, null, null, null, null, $moviechecked);

        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterName));
        $movieTheaterBillBoard = array();
        if(is_array($movieTheater->getBillBoard())){ 
        foreach ($movieTheater->getBillBoard() as $idMovie) {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
        }
    }
    else 
    {
        array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
    }
        require_once(VIEWS_PATH . "addmovietheatertwo.php");
    }



    public function viewCreateMovieTheaterTwo($name, $address, $arrayMovies = array(), $cinemas = array())
    {
        $this->createMovieTheater($name, $address);

        $nowPlaying = $this->movieController->getNowPlaying();
        $arrayGeneros = $this->movieController->getGenres();
        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($name));
        $movieTheaterBillBoard = array();
        if($movieTheater!= false){
        foreach ($movieTheater->getBillBoard() as $idMovie) {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
        }
    }

        require_once(VIEWS_PATH . "addmovietheatertwo.php");
    }




    public function deleteMovieTheaterById($id)
    {
        $this->cinemaController->deleteCinemaByMovieTheaterId($id);
        $this->movieTheaterDAO->deleteFisico($id);
    }

    public function backToViewOne($movieTheaterName)
    {
        $this->deleteMovieTheaterById($this->getIdByName($movieTheaterName));
        $this->viewCreateMovieTheaterOne();
    }

    public function getBillBoardByMovieTheaterName($movieTheaterName)
    {
        $movieTheater = $this->getMovieTheaterByName($movieTheaterName);
        return $movieTheater->getBillBoard();
    }

    public function getMovieTheaterByName($movieTheaterName)
    {
        $movieTheaterList = $this->getMovieTheaterList();

        $result = null;

        foreach ($movieTheaterList as $movieTheater) {
            if ($movieTheater->getName() == $movieTheaterName) {
                $result = $movieTheater;
                break;
            }
        }
        return $result;
    }

    public function viewCreateMovieTheaterThree($movieTheaterName)
    {
        $cinemaList = $this->cinemaController->getCinemaList($this->getIdByName($movieTheaterName));

        $arrayGeneros = $this->movieController->getGenres();
        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterName));
        $movieTheaterBillBoard = array();
        if(is_array($movieTheater->getBillBoard())){
        foreach ($movieTheater->getBillBoard() as $idMovie) {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
        }
    }
    else {
        array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
    }

        require_once(VIEWS_PATH . "addmovietheaterthree.php");
    }

    public function viewAddCinema($movieTheaterName, $cinemaName, $seats, $price)
    {

        $this->cinemaController->createCinema($cinemaName, $seats, $price, $this->getIdByName($movieTheaterName));
        $cinemaList = $this->cinemaController->getCinemaList($this->getIdByName($movieTheaterName));

        $arrayGeneros = $this->movieController->getGenres();
        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterName));
        $movieTheaterBillBoard = array();

        if(is_array($movieTheater->getBillBoard())){
            foreach ($movieTheater->getBillBoard() as $idMovie) {
                array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
            }
        }
        else {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
        }

        require_once(VIEWS_PATH . "addmovietheaterthree.php");
    }

    public function viewCreateMovieTheaterFour($movieTheaterName)
    {
        $cinemaList = $this->cinemaController->getCinemaList($this->getIdByName($movieTheaterName));

        $arrayGeneros = $this->movieController->getGenres();
        $movieTheater = $this->movieTheaterDAO->getById($this->getIdByName($movieTheaterName));
        $movieTheaterBillBoard = array();

        if(is_array($movieTheater->getBillBoard())){
            foreach ($movieTheater->getBillBoard() as $idMovie) {
                array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($idMovie));
            }
        }
        else {
            array_push($movieTheaterBillBoard, $this->movieController->searchMovieById($movieTheater->getBillBoard()));
        }

        $this->modifyMovieTheater($this->getIdByName($movieTheaterName), null, null, null, null, $this->cinemaController->getListIdCinema($this->getIdByName($movieTheaterName)), null);


        require_once(VIEWS_PATH . "addmovietheaterfour.php");
    }

    public function listCinemas()
    {
        $movieTheaterList = $this->getMovieTheaterList();
        $arrayGeneros = $this->movieController->getGenres();
        require_once(VIEWS_PATH . "listcinemas.php");
    }
}
