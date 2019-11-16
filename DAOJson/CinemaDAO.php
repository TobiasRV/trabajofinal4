<?php

namespace DAOJson;

use DAOJson\IRepository as IRepository;
use Models\Cinema as Cinema;
use Models\Seat as Seat;

class CinemaDAO implements IRepository
{
    private $cinemaList = array();

    function Add($cinema)
    {
        $this->RetrieveData();

        array_push($this->cinemaList, $cinema);

        $this->Savedata();
    }

    function getAll()
    {
        $this->RetrieveData();

        return $this->cinemaList;
    }

    public function saveNewList($cinemaList)
    {
        $this->cinemaList = $cinemaList;
        $this->saveData();
    }

    function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->cinemaList as $cinema) {
            $valuesArray = array();
            $seatsArray = $cinema->getSeats();
            $seatsValuesArray = array();

            $valuesArray['id'] = $cinema->getId();
            $valuesArray['status'] = $cinema->getStatus();
            $valuesArray['name'] = $cinema->getName();
            $valuesArray['ticketPrice'] = $cinema->getTicketPrice();
            $valuesArray['idMovieTheater'] = $cinema->getIdMovieTheater();

            foreach ($seatsArray as $seat) {
                $seatsValuesArray['number'] = $seat->getNumber();
                $seatsValuesArray['status'] = $seat->getStatus();
                $valuesArray['seats'][] = $seatsValuesArray;
            }

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents('Data/cinemas.json', $jsonContent);
    }

    function retrieveData()
    {
        $this->cinemaList = array();

        if (file_exists('Data/cinemas.json')) {
            $jsonContent = file_get_contents('Data/cinemas.json');
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $cinema = new Cinema();
                $arraySeats = array();

                $cinema->setId($valuesArray['id']);
                $cinema->setStatus($valuesArray['status']);
                $cinema->setName($valuesArray['name']);
                $cinema->setTicketPrice($valuesArray['ticketPrice']);
                $cinema->setIdMovieTheater($valuesArray['idMovieTheater']);

                $seatsValuesArray = $valuesArray['seats'];

                foreach ($seatsValuesArray as $s) {
                    $seat = new Seat($s['number'], $s['status']);
                    array_push($arraySeats, $seat);
                }

                $cinema->setSeats($arraySeats);

                array_push($this->cinemaList, $cinema);
            }
        }
    }

    public function read($id)
    {
        $this->retrieveData();
        $flag=false;
        $cinemaReturn = new Cinema();
        foreach($this->cinemaList as $t)
        {
            if(!$flag)
            {
                if($id==$t->getId())
                {
                    $flag=true;
                    $cinemaReturn=$t;
                }
            }
        }
        return $cinemaReturn;
    }
}
