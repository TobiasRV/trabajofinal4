<?php namespace DAO; 

class api{

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

        $movies = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
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

        $movies = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $movies;
    }
}

?>