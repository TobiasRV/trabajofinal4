<?php namespace Controllers;

use DAOJson\MovieTheaterDAO as MovieTheaterDAO;
use Models\MovieTheater as MovieTheater;

class MovieTheaterController{

    private $movieTheaterDAO;

    public function __construct()
    {
        $this->movieTheaterDAO = new MovieTheaterDAO();
    }

    public function createMovieTheater($name, $address, $ticketPrice, $cinemas = array(), $moviechecked = array())
    {
        $movieTheater = new MovieTheater();
        $movieTheater->setId($this->getNextId());
        $movieTheater->setName($name);
        $movieTheater->setAddress($address);
        $movieTheater->setTicketPrice($ticketPrice);
        $movieTheater->setCinemas($cinemas);
        $movieTheater->setBillBoard($moviechecked);
          
        $this->showDAO->Add($movieTheater);

    }

    public function getNextId()
    {
        $movieTheaterList = $this->movieTheaterDAO->getAll();
        $newId = count($movieTheaterList) + 1;
        return $newId;
    }

    public function modifyMovieTheater($id, $status, $name, $address, $ticketPrice, $cinemas = array(), $billBoard = array()){
        $movieTheaterList = $this->movieTheaterDAO->getAll();

        foreach($movieTheaterList as $movieTheater){
            if($movieTheater->getId() == $id){
                $movieTheater->setStatus($status);
                $movieTheater->setName($name);
                $movieTheater->setAddress($address);
                $movieTheater->setTicketPrice($ticketPrice);
                $movieTheater->setCinemas($cinemas);
                $movieTheater->setBillBoard($billBoard);
                break;
            }
        }
        $this->movieTheaterDAO->saveList($movieTheaterList);
    }

}
