<?php namespace DAO; 

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\IRepository as IRepository;


class MovieRepository extends Singleton implements Irepository{

    private $connection;

          function __construct() {

          }

          public function Add($movie) {

			$sql = "INSERT INTO Movies (id_movie,title, originalTitle, adult, overview, releaseDate, posterPath, backdropPath) VALUES (:id_movie,:title, :originalTitle, :adult, :overview, :releaseDate, :posterPath, :backdropPath)";

               $parameters['id_movie'] = $movie->getIdMovie();
               $parameters['title'] = $movie->getTitle();
               $parameters['originalTitle'] = $movie->getOriginalTitle();
               $parameters['adult'] = $movie->getAdult();
               $parameters['overview'] = $movie->getOverview();
               $parameters['releaseDate'] = $movie->getReleaseDate();
               $parameters['posterPath'] = "https://image.tmdb.org/t/p/original" . $movie->getPosterPath();
               $parameters['backdropPath'] = "https://image.tmdb.org/t/p/original" . $movie->getBackdropPath();
               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          public function read($id_movie) {

               $sql = "SELECT * FROM Movies where id_movie = :id_movie";

               $parameters['id_movie'] = $id_movie;

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql, $parameters);
               } catch(Exception $ex) {
                   throw $ex;
               }


               if(!empty($resultSet))
                    return $this->mapear($resultSet);
               else
                    return false;
          }

          /*
          Funciones de Genre
          */

          public function AddGenre($genre) {

			$sql = "INSERT INTO Genres (id_genre , genre) VALUES (:id_genre,:genre)";

               $parameters['id_genre'] = $genre->getId();
               $parameters['genre'] = $genre->getName();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          public function readGenre($id_genre) {

               $sql = "SELECT * FROM Genres where id_genre = :id_genre";

               $parameters['id_genre'] = $id_genre;

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql, $parameters);
               } catch(Exception $ex) {
                   throw $ex;
               }


               if(!empty($resultSet))
                    return $this->mapearGenres($resultSet);
               else
                    return false;
          }

          public function addGenre_X_movie($id_genre,$id_movie){
               $sql = "INSERT INTO genre_x_movie (id_genre,id_movie) VALUES (:id_genre, :id_movie)";
           
                   $parameters['id_genre'] = $id_genre;
                   $parameters['id_movie'] = $id_movie;
                   try {
                    $this->connection = Connection::getInstance();
                    return $this->connection->ExecuteNonQuery($sql, $parameters);
               } catch(\PDOException $ex) {
                   throw $ex;
              }
               
           }

           

           protected function mapearGenres($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){
				return new Genre($p['id_genre'], $p['genre']);
			}, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

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
          /*
          Fin Funciones de genre
          */


          public function getAll() {
               $sql = "SELECT * FROM Movies";

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql);
               } catch(Exception $ex) {
                   throw $ex;
               }

               if(!empty($resultSet))
                    return $this->mapear($resultSet);
               else
                    return false;
          }


          public function edit($movie) {
               $sql = "UPDATE Movies SET title = :title, originalTitle = :originalTitle, adult = :adult, overview = :overview, releaseDate = :releaseDate, posterPath = :posterPath, backdropPath = :backdropPath WHERE id_movie = :id_movie";

               $parameters['title'] = $movie->getTitle();
               $parameters['originalTitle'] = $movie->getOriginalTitle();
               $parameters['adult'] = $movie->getAdult();
               $parameters['overview'] = $movie->getOverview();
               $parameters['releaseDate'] = $movie->getReleaseDate();
               $parameters['posterPath'] = "https://image.tmdb.org/t/p/original" . $movie->getPosterPath();
               $parameters['backdropPath'] = "https://image.tmdb.org/t/p/original" . $movie->getBackdropPath();


               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
          public function delete($id_movie) {
          }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){
                    $movie= new Movie();
                    $movie->setIdMovie($p['id_movie']);
                    $movie->setTitle($p['title']);
                    $movie->setOriginalTitle($p['originalTitle']);
                    $movie->setAdult($p['adult']);
                    $movie->setOverview($p['overview']);
                    $movie->setReleaseDate($p['releaseDate']);
                    $movie->setPosterPath($p['posterPath']);
                    $movie->setBackdropPath($p['backdropPath']); 
                    return $movie;
			}, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

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


 public function updateDataBase(){ // actualiza la base de datos
      $this->updateDataBaseGenres();
      $this->updateDataBaseMovies();
      $this->updateDataBaseUpcomingMovies();
 }

 public function updateDataBaseMovies(){ //esta funcion pasa la info de movies a la BD
     $cont = 0;
     $moviesJson = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1");
     $arrayJson = ($moviesJson) ? json_decode($moviesJson, true) : array();
     $array = $arrayJson['results'];
 

     foreach($array as $values){

          if(!$this->read($values['id']))
          {
               $newMovie = new Movie();
               $newMovie->setAdult($values['adult']);
               $newMovie->setIdGenre($values['genre_ids']);
               $newMovie->setIdMovie($values['id']);
               $newMovie->setTitle($values['title']);
               $newMovie->setOriginalTitle($values['original_title']);
               $newMovie->setOverview($values['overview']);
               $newMovie->setPosterPath("https://image.tmdb.org/t/p/original" . $values["poster_path"]);
               $newMovie->setReleaseDate($values['release_date']);
               $newMovie->setBackdropPath("https://image.tmdb.org/t/p/original" . $values["backdrop_path"]);
               $this->add($newMovie);
               foreach($newMovie->getIdGenre() as $values)
               {
                    $this->addGenre_X_movie($values,$newMovie->getIdMovie());

               }
          }
     }
 }

 public function updateDataBaseUpcomingMovies(){ //esta funcion pasa la info de movies a la BD
     $cont = 0;
     $moviesJson = file_get_contents("https://api.themoviedb.org/3/movie/upcoming?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX&page=1");
     $arrayJson = ($moviesJson) ? json_decode($moviesJson, true) : array();
     $array = $arrayJson['results'];
 

     foreach($array as $values){

          if(!$this->read($values['id']))
          {
               $newMovie = new Movie();
               $newMovie->setAdult($values['adult']);
               $newMovie->setIdGenre($values['genre_ids']);
               $newMovie->setIdMovie($values['id']);
               $newMovie->setTitle($values['title']);
               $newMovie->setOriginalTitle($values['original_title']);
               $newMovie->setOverview($values['overview']);
               $newMovie->setPosterPath("https://image.tmdb.org/t/p/original" . $values["poster_path"]);
               $newMovie->setReleaseDate($values['release_date']);
               $newMovie->setBackdropPath("https://image.tmdb.org/t/p/original" . $values["backdrop_path"]);
               $this->add($newMovie);
               foreach($newMovie->getIdGenre() as $values)
               {
                    $this->addGenre_X_movie($values,$newMovie->getIdMovie());

               }
          }
     }
 }

 public function updateDataBaseGenres(){ //esta funcion pasa la info de genres a la BD
     $cont = 0;
     $genresJson = file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=ead8068ec023b7d01ad25d135bf8f620&language=es-MX');
     $arrayJson = ($genresJson) ? json_decode($genresJson, true) : array();
     $array = $arrayJson['genres'];
     foreach($array as $values){
          if(!$this->readGenre($values['id']))
          {
               $newGenre = new Genre();
               $newGenre->setName($values['name']);
               $newGenre->setId($values['id']);
               $this->addGenre($newGenre);
          }
     }
     }

     public function getMovieTitle($id)
     {
          $movieRepo = new MovieRepository();
          $movieRepo = $this->getAll();
          $movieTitle="";
          foreach($movieRepo as $moviesR)
          {
               if($moviesR->getIdMovie() == $id)
               {
                    $movieTitle = $moviesR->getTitle();
               }
          }

          return $movieTitle;
     }

}