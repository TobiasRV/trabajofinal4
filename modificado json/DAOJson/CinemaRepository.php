<?php

namespace DAOJson;

use Models\Cinema as Cinema;
use Models\Movie as Movie;
use Models\Seat as Seat;

class CinemaRepository
{
    private $cinemaList = array();

    public function deleteCinema($name)
    {
        $this->RetrieveData();

        $i = 0;

        foreach ($this->cinemaList as $value) {
            if ($value->getName() == $name) {
                unset($this->cinemaList[$i]);
            }
            $i++;
        }
        $this->Savedata();
    }

    public function Add(Cinema $cinema)
    {
        $this->RetrieveData();

        $id = count($this->cinemaList) + 1;
        $cinema->setId($id);

        array_push($this->cinemaList, $cinema);

        $this->Savedata();
    }

    public function getAll()
    {
        $this->RetrieveData();

        return $this->cinemaList;
    }

    private function Savedata()
    {
        $arrayToEncode = array();

        foreach ($this->cinemaList as $cine) {
            $ArrayConDatos = array();
            $ArrayPeliculas = $cine->getBillBoard();
            $ArrayConDatosPeliculas = array();
            $ArrayAsientos = $cine->getSeats();
            $ArrayConDatosAsientos = array();

            $ArrayConDatos['name'] = $cine->getName();
            $ArrayConDatos['address'] = $cine->getAddress();

            foreach ($ArrayPeliculas as $pelicula) {
                $ArrayConDatosPeliculas['adult'] = $pelicula->getAdult();
                $ArrayConDatosPeliculas['idMovie'] = $pelicula->getIdMovie();
                $ArrayConDatosPeliculas['idGenre'] = $pelicula->getIdGenre();
                $ArrayConDatosPeliculas['originalTitle'] = $pelicula->getOriginalTitle();
                $ArrayConDatosPeliculas['title'] = $pelicula->getTitle();
                $ArrayConDatosPeliculas['overview'] = $pelicula->getOverview();
                $ArrayConDatosPeliculas['posterPath'] = $pelicula->getPosterPath();
                $ArrayConDatosPeliculas['releaseDate'] = $pelicula->getReleaseDate();
                $ArrayConDatosPeliculas['backdropPath'] = $pelicula->getBackdropPath();
                $ArrayConDatos['billBoard'][] = $ArrayConDatosPeliculas;
            }

            foreach ($ArrayAsientos as $asiento) {
                $ArrayConDatosAsientos['number'] = $asiento->getNumber();
                $ArrayConDatosAsientos['status'] = $asiento->getStatus();
                $ArrayConDatos['seats'][] = $ArrayConDatosAsientos;
            }

            $ArrayConDatos['ticketPrice'] = $cine->getTicketPrice();

            array_push($arrayToEncode, $ArrayConDatos);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents('Data/cinemas.json', $jsonContent);
    }

    private function RetrieveData()
    {
        $this->cinemaList = array();

        if (file_exists('Data/cinemas.json')) {
            $jsonContent = file_get_contents('Data/cinemas.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {
                $arrayMovies = array();
                $arraySeats = array();
                $cinema = new Cinema();
                $cinema->setName($valuesArray['name']);
                $cinema->setAddress($valuesArray['address']);

                $arrayDatosMovies = $valuesArray['billBoard'];
                $arrayMovies = array();
                foreach ($arrayDatosMovies as $movie) {
                    $peli = new Movie();
                    $peli->setAdult($movie['adult']);
                    $peli->setIdGenre($movie['idGenre']);
                    $peli->setIdMovie($movie['idMovie']);
                    $peli->setTitle($movie['title']);
                    $peli->setOriginalTitle($movie['originalTitle']);
                    $peli->setOverview($movie['overview']);
                    $peli->setPosterPath($movie['posterPath']);
                    $peli->setReleaseDate($movie['releaseDate']);
                    $peli->setBackdropPath($movie['backdropPath']);
                    array_push($arrayMovies, $peli);
                }
                $cinema->setBillBoard($arrayMovies);

                $arrayDatosSeats = $valuesArray['seats'];
                $arraySeats = array();

                foreach($arrayDatosSeats as $seat){
                    $asiento = new Seat($seat['number'],$seat['status']);
                    array_push($arraySeats, $asiento);
                }
                $cinema->setSeats($arraySeats);

                $cinema->setTicketPrice($valuesArray['ticketPrice']);
                array_push($this->cinemaList, $cinema);
            }
        }
    }
}
