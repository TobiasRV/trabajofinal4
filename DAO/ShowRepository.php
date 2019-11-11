<?php
namespace DAO;

use Models\Show as Show;
use Models\Movie as Movie;

class ShowRepository extends Singleton
{
    private $connection;
    function __construct() {

    }

    public function Add($show)
    {

        $sql = "INSERT INTO Shows(show_date,show_time,seats,status,id_cinema,id_movie) VALUES (:show_date,:show_time,:seats,:status,:id_cinema,:id_movie)";

        $parameters['show_date'] = $show->getDate();
        $parameters['show_time'] = $show->getTime();
        $parameters['seats'] = $show->getSeats();
        $parameters['status'] = $show->getStatus();
        $parameters['id_cinema'] = $show->getId_cinema();
        $parameters['id_movie'] = $show->getId_movie();

        try {
          $this->connection = Connection::getInstance();
         return $this->connection->ExecuteNonQuery($sql, $parameters);
     } catch(\PDOException $ex) {
            throw $ex;
       }
    }

    public function read($id) {

        $sql = "SELECT * FROM Shows where id_show = :id_show";

        $parameters['id_show'] = $id;

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
    $sql = "SELECT * FROM Shows";

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

    public function edit($show) {
      
        $sql = "UPDATE Show SET show_date = :show_date, show_time = :show_time, seats = :seats, status = :status WHERE id_show= :id_show";


        $parameters['show_date'] = $show->getDate();
        $parameters['show_time'] = $show->getTime();
        $parameters['seats'] = $show->getSeats();
        $parameters['status'] = $show->getStatus();
        $parameters['id_show'] = $show->getId();


        try {
          $this->connection = Connection::getInstance();
         return $this->connection->ExecuteNonQuery($sql, $parameters);
     } catch(\PDOException $ex) {
            throw $ex;
       }
   }


   public function delete($id) {
    $sql = "UPDATE  Cinemas SET status=:status WHERE id_show = :id_show";
    
    $parameters['status'] = false;
    $parameters['id_show'] = $id;

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
                 
                $show = new Show();
                $show->setId($p['id_show']);
                $show->setDate($p['show_date']);
                $show->setTime($p['show_time']);
                $show->setSeats($p['seats']);
                $show->setStatus($p['status']);
                $show->setId_Cinema($p['id_cinema']);
                $show->setId_Movie($p['id_movie']);
                return $show;
           }, $value);

           return count($resp) > 1 ? $resp : $resp['0'];

    }

    //funciones extras

    public function getAvaiableSeats($id)
    {
         return $this->read($id)->getSeats();
    }

    public function getShowData($id)
    {
     $showRepo = new ShowRepository();
     $showRepo = $this->getAll();
     $showData="";
     foreach($showRepo as $shows)
     {
          if($shows->getId() == $id)
          {
               $showData = $shows->getDate() . " " . $shows->getTime();
          }
     }

     return $showData;
    }

   
}