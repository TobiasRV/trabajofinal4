<?php

namespace DAOJson;

use DAOJson\IRepository as IRepository;
use Models\MovieTheater as MovieTheater;

class MovieTheaterDAO implements IRepository
{

    private $movieTheaterList = array();

    public function saveList($newList){
        $this->movieTheaterList = $newList;
        $this->saveData();
    }

    public function Add($movieTheater)
    {

        $this->RetrieveData();
        if (empty($this->movieTheaterList)) {
            $movieTheater->setId(1);
        } else {
            $lastElement = end($this->movieTheaterList);
            $movieTheater->setId($lastElement->getId() + 1);
        }
       

        array_push($this->movieTheaterList, $movieTheater);

        $this->savedata();

    }

    public function getById($id)
    {
        $this->RetrieveData();
        foreach ($this->movieTheaterList as $movieTheater) {
            if ($id == $movieTheater->getId()) {
                $result = $movieTheater;
                break;
            }
        }
        return $result;
    }

    public function getAll()
    {
        $this->RetrieveData();

        return $this->movieTheaterList;
    }

    public function saveData()
    {

        $arrayToEncode = array();

        foreach ($this->movieTheaterList as $movieTheater) {

            $valuesArray = array();

            $valuesArray['id'] = $movieTheater->getId();
            $valuesArray['status'] = $movieTheater->getStatus();
            $valuesArray['name'] = $movieTheater->getName();
            $valuesArray['address'] = $movieTheater->getAddress();
            $valuesArray['cinemas'] = $movieTheater->getCinemas();
            $valuesArray['billBoard'] = $movieTheater->getBillBoard();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents('Data/movietheaters.json', $jsonContent);
    }

    public function retrieveData()
    {
        $this->movieTheaterList = array();

        if (file_exists('Data/movietheaters.json')) {
            $jsonContent = file_get_contents('Data/movietheaters.json');
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {

                $movieTheater = new MovieTheater();

                $movieTheater->setId($valuesArray['id']);
                $movieTheater->setStatus($valuesArray['status']);
                $movieTheater->setName($valuesArray['name']);
                $movieTheater->setAddress($valuesArray['address']);
                $movieTheater->setCinemas($valuesArray['cinemas']);
                $movieTheater->setBillBoard($valuesArray['billBoard']);

                array_push($this->movieTheaterList, $movieTheater);
            }
        }
    }

    public function read($id)
    {

        $this->retrieveData();
        $flag=false;
        $movieTheaterReturn = new MovieTheater();
        foreach($this->movieTheaterList as $t)
        {
            if(!$flag)
            {
                if($id==$t->getId())
                {
                    $flag=true;
                    $movieTheaterReturn=$t;
                }
            }
        }
        return $movieTheaterReturn;
    }

    public function edit($movieTheater){

    $this->retrieveData();

        foreach ($this->movieTheaterList as $mt) {
            if ($mt->getId() == $movieTheater->getId()) {

                if ($movieTheater->getStatus() != null)
                    $mt->setStatus($movieTheater->getStatus());

                if ($movieTheater->getName() != null)
                    $mt->setName($movieTheater->getName());

                if ($movieTheater->getAddress() != null)
                    $mt->setAddress($movieTheater->getAddress());

                if (!empty($movieTheater->getCinemas()))
                    $mt->setCinemas($movieTheater->getCinemas());

                if (!empty($movieTheater->getBillBoard()))
                    $mt->setBillBoard($movieTheater->getBillBoard());

                break;
            }
        }
        $this->saveData();
    }

    public function editBillBoard($id,$billboard)
    {
        $this->retrieveData();
        $movieTheaterList = $this->movieTheaterDAO->getAll();

        foreach ($this->movieTheaterList as $mt) {
            if ($mt->getId() == $id) {
                $mt->setBillBoard($billBoard);
                break;
            }
        }
        $this->saveData();

    }


    public function deleteFisico($id){

    $this->retrieveData();

    foreach ($this->movieTheaterList as $movieTheater) 
    {
        if ($movieTheater->getId() == $id)
        {            
            $idToDelete = array_search($movieTheater, $this->movieTheaterList);
            unset($this->movieTheaterList[$idToDelete]);
            break;
            }
        }

        $this->saveData();
    }
}
