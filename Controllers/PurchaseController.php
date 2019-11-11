<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use Controllers\UserController as UserController;

class PurchaseController
{


    public function purchaseStep1()
    {
        $userControl = new UserController();
        $movieRepo = new MovieRepository();
        $listado=$movieRepo->getNowPlayingMovies();
        require_once(VIEWS_PATH . "purchaseStep1.php");
    }

    public function purchaseStep2()
    {
        $userControl = new UserController();
        $showRepo = new ShowRepository();
        $listado = $showRepo->getAll();
        require_once(VIEWS_PATH . "purchaseStep2.php");
    }

    public function continuePurchase1($id, $quant, $dt)
    {
       $idMovie=$id;
       $quantity=$quant;
       $date=$dt;
       $this->purchaseStep2();
    }

    public function continuePurchase2($id, $desc)
    {
        //vista donde se incluye valor total de la compra con/sin descuentos
        //elegir metodo de pago, ingresar datos de la tarjeta, chequear datos del usuario
        $idShow=$id;
        $discount=$desc;
        $this->purchaseStep3();
        
    }

    public function purchaseStep3()
    {
        require_once(VIEWS_PATH . "purchaseStep3.php");
    }

    public function confirmPurchase($method, $nCard, $nameOw, $surnameOw, $dniOw, $expire, $code)
    {
        $paymentMethod=$method;
        $cardNumber=$nCard;
        $firstnameOwner=$nameOw;
        $lastnameOwner=$surnameOw;
        $dniOwner=$dniOw;
        $expireDate=$expire;
        $safetyCode=$code;
        require_once(VIEWS_PATH . "confirmPurchase.php");
    }

}