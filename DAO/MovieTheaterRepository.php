<?php

namespace DAO;

use Models\MovieTheater as MovieTheater;
use Models\Movie as Movie;
use Models\Seat as Seat;

class MovieTheaterRepository extends Singleton
{

    // private $id;
	// private $status;
	// private $name;
	// private $address;
    // private $ticketPrice;
    
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

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
          public function delete($name) {
               /*$sql = "DELETE FROM MovieTheaters WHERE name = :name";

               $obj_pdo = new Conexion();

               try {
                    $conexion = $obj_pdo->conectar();

				$sentencia = $conexion->prepare($sql);

                    $sentencia->bindParam(":name", $name);

                    $sentencia->execute();


               } catch(PDOException $Exception) {

				throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );

			}*/
          }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){
				return new M_Usuario($p['id_movietheater'], $p['status'], $p['name'], $p['address'], $p['ticketPrice']);
			}, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }
}