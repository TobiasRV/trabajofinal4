<?php
namespace DAO;

use Models\Cinema as Cinema;
use Models\Movie as Movie;

class CinemaRepository extends Singleton
{
    private $connection;
    function __construct() {

    }

    public function Add($cinema)
    {

        $sql = "INSERT INTO Cinemas(status, name,ticketprice,seats id_movietheater) VALUES (:status, :name,:ticketprice,:seats, id_movietheater)";

        $parameters['status'] = $cinema->getStatus();
        $parameters['name'] = $cinema->getName();
        $parameters['ticketprice'] = $cinema->getTicketprice();
        $parameters['seats'] = $cinema->getSeats();
        $parameters['id_movietheater'] = $cinema->getIdMovieTheater();

        try {
          $this->connection = Connection::getInstance();
         return $this->connection->ExecuteNonQuery($sql, $parameters);
     } catch(\PDOException $ex) {
            throw $ex;
       }
    }

    public function read($name) {

        $sql = "SELECT * FROM Cinemas where name = :name";

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
    $sql = "SELECT * FROM Cinemas";

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

    public function edit($cinema) {
      
        $sql = "UPDATE Cinemas SET status = :status, name = :name, ticketprice = :ticketprice,seats = :seats WHERE id_cinema = :id_cinema";
        $parameters['status'] = $cinema->getStatus();
        $parameters['name'] = $cinema->getName();
        $parameters['ticketprice'] = $cinema->getTicketprice();
        $parameters['seats'] = $cinema->getSeats();
        $parameters['id_cinema'] = $cinema->getId();

        try {
          $this->connection = Connection::getInstance();
         return $this->connection->ExecuteNonQuery($sql, $parameters);
     } catch(\PDOException $ex) {
            throw $ex;
       }
   }


   public function delete($name) {
    $sql = "UPDATE  Cinemas SET status=:status WHERE name = :name";
    
    $parameters['status'] = false;
    $parameters['name'] = $name;

    try {
        $this->connection = Connection::getInstance();
       return $this->connection->ExecuteNonQuery($sql, $parameters);
   } catch(\PDOException $ex) {
          throw $ex;
     }
     }


    protected function mapear($value) {

        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){              
                 
                $cinema = new Cinema();
                $cinema->setId($p['id_cinema']);
                $cinema->setStatus($p['status']);
                $cinema->setName($p['name']);
                $cinema->setTicketPrice($p['ticketPrice']);
                $cinema->setSeats($p['seats']);
                $cinema->setIdMovieTheater($p['id_movietheater']);
                return $cinema;
           }, $value);

           return count($resp) > 1 ? $resp : $resp['0'];

    }
}