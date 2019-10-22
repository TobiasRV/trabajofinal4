<?php namespace Controllers;

use DAO\CinemaRepository as CinemaRepository;

class cinemaController{

    private $cineDAO;

    public function __construct(){
        $this->cineDAO = new CinemaRepository();
    }

    public function addCinema(){

    }
}

?>