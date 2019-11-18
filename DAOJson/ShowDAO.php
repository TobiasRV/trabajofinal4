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
        if (empty($this->showList)) {
            $show->setId(1);
        } else {
            $lastElement = end($this->showList);
            $show->setId($lastElement->getId() + 1);
        }
       

        array_push($this->showList, $show);

        $this->savedata();
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
            $valuesArray['seats'] = $show->getSeats();
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
                $show->setSeats($valuesArray['seats']);

                array_push($this->showList, $show);
            }
        }
    }

    public function read($id)
    {
        $this->retrieveData();
        $flag=false;
        $showReturn = new Show();
        foreach($this->showList as $t)
        {
            if(!$flag)
            {
                if($id==$t->getId())
                {
                    $flag=true;
                    $showReturn=$t;
                }
            }
        }
        return $showReturn;
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

    
    public function edit($show) {

        $this->retrieveData();

        foreach($this->showList as $values){

            //juan tiene paja de terminar esta parte
            if($values->getId() == $show->getId()){
                $values->setSeats($show->getSeats());
            break;
            }
        }
        $this->saveData();
    }

    public function deleteFisico($id){
        
        $this->retrieveData();
        foreach ($this->showList as $show) {
            if ($show->getId() == $id) {
                $idToDelete = array_search($show, $this->showList);
                unset($this->showList[$idToDelete]);
                break;
            }
        }

        $this->saveData();
    }
}
