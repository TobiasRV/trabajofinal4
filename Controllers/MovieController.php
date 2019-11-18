<?php

namespace Controllers;

use DAOJson\movieDAO as MovieDAO;  
use DAOJson\CinemaDAO as CinemaDAO;

//use DAO\movieRepository as MovieDAO;
//use DAO\CinemaRepository as CinemaDAO;

use Controllers\MovieTheaterController as MovieTheaterController;
use Models\Movie as Movie;

class MovieController
{
    private $movieDAO;
    private $nowPlayingMovies;
    private $upcomingMovies;
    private $genres;
    public function __construct()
    {
        $this->movieDAO = new MovieDAO();
        $this->nowPlayingMovies = $this->movieDAO->getNowPlayingMovies();
        $this->upcomingMovies = $this->movieDAO->getUpcomingMovies();
        $this->genres = $this->movieDAO->getGenres();
    }

    public function getNowPlaying()
    {
        return $this->nowPlayingMovies;
    }


    public function getUpcoming()
    {
        return $this->upcomingMovies;
    }


    public function get3Upcoming()
    {
        $result = array();
        $result = array_slice($this->upcomingMovies, 0, 3);
        return $result;
    }


    public function searchMovieByTitle($title)
    {
        foreach ($this->nowPlayingMovies as $movie) {
            if ($movie->getTitle() == $title) {
                $resultado = $movie;
                break;
            }
        }
        return $resultado;
    }

    public function getMovieListByIdList($idArray = array())
    {
        $result = array();
        foreach ($idArray as $id) {
            array_push($result, $this->searchMovieById($id));
        }
        return $result;
    }

    public function searchMovieById($id)
    {
        $result = null;

        foreach ($this->nowPlayingMovies as $movie) {
            if ($movie->getIdMovie() == $id) {
                $result = $movie;
                break;
            }
        }

        if ($result == null) {
            $result = $this->movieDAO->getMovieDetails($id);
        }

        return $result;
    }


    public function getGenres()
    {
        return $this->genres;
    }
    public function getGenreListNameById($idList)
    {
        $genreNames = array();
        foreach ($idList as $id) {
            array_push($genreNames, $this->getGenreNameById($id));
        }
        return $genreNames;
    }
    public function getGenreNameById($id)
    {
        foreach ($this->genres as $g) {
            if ($g->getId() == $id) {
                $resultado = $g->getName();
                break;
            }
        }
        return $resultado;
    }
    public function getGenreIdByName($name)
    {
        foreach ($this->genres as $genre) {
            if ($name === $genre->getName()) {
                $genreId = $genre->getId();
            }
        }
        return $genreId;
    }
    public function getNowPlayingMovieByGenre($genre)
    {
        $result = array();

        foreach ($this->nowPlayingMovies as $movie) {
            $movieGenre = $movie->getIdGenre();
            if (in_array($genre, $movieGenre)) {
                array_push($result, $movie);
            }
        }
        return $result;
    }
    public function getUpcomingMovieByGenre($genre)
    {
        $result = array();

        foreach ($this->upcomingMovies as $movie) {
            $movieGenre = $movie->getIdGenre();
            if (in_array($genre, $movieGenre)) {
                array_push($result, $movie);
            }
        }
        return $result;
    }


    // public function searchMovie($selectTime = "null", $selectGenre = "null")
    // {
    //     $result = array();
    //     if ($selectTime != "null") {
    //         if ($selectTime === "nowPlaying") {
    //             if ($selectGenre != "null") {

    //                 $result = $this->getNowPlayingMovieByGenre($selectGenre);
    //             } else {
    //                 $result = $this->getNowPlaying();
    //             }
    //         }
    //         if ($selectTime === "upcoming") {
    //             if ($selectGenre != "null") {
    //                 $result = $this->getUpcomingMovieByGenre($selectGenre);
    //             } else {
    //                 $result = $this->getUpcoming();
    //             }
    //         }
    //     } else {
    //         $result = $this->getNowPlaying();
    //     }
    //     return $result;
    // }


    // public function showMovies($selectTime = "null", $selectGenre = "null")
    // {
    //     $movies = array();
    //     $movies = $this->searchMovie($selectTime, $selectGenre);
    //     $genres = array();
    //     $genres = $this->getGenres();
    //     // $cinemaRepository = new CinemaRepository();
    //     // $cinemaList = $cinemaRepository->getAll();
    //     require_once(VIEWS_PATH . "billboard.php");
    // }

    public function filterMoviesByGenre($movieList, $genre)
    {
        $result = array();

        foreach ($movieList as $movie) {
            foreach ($movie->getIdGenre() as $genreMovie) {
                if ($genreMovie == $genre) {
                    array_push($result, $movie);
                }
            }
        }
        return $result;
    }


    public function searchMovie($selectMovieTheather = null, $selectDate = null, $selectGenre = null)
    {
        $showController = new ShowController();

        $result = array();
        $movieList = array();

        $movieList = $showController->getMoviesForMovieTheaterByDate($selectMovieTheather, $selectDate);
        if ($selectGenre != null) {
            $result = $this->filterMoviesByGenre($movieList, $selectGenre);
        } else {
            $result = $movieList;
        }

        return $result;
    }

    public function showMovies($selectMovieTheather = null, $selectDate = null, $selectGenre = null)
    {
        $movieTheaterController = new MovieTheaterController();
        $movies = array();
        $movies = $this->searchMovie($selectMovieTheather, $selectDate, $selectGenre);
        $genres = array();
        $genres = $this->getGenres();
        $movieTheatherList = $movieTheaterController->getMovieTheaterList();
        require_once(VIEWS_PATH . "billboard.php");
    }
}
