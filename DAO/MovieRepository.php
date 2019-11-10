<?php namespace DAO; 

use Models\Movie as Movie;
use Models\Genre as Genre;

class movieRepository{

    // private $idMovie;
	// private $title;
	// private $originalTitle;
	// private $adult;
	// private $overview;
	// private $releaseDate;
	// private $posterPath;
	// private $backdropPath;

    private $connection;

          function __construct() {

          }

          public function Add($movie) {

			$sql = "INSERT INTO Movies (title, originalTitle, adult, overview, releaseDate, posterPath, backdropPath) VALUES (:title, :originalTitle, :adult, :overview, :releaseDate, :posterPath, :backdropPath)";

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
               /*$sql = "DELETE FROM Movies WHERE id_movie = :id_movie";

               $obj_pdo = new Conexion();

               try {
                    $conexion = $obj_pdo->conectar();

				$sentencia = $conexion->prepare($sql);

                    $sentencia->bindParam(":id_movie", $id_movie);

                    $sentencia->execute();


               } catch(PDOException $Exception) {

				throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );

			}*/
          }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){
				return new M_Usuario($p['id_movie'], $p['title'], $p['originalTitle'], $p['adult'], $p['overview'], $p['releaseDate'], $p['posterPath'], $p['backdropPath']);
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

}