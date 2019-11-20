<?php

namespace Controllers;

use Models\Show as Show;
use Controllers\MovieTheaterController as MovieTheaterController;
use Controllers\CinemaController as CinemaController;
use Controllers\MovieController as MovieController;

use DAOJson\ShowDAO as ShowDAO;
//use DAO\ShowRepository as ShowDAO;


class ShowController
{
    private $showDAO;

    public function __construct()
    {
        $this->showDAO = new ShowDAO();
    }

    public function getShowListByCinema($idCinema)
    {
        $showList = $this->showDAO->getAll();
        $result = array();
        if($showList != false){
            if(is_array($showList))
            {
                foreach ($showList as $show) 
                {
                    if ($show->getIdCinema() == $idCinema) 
                    {
                        array_push($result, $show);
                    }
                }
            }
            else
            {
                array_push($result, $showList);  
            }
        }
        return $result;
    }

    public function createShow($idCinema, $date, $time, $idMovie,$seats)
    {
        $movieTheaterController = new MovieTheaterController();
        $show = new Show();
        $show->setIdCinema($idCinema);
        $show->setDate($date);
        $show->setTime($time);
        $show->setIdMovie($idMovie);
        $show->setSeats($seats);

        $this->showDAO->Add($show);
        
        $movieTheaterController->listCinemas();
        
    }


    public function modifyShow($id, $date, $time, $idCinema, $idMovie, $status)
    {
        $showList = $this->showDAO->getAll();
        $showAux = new Show();
        foreach ($showList as $show) {
            if ($show->getId() == $id) {
                $showAux->setDate($date);
                $showAux->setTime($time);
                $showAux->setIdCinema($idCinema);
                $showAux->setIdMovie($idMovie);
                $showAux->setStatus($status);
                break;
            }
        }
        $this->showDAO->edit($showAux);
    }




    public function deleteAllShowsById($idCinema)
    {
        $showList = $this->showDAO->getAll();

        if($showList != false){
            if(is_array($showList)){
            foreach ($showList as $show) {
                if ($show->getIdCinema() == $idCinema) {
                    $this->deleteShowById($show->getId());
                }
            }
        }
            else {
                if ($showList->getIdCinema() == $idCinema) {
                $this->deleteShowById($showList->getId());
                }
            }
        }
    }

    public function deleteShowById($id)
    {

        $showList = $this->showDAO->deleteFisico($id);
    }





    public function addShowOne($movieTheaterName = null, $cinemaName = null)
    {
        require_once(VIEWS_PATH . "addshowone.php");
    }

    public function addShowTwo($movieTheaterName, $cinemaName, $date)
    {
        $cinemaController = new CinemaController();
        $timeList = $this->generatePossibleTimes($cinemaController->getCinemaIdByName($cinemaName), $date);
        require_once(VIEWS_PATH . "addshowtwo.php");
    }

    public function addShowThree($movieTheaterName, $cinemaName, $date, $time)
    {
        $movieTheaterController = new MovieTheaterController();
        $movieController = new MovieController();
        $cinemaController = new CinemaController();
        $idCinema = $cinemaController->getCinemaIdByName($cinemaName);
        $seats = $cinemaController->getSeats($idCinema);
        $takenIds = $this->getTakenIds($movieTheaterName, $date);

        $billBoard = $movieTheaterController->getBillBoardByMovieTheaterName($movieTheaterName);

        $freeIds = array();

        if(is_array($billBoard)){
            foreach ($billBoard as $movieId) {
                if (!in_array($movieId, $takenIds)) {
                    array_push($freeIds, $movieId);
                }
            }
        } 
        else{
            if (!in_array($billBoard, $takenIds)) {
                array_push($freeIds, $billBoard);
            }
        }  

        $movieTheater = $movieTheaterController->getMovieTheaterByName($movieTheaterName);

        $freeMovies = array();
        if(is_array($movieTheater->getBillBoard())){
            foreach ($movieTheater->getBillBoard() as $idMovie) {
                if (in_array($idMovie, $freeIds)) {
                    array_push($freeMovies, $movieController->searchMovieById($idMovie));
                }
            }
        }
        else{
            if (in_array($movieTheater->getBillBoard(), $freeIds)) {
                array_push($freeMovies, $movieController->searchMovieById($movieTheater->getBillBoard()));
            }
        }

        $arrayGeneros = $movieController->getGenres();

        require_once(VIEWS_PATH . "addshowthree.php");
    }


