<?php

namespace Controllers;

use DAO\movieDAO as MovieDAO;

class MovieController
{

    private $movieDAO;

    public function __construct()
    {
        $this->movieDAO = new MovieDAO();
    }

    public function getNowPlaying()
    {
        return $this->movieDAO->getNowPlayingMovies();
    }

    public function getUpcoming()
    {
        return $this->movieDAO->getUpcomingMovies();
    }

    public function get3Upcoming(){
        $result = array();

        $result = array_slice($this->getUpcoming(),0,3);

        return $result;
    }

    public function searchMovieByTitle($title)
    {
        $moviesArray = $this->getNowPlaying();

        foreach($moviesArray as $movie){
            if($movie->getTitle() == $title){
                $resultado = $movie;
                break;
            }
        }
        return $resultado;
    }

    public function getGenres()
    {
        return $this->movieDAO->getGenres();
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
        $genres = $this->movieDAO->getGenres();
        foreach ($genres as $g) {
            if ($g->getId() == $id){
                $resultado = $g->getName();
                break;
            }
        }
        return $resultado;
    }

    public function getGenreIdByName($name)
    {
        $genreList = $this->movieDAO->getGenres();
        foreach ($genreList as $genre) {
            if ($name === $genre->getName()) {
                $genreId = $genre->getId();
            }
        }
        return $genreId;
    }

    public function getNowPlayingMovieByGenre($genre){
        $movieList = $this->movieDAO->getNowPlayingMovies();
        $result = array();
        
        foreach($movieList as $movie){
            $movieGenre = $movie->getIdGenre();
            if(in_array($genre,$movieGenre)){
                array_push($result,$movie);
            }
        }

        return $result;

    }

    public function getUpcomingMovieByGenre($genre){
        $movieList = $this->movieDAO->getUpcomingMovies();
        $result = array();
        
        foreach($movieList as $movie){
            $movieGenre = $movie->getIdGenre();
            if(in_array($genre,$movieGenre)){
                array_push($result,$movie);
            }
        }
        return $result;
    }

    public function searchMovie(){
        $result= array();
        if(isset($_POST["selectTime"])){
            if($_POST["selectTime"] === "nowPlaying"){
                if($_POST["genre"]!= "null"){
                  
                    $result = $this->getNowPlayingMovieByGenre($_POST["genre"]);
                }
                else{
                    $result = $this->getNowPlaying();
                }
                
            }
            if($_POST["selectTime"] === "upcoming"){
                if($_POST["genre"]!= "null"){
                    $result = $this->getUpcomingMovieByGenre($_POST["genre"]);
                }
                else{
                    $result = $this->getUpcoming();
                }
            }
            
        }   
        else{
            $result = $this->getNowPlaying();
        }
        $this->showMovies($result);
    }

    public function showMovies($movies = array()){
        $_POST['movies'] = $movies;
        require_once(VIEWS_PATH."billboard.php");
    }
}
