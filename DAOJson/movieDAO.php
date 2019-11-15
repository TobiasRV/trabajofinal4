<?php namespace DAOJson; 

use Models\Movie as Movie;
use Models\Genre as Genre;

class movieDAO{

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
            $adult = $jsonData["adult"];
            $idGenre = array();
            $idGenre = $jsonData["genre_ids"];
            $idMovie = $jsonData["id"];
            $title = $jsonData["title"];
            $originalTitle = $jsonData["original_title"];
            $overview = $jsonData["overview"];
            $posterPath = "https://image.tmdb.org/t/p/original" . $jsonData["poster_path"];
            $releaseDate = $jsonData["release_date"];
            $backdropPath = "https://image.tmdb.org/t/p/original" . $jsonData["backdrop_path"];

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

    public function getUpcomingMovies(){

        $json = file_get_contents('https://api.themoviedb.org/3/movie/upcoming?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1');
        $jsonArray = json_decode($json, true);
        $arrayJsonData = $jsonArray["results"];
        $movies = array();



        for($i=0;$i<count($arrayJsonData); $i++){
            $jsonData = $arrayJsonData[$i];
            $adult = $jsonData["adult"];
            $idGenre = array();
            $idGenre = $jsonData["genre_ids"];
            $idMovie = $jsonData["id"];
            $title = $jsonData["title"];
            $originalTitle = $jsonData["original_title"];
            $overview = $jsonData["overview"];
            $posterPath = "https://image.tmdb.org/t/p/original" . $jsonData["poster_path"];
            $releaseDate = $jsonData["release_date"];
            $backdropPath = "https://image.tmdb.org/t/p/original" . $jsonData["backdrop_path"];

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

    public function getMovieDetails($idMovie){
        $json = file_get_contents('https://api.themoviedb.org/3/movie/%27.$idMovie.%27?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX%27');
        $jsonData = json_decode($json, true);
        $adult = $jsonData["adult"];
        $idGenre = array();
        $idGenre = $jsonData["genre_ids"];
        $idMovie = $jsonData["id"];
        $title = $jsonData["title"];
        $originalTitle = $jsonData["original_title"];
        $overview = $jsonData["overview"];
        $posterPath = "https://image.tmdb.org/t/p/original" . $jsonData["poster_path"];
        $releaseDate = $jsonData["release_date"];
        $backdropPath = "https://image.tmdb.org/t/p/original" . $jsonData["backdrop_path"];
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

        return $movie;
    }

    public function updateDataBase()
    {
    }


}
