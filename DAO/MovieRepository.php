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
}