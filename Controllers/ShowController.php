<?php

namespace Controllers;

use Models\Show as Show;

class ShowController
{
    private $showDAO;

    public function __construct()
    { 
        $this->showDAO = new ShowDAO();
    }

    public function createShow($date, $time, $id_cinema, $id_movie)
    {
        $show = new Show();

        $show->setId($this->getNextId());
        $show->setDate($date);
        $show->setTime($time);
        $show->setIdCinema($id_cinema);
        $show->setIdMovie($id_movie);

        $this->showDAO->Add($show);
    }

    public function getNextId()
    {
        $showList = $this->showDAO->getAll();
        $newId = count($showList) + 1;
        return $newId;
    }

    public function modifyShow($id, $date, $time, $seats, $id_cinema, $id_movie, $status){
        $showList = $this->showDAO->getAll();

        foreach($showList as $show){
            if($show->getId() == $id){
                $show->setDate($date);
                $show->setTime($time);
                $show->setSeats($seats);
                $show->setIdCinema($id_cinema);
                $show->setIdMovie($id_movie);
                $show->setStatus($status);
                break;
            }
        }
        $this->showDAO->saveList($showList);
    }
}