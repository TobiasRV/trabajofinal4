<?php namespace Controllers;

class HomeController{

    public function Index(){
        require_once(VIEWS_PATH . "index.php");
    }

    public function Prueba(){
        require_once(VIEWS_PATH . "prueba.php");
    }
}