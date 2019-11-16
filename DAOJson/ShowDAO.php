<?php

namespace DAOJson;

use DAOJson\IRepository as IRepository;
use Models\Show as Show;

class ShowDAO implements IRepository
{
    private $showList = array();

    public function saveList($listToSave){

        $this->showList = $listToSave;
        $this->saveData();
    }

    public function Add($show)
    {
        $this->RetrieveData();

        array_push($this->showList, $show);

        $this->Savedata();
    }

    function getAll()
    {

        $this->RetrieveData();

        return $this->showList;
    }

    function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->showList as $show) {
            $valuesArray = array();
            $valuesArray['id'] = $show->getId();
            $valuesArray['date'] = $show->getDate();
            $valuesArray['time'] = $show->getTime();
            $valuesArray['id_cinema'] = $show->getIdCinema();
            $valuesArray['id_movie'] = $show->getIdMovie();
            $valuesArray['status'] = $show->getStatus();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents('Data/shows.json', $jsonContent);
    }

    function retrieveData()
    {
        $this->showList = array();

        if (file_exists('Data/shows.json')) {
            $jsonContent = file_get_contents('Data/shows.json');
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $show = new Show();

                $show->setId($valuesArray['id']);
                $show->setDate($valuesArray['date']);
                $show->setTime($valuesArray['time']);
                $show->setIdCinema($valuesArray['id_cinema']);
                $show->setIdMovie($valuesArray['id_movie']);
                $show->setStatus($valuesArray['status']);

                array_push($this->showList, $show);
            }
        }
    }

    public function getAvaiableSeats($id)
    {
         return $this->read($id)->getSeats();
    }

    public function getShowData($id)
    {
    
     $this->retrieveData();
     $showData="";
     foreach($this->showList as $shows)
     {
          if($shows->getId() == $id)
          {
               $showData = $shows->getDate() . " " . $shows->getTime();
          }
     }

     return $showData;
    }


}
