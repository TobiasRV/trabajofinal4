<?php namespace DAO; 

use Models\Movie as Movie;
use Models\Genre as Genre;

class movieRepository{

    public function __construct()
    {
        
    }
    
    

    public function getNowPlayingMovies(){

     $json = file_get_contents('https://api.themoviedb.org/3/movie/now_playing?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1');
        $jsonArray = json_decode($json, true);
        $arrayJsonData = $jsonArray["results"];
        $movies = array();


        for($i=0;$i<count($arrayJsonData); $i++){
            $jsonData = $arrayJsonData[$i];
            $idMovie = $jsonData["id"];
            $title = $jsonData["title"];
            $originalTitle = $jsonData["original_title"];
            $adult = $jsonData["adult"];
            $overview = $jsonData["overview"];
            $releaseDate = $jsonData["release_date"];
            $posterPath = "https://image.tmdb.org/t/p/original" . $jsonData["poster_path"];
            $backdropPath = "https://image.tmdb.org/t/p/original" . $jsonData["backdrop_path"];
            $idGenre = array();
            $idGenre = $jsonData["genre_ids"];

            $movie = new Movie();
            $movie->setIdMovie($idMovie);
            $movie->setTitle($title);
            $movie->setOriginalTitle($originalTitle);
            $movie->setAdult($adult);
            $movie->setOverview($overview);
            $movie->setReleaseDate($releaseDate);
            $movie->setPosterPath($posterPath);
            $movie->setBackdropPath($backdropPath);
            $movie->setIdGenre($idGenre);

            array_push($movies,$movie);
        }        
        return $movies;
    }

    public function getUpcomingMovies(){

        $json = file_get_contents('https://api.themoviedb.org/3/movie/upcoming?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1');
        $jsonArray = json_decode($json, true);
        $arrayJsonData = $jsonArray["results"];
        $movies = array();



        for($i=0;$i<count($arrayJsonData); $i++){
            $jsonData = $arrayJsonData[$i];
            $idMovie = $jsonData["id"];
            $title = $jsonData["title"];
            $originalTitle = $jsonData["original_title"];
            $adult = $jsonData["adult"];
            $overview = $jsonData["overview"];
            $releaseDate = $jsonData["release_date"];
            $posterPath = "https://image.tmdb.org/t/p/original" . $jsonData["poster_path"];
            $backdropPath = "https://image.tmdb.org/t/p/original" . $jsonData["backdrop_path"];
            $idGenre = array();
            $idGenre = $jsonData["genre_ids"];

            $movie = new Movie();
            $movie->setAdult($adult);
            $movie->setIdGenre($idGenre);
            $movie->setIdMovie($idMovie);
            $movie->setTitle($title);
            $movie->setOriginalTitle($originalTitle);
            $movie->setOverview($overview);
            $movie->setPosterPath($posterPath);
            $movie->setReleaseDate($releaseDate);
            $movie->setBackdropPath($backdropPath);

            array_push($movies,$movie);
        }    
        return $movies;    
    }

    public function getGenres(){
        
        $json = file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX');
        $jsonArray = json_decode($json, true);
        $arrayJsonData = $jsonArray["genres"];
        $genres = array();

        for($i=0;$i<count($arrayJsonData); $i++){
            $jsonData = $arrayJsonData[$i];
            $id = $jsonData["id"];
            $name = $jsonData["name"];

            $genre = new Genre();
            $genre->setId($id);
            $genre->setName($name);

            array_push($genres,$genre);
        }        
        return $genres;
    }

}

?>