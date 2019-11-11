<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use Models\CreditCard as CreditCard;
use Controllers\UserController as UserController;
use DAO\MovieTheaterRepository as MovieTheaterRepository;
use DAO\CinemaRepository as CinemaRepository;

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
        $listadoMT = new MovieTheaterRepository();
        $movieTheaters = $listadoMT->getAll();
        require_once(VIEWS_PATH . "purchaseStep2.php");
    }

    public function continuePurchase1($idMovie)
    {
        $_SESSION["idMovieSearch"] = $idMovie;
        $this->purchaseStep2();
    }

    public function continuePurchase2($idShow, $idCinema, $avaiableSeats)
    {
        //vista donde se incluye valor total de la compra con/sin descuentos
        //elegir metodo de pago, ingresar datos de la tarjeta, chequear datos del usuario
        $purchase = new Purchase();
        $purchase->setShowId($idShow);
        $_SESSION["purchase"] = $purchase;
        $_SESSION["idCinema"]=$idCinema;
        $_SESSION["avaiableSeats"]=$avaiableSeats;
        $this->purchaseStep3();
        
    }

    public function purchaseStep3()
    {
        $userControl = new UserController();
        require_once(VIEWS_PATH . "purchaseStep3.php");
    }

    public function confirmPurchase($method, $nCard, $qTickets)
    {
        $creditCard = new CreditCard();
        $creditCard->setCompany($method);
        $creditCard->setNumber($nCard);
        $listado = new CinemaRepository();
        $cinemas = $listado->getAll();
        foreach($cinemas as $cm)
        {
            if($cm->getId() == $_SESSION["idCinema"])
            {
                $_SESSION["ticketPrice"] = $cm->getTicketPrice();
            }
        }
        // $creditCard->setFirstnameOwner($nameOw);
        // $creditCard->setLastnameOwner($surnameOw);
        // $creditCard->setDniOwner($dniOw);
        // $creditCard->setExpireDate($expire);
        // $creditCard->setSecurityCode($code);
        $_SESSION["creditCard"] = $creditCard;

        if($_SESSION["avaiableSeats"] >= $qTickets)
        {
            $purchase = new Purchase();
            $purchase=$_SESSION["purchase"];
            $purchase->setPurchaseDate(date('Y-m-d'));
            $purchase->setQuantityTickets($qTickets);
            $purchase->setTicketPrice($_SESSION["ticketPrice"]);
            $totalAux=$purchase->getQuantityTickets() * $purchase->getTicketPrice();
            if($this->checkDiscount()==true)
            {
                $purchase->setDiscount(0.25);
            }
            $purchase->setTotal($totalAux - ($totalAux * $purchase->getDiscount()));
        }

        require_once(VIEWS_PATH . "confirmPurchase.php");

        
    }

    public function checkDiscount()
    {
        $flag=false;
        $day=date('l');
        if( $day=="Tuesday" || $day=="Wednesday")
        {
            if($_SESSION["purchase"]->getQuantityTickets()>=2)
            {
                $flag=true;
            }
        }

        return $flag;
    }

}