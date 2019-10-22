<?php namespace Controllers;

use DAO\movieDAO as MovieDAO;

class movieController{

    private $movieDAO;

    public function __construct()
    {
        $this->movieDAO = new MovieDAO();
    }

    public function getNowPlaying(){
        return $this->movieDAO->getNowPlayingMovies();
    }

    public function getNewest3(){
        return $movies = array_slice($this->getNowPlaying(),0,3);
    }

    public function searchMovie($title){
        $moviesArray = $this->getNowPlaying();
        $i = array_search($title,$moviesArray,true);

        $movie = $moviesArray[$i];

        return $movie;
    }
}

?>