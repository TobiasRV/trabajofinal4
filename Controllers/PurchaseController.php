<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use Models\Purchase as Purchase;
use Models\CreditCard as CreditCard;
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

    public function continuePurchase1($idMovie, $quantityTickets, $dt)
    {
        $purchaseSession = new Purchase();
        $purchaseSession->setMovieId($idMovie);
        $purchaseSession->setQuantityTickets($quantityTickets);
        $_SESSION["purchaseSession"] = $purchaseSession;
        $date=$dt;
        $this->purchaseStep2();
    }

    public function continuePurchase2($idShow, $discount)
    {
        //vista donde se incluye valor total de la compra con/sin descuentos
        //elegir metodo de pago, ingresar datos de la tarjeta, chequear datos del usuario
        $purchaseSession = new Purchase();
        $purchaseSession = $_SESSION["purchaseSession"];
        $purchaseSession->setShowId($idShow);
        $purchaseSession->setDiscount($discount);
        $_SESSION["purchaseSession"] = $purchaseSession;
        $this->purchaseStep3();
        
    }

    public function purchaseStep3()
    {
        require_once(VIEWS_PATH . "purchaseStep3.php");
    }

    public function confirmPurchase($method, $nCard, $nameOw, $surnameOw, $dniOw, $expire, $code)
    {
        $creditCardSession = new CreditCard();
        $creditCardSession->setCompany($method);
        $creditCardSession->setNumber($nCard);
        $creditCardSession->setFirstnameOwner($nameOw);
        $creditCardSession->setLastnameOwner($surnameOw);
        $creditCardSession->setDniOwner($dniOw);
        $creditCardSession->setExpireDate($expire);
        $creditCardSession->setSecurityCode($code);
        $_SESSION["creditCardSession"] = $creditCardSession;
        require_once(VIEWS_PATH . "confirmPurchase.php");
    }

}