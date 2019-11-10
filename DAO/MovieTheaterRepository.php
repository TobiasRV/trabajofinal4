<?php

namespace DAO;

use Models\MovieTheater as MovieTheater;
use Models\Movie as Movie;
use Models\Seat as Seat;

class MovieTheaterRepository extends Singleton
{

    private $connection;

          function __construct() {

          }
          public function Add($movieTheater) {

			$sql = "INSERT INTO MovieTheaters (status, name, address, ticketPrice) VALUES (:status, :name, :address, :ticketPrice)";

               $parameters['status'] = $movieTheater->getStatus();
               $parameters['name'] = $movieTheater->getName();
               $parameters['address'] = $movieTheater->getAddress();
               $parameters['ticketPrice'] = $movieTheater->getTicketPrice();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

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


          public function getAll() {
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


          public function edit($movieTheater) {


            
               $sql = "UPDATE MovieTheaters SET status = :status, name = :name, address = :address, ticketPrice = :ticketPrice WHERE id_movietheater = :id_movietheater";

               $parameters['status'] = $movieTheater->getStatus();
               $parameters['name'] = $movieTheater->getName();
               $parameters['address'] = $movieTheater->getAddress();
               $parameters['ticketPrice'] = $movieTheater->getTicketPrice();
               $parameters['id_movietheater'] = $movieTheater->getId();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
              }
       public function delete($name) {
            /*
    $sql = "UPDATE  Cinemas SET status=:status WHERE name = :name";
    
    $parameters['status'] = false;
    $parameters['name'] = $cinema->getName();
    
    try {
        $this->connection = Connection::getInstance();
       return $this->connection->ExecuteNonQuery($sql, $parameters);
   } catch(\PDOException $ex) {
          throw $ex;
     }
     }
     */
  }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
                    $movieTheater = new MovieTheater();
                    $movieTheater->setId($p['id_movietheater']);
                    $movieTheater->setStatus($p['status']);
                    $movieTheater->setName($p['name']);
                    $movieTheater->setAddress($p['address']);
                    $movieTheater->setTicketPrice($p['ticketPrice']);
                    return $movieTheater;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }
}