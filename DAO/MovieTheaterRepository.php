<?php

namespace DAO;

use Models\MovieTheater as MovieTheater;
use Models\Movie as Movie;
use Models\Seat as Seat;
use DAO\IRepository as IRepository;


class MovieTheaterRepository extends Singleton implements Irepository
{

    private $connection;

          function __construct() {

          }

          //funciones add
          public function Add($movieTheater) {

               $this->AddMT($movieTheater);
               $lastId = $this->getLastInsertId();
               if($movieTheater->getBillboard()!=null){ 
               foreach($movieTheater->getBillboard() as $idMovie){
               $this->addMovietheater_x_movie($lastId,$idmovie);
               }               
          }
          }
          public function AddMT($movieTheater) {

			$sql = "INSERT INTO MovieTheaters (status, name, address) VALUES (:status, :name, :address)";

               $parameters['status'] = $movieTheater->getStatus();
               $parameters['name'] = $movieTheater->getName();
               $parameters['address'] = $movieTheater->getAddress();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }


          public function addMovietheater_x_movie($id_movietheater,$id_movie){
               $sql = "INSERT INTO movietheater_x_movie (id_movietheater,id_movie) VALUES (:id_movietheater, :id_movie)";
           
                   $parameters['id_movietheater'] = $id_movietheater;
                   $parameters['id_movie'] = $id_movie;
                   try {
                    $this->connection = Connection::getInstance();
                    return $this->connection->ExecuteNonQuery($sql, $parameters);
               } catch(\PDOException $ex) {
                   throw $ex;
              }
               
           }

          //Devuelve el ultimo id insertado en MovieTheaters
          public function getLastInsertId()
          {
               $sql = "SELECT mt.id_movietheater 
               FROM movietheaters mt 
               ORDER BY mt.id_movietheater DESC
               LIMIT 1";

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql);
               } catch(Exception $ex) {
                   throw $ex;
               }


               if(!empty($resultSet))
                    return $resultSet;
               else
                    return false;
          }

          //Fin funciones add


          public function read($name) {

               $sql = "SELECT * FROM MovieTheaters where name = :name";

               $parameters['name'] = $name;

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


          //funciones para el getall
          //tuve que dividir el get all en partes para podes ir recibiendo los arreglos que componen
          //a un cine por separado para que el objeto que devuelva sea un MT con su arreglo de ids de peliculas 
          //y de ids de salas
          public function getAll() {
              $MTlist = $this->getMTs();
              if( $MTlist != false)
              {
                    if(is_array($MTlist))
                    {
                         foreach($MTlist as $mt)
                         {
                              $mt->setBillBoard($this->getBillBoards($mt->getId()));
                              $mt->setCinemas($this->getCinemas($mt->getId()));
                         }
                    }
                    else 
                    {
                         $MTlist->setBillBoard($this->getBillBoards($MTlist->getId()));
                         $MTlist->setCinemas($this->getCinemas($MTlist->getId()));
                         $mt = $MTlist;
                         $MTlist = array();
                         array_push($MTlist,$mt);
                    }
               }
               return $MTlist;
          }


          public function getMTs() {
               $sql = "SELECT * FROM MovieTheaters";

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


          public function getBillBoards($id_movietheater) {
               $sql = "SELECT y.id_movie
               FROM movietheater_x_movie y
               JOIN movietheaters mt
               ON y.id_movietheater = mt.id_movietheater
               WHERE y.id_movietheater = :id_movietheater";

               $parameters['id_movietheater'] = $id_movietheater;

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql,$parameters);
               } catch(Exception $ex) {
                   throw $ex;
               }

               if(!empty($resultSet))
                    return $this->mapearIdBillBoard($resultSet);
               else
                    return false;
          }


          protected function mapearIdBillBoard($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
 
                    $billBoard= $p['id_movie'];
                    return $billBoard;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }





          public function getCinemas($id_movietheater) {
               $sql = "SELECT c.id_cinema
               FROM cinemas c
               JOIN movietheaters mt
               ON c.id_movietheater = mt.id_movietheater
               WHERE c.id_movietheater = :id_movietheater";

               $parameters['id_movietheater'] = $id_movietheater;

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql,$parameters);
               } catch(Exception $ex) {
                   throw $ex;
               }

               if(!empty($resultSet))
                  return $this->mapearIdCinema($resultSet);
               else
                    return false;
          }


          protected function mapearIdcinema($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
 
                    $cinema= $p['id_cinema'];
                    return $cinema;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }

          
     public function deleteFisicoBillBoard($id)
     {
          $sql = "DELETE FROM movietheater_x_movie WHERE id_movietheater=:id_movietheater";
          $parameters['id_movietheater'] = $id;
          try {
               $this->connection = Connection::getInstance();
               return $this->connection->ExecuteNonQuery($sql, $parameters);
          }catch(\PDOException $ex) {
          throw $ex;
          }
     }
   

          //fin funciones para get all

     public function edit($movieTheater) {

               if($movieTheater->getBillBoard()!=null){
                    $this->deleteFisicoBillBoard($movieTheater->getId());
                    foreach($movieTheater->getBillboard() as $idMovie){
                         $this->addMovietheater_x_movie($movieTheater->getId(),$idMovie);
                    }   
               }
            
          $sql = 
          "UPDATE movietheaters  SET 
          name = IFNULL(:name, name),
          address = IFNULL(:address, address),
          status = IFNULL(:status, status)
          WHERE 
          id_movietheater = :id_movietheater";
          $parameters['status'] = $movieTheater->getStatus();
          $parameters['name'] = $movieTheater->getName();
          $parameters['address'] = $movieTheater->getAddress();
          $parameters['id_movietheater'] = $movieTheater->getId();
          try {
     		$this->connection = Connection::getInstance();
			return $this->connection->ExecuteNonQuery($sql, $parameters);
		} catch(\PDOException $ex) {
               throw $ex;
          }
     }

  
              
              public function delete($name) 
              {
                    $sql = "UPDATE  MovieTheaters SET status=:status WHERE name = :name";
                    
                    $parameters['status'] = false;
                    $parameters['name'] = $name;
               
                    try {
                    $this->connection = Connection::getInstance();
                    return $this->connection->ExecuteNonQuery($sql, $parameters);
               } catch(\PDOException $ex) {
                         throw $ex;
                    }
               }

     public function deleteFisico($id)
     {
          $sql = "DELETE FROM movietheaters WHERE id_movietheater=:id_movietheater";
          $parameters['id_movietheater'] = $id;
          try {
               $this->connection = Connection::getInstance();
               return $this->connection->ExecuteNonQuery($sql, $parameters);
          }catch(\PDOException $ex) {
          throw $ex;
         }
     }




		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
                    $movieTheater = new MovieTheater();
                    $movieTheater->setId($p['id_movietheater']);
                    $movieTheater->setStatus($p['status']);
                    $movieTheater->setName($p['name']);
                    $movieTheater->setAddress($p['address']);
                    return $movieTheater;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }

        public function getById($id){
          $mt = $this->getMtById($id);
          if($mt!=false){ 
          if($this->getBillBoards($mt->getId())!=null){
          $mt->setBillBoard($this->getBillBoards($mt->getId()));
          }
          if($this->getCinemas($mt->getId())!=null){
          $mt->setCinemas($this->getCinemas($mt->getId()));
          }
          }
          return $mt;
        }


        public function getMtById($id)
        {
          $sql = "SELECT * FROM MovieTheaters where id_movietheater = :id_movietheater";

               $parameters['id_movietheater'] = $id;

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

}