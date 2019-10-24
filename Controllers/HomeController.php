<?php namespace Controllers;

class HomeController{

    public function Index(){
        require_once(VIEWS_PATH . "index.php");
    }

    public function Prueba(){
        require_once(VIEWS_PATH . "prueba.php");
    }

    public function ShowBillboard(){
        $movies = array();
        $movies = $_POST['movies'];
        include(ROOT . "Views/header.php");
        include(ROOT . "Views/nav.php");
        include(ROOT . "Views/footer.php");
    }
}