    //FUNCION QUE DEVUELVE LOS IDS DE LAS PELICULAS QUE NO SE PUEDEN UTILIZAR EN UN DIA EN PARTICULAR
    public function getTakenIds($movieTheaterName, $date)
    {
        $movieTheaterController = new MovieTheaterController();

        $result = array();
        $showList = array();

        $showList = $movieTheaterController->getShowsOfAllMovieTheater();

        foreach ($showList as $show) {
            if ($show->getDate() == $date) {
                array_push($result, $show->getIdMovie());
            }
        }

        return $result;
    }


    //FUNCION QUE DEVUELVE LAS PELICULAS (OBJETOS MOVIE) QUE ESTAN OCUPADOS EN UN CINE EN UN DIA EN PARTICULAR
    public function getMoviesForMovieTheaterByDate($movieTheater = null, $date = null)
    {

        $movieTheaterController = new MovieTheaterController();
        $movieController = new MovieController();

        $result = array();
        $showList = array();
        
        if($movieTheater == null){
            $showList = $movieController->getNowPlaying();
        }
        elseif ($movieTheater == "allMovieTheaters") {
            $showList = $movieTheaterController->getShowsOfAllMovieTheater();
        } else {
            $showList = $movieTheaterController->getShowsByMovieTheater($movieTheaterController->getNameById($movieTheater));
        }

        if ($date != null) {
            foreach ($showList as $show) {
                if ($show->getDate() == $date) {
                    $movie = $movieController->searchMovieById($show->getIdMovie());
                    if(!in_array($movie, $result)){
                    array_push($result, $movie);
                    }
                }
            }
        } else {
            foreach ($showList as $show) {
                $movie = $movieController->searchMovieById($show->getIdMovie());
                if(!in_array($movie, $result)){
                array_push($result, $movie);
                }
            }
        }

        return $result;
    }


    public function generatePossibleTimes($idCinema, $date)
    {

        $showList = $this->getShowListByCinema($idCinema);
        $finalShowList = array();
        $unavailableTimes = array();
        $result = array();


        //COMPARO LA FECHA, SI ES IGUAL A LA FECHA Q RECIBO CARGO ESOS SHOWS
        foreach ($showList as $show) {
            if ($show->getDate() == $date) {
                array_push($finalShowList, $show);
            }
        }

        if (empty($finalShowList)) { //SI ESTA VACIO SIGNIFICA QUE PUEDO USAR CUALQUIER HORARIO
            array_push($result, "00:00");
            array_push($result, "10:00");
            array_push($result, "13:30");
            array_push($result, "17:00");
            array_push($result, "20:30");
        } else { // SINO, CARGO LOS HORARIOS Q NO ESTEN OCUPADOS
            //SELECCIONO LOS HORARIOS QUE NO ESTAN DISPONIBLES
            foreach ($finalShowList as $show) {
                array_push($unavailableTimes, $show->getTime());
            }

            if (!in_array("00:00", $unavailableTimes)) {
                array_push($result, "00:00");
            }
            if (!in_array("10:00", $unavailableTimes)) {
                array_push($result, "10:00");
            }
            if (!in_array("13:30", $unavailableTimes)) {
                array_push($result, "13:30");
            }
            if (!in_array("17:00", $unavailableTimes)) {
                array_push($result, "17:00");
            }
            if (!in_array("20:30", $unavailableTimes)) {
                array_push($result, "20:30");
            }
        }

        return $result;
    }


    // DE ACA PARA ABAJO NO SIRVE

    public function getShowsOfAllMovieTheaterByDate($date)
    {
        $movieTheaterController = new MovieTheaterController();
        $movieTheaterList = $movieTheaterController->getMovieTheaterList();
        $result = array();

        foreach ($movieTheaterList as $movieTheater) {
            array_push($result, $this->getShowsOfMovieTheaterByDate($movieTheater->getName(), $date));
        }

        return $result;
    }

    public function getShowsOfMovieTheaterByDate($movieTheaterName, $date)
    {
        $movieTheaterController = new MovieTheaterController();
        $cinemaController = new CinemaController();
        $movieTheater = $movieTheaterController->getMovieTheaterByName($movieTheaterName);
        $showList = $cinemaController->getShowsByCinemaList($movieTheater->getCinemas());

        $showListDate = array();
        foreach ($showListDate as $show) {
            if ($show->getDate() == $date) {
                array_push($showListDate, $show);
            }
        }

        return $showListDate;
    }
}
