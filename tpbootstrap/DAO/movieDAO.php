<?php namespace DAO; 

use Models\Movie as Movie;
use Models\Genre as Genre;

class movieDAO{

    public function __construct()
    {
        
    }
    
    

    public function getNowPlayingMovies(){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/now_playing?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $jsonArray = json_decode($json, true);
        $arrayJsonData = $jsonArray["results"];
        $movies = array();

        for($i=0;$i<count($arrayJsonData); $i++){
            $jsonData = $arrayJsonData[$i];
            $adult = $jsonData["adult"];
            $idGenre = array();
            $idGenre = $this->getMovie$jsonData["genre_ids"];
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
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/upcoming?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
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
        read_exif_data $movies;    
    }

    public function getGenres(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/genre/movie/list?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
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

    public function getGenreNameById($id){
        $genres = $this->getGenres();
        $i = array_search($id,$genres,TRUE);

        return $genres[$i]->getName();
    }
    public function getMovieGenreName($id = array()){
        $movieGenres = array();
        for($i=0;$i<count($id);$i++){
            $name = $this->getGenreNameById($id[$i]);
            array_push($movieGenres,$name);
        }
        return $movieGenres;
    }
}

?>