<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use Models\CreditCard as CreditCard;
use Controllers\UserController as UserController;
use DAO\MovieTheaterRepository as MovieTheaterRepository;
use DAO\CinemaRepository as CinemaRepository;
use DAO\PurchaseRepository as PurchaseRepository;
use DAO\CreditCardRepository as CreditCardRepository;

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

    public function continuePurchase2($idShow, $idCinema)
    {
        $purchase = new Purchase();
        $purchase->setIdShow($idShow);
        $_SESSION["purchase"] = $purchase;
        $_SESSION["idCinema"]=$idCinema;
        $shRepo = new ShowRepository();
        $repoShows = $shRepo->getAvaiableSeats($idShow);
        $_SESSION["avaiableSeats"]=$repoShows;
        $this->purchaseStep3();
        
    }

    public function purchaseStep3()
    {
        $userControl = new UserController();
        $creditCardsRepo = new CreditCardRepository();
        $listado = $creditCardsRepo->getCreditCards($_SESSION["loggedUser"]->getId());
        require_once(VIEWS_PATH . "purchaseStep3.php");
    }

    public function confirmPurchase($id_creditcard, $qTickets)
    {

        $ccRepo = new CreditCardRepository();
        $listadoCC = $ccRepo->getAll();
        foreach($listadoCC as $ccs)
        {
            if($ccs->getId() == $id_creditcard)
            {
                $creditCard = new CreditCard();
                $creditCard->setCompany($ccs->getCompany());
                $creditCard->setNumber($ccs->getNumber());
            }
        }
        $_SESSION["creditCard"] = $creditCard;

        $listado = new CinemaRepository();
        $cinemas = $listado->getAll();
        var_dump($cinemas);
        echo "<br>".$_SESSION["idCinema"]."<br>";
        foreach($cinemas as $cm)
        {
           echo "<br>".$cm->getId()."<br>";
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

       
        //se comprueba que haya suficientes asientos libres para realizar la compra
        if($_SESSION["avaiableSeats"] >= $qTickets)
        {
            $purchase = new Purchase();
            $purchase=$_SESSION["purchase"];
            $purchase->setPurchaseDate(date('Y-m-d'));
            $purchase->setQuantityTickets($qTickets);
            //$purchase->setTicketPrice($_SESSION["ticketPrice"]);
            $totalAux=$purchase->getQuantityTickets() * $_SESSION["ticketPrice"];
            if($this->checkDiscount()==true)
            {
                $purchase->setDiscount(0.25);
            }
            $purchase->setTotal($totalAux - ($totalAux * $purchase->getDiscount()));

            $_SESSION["purchase"] = $purchase;
            
            //var_dump($_SESSION["purchase"]);

            //Se resta de la capacidad de asientos de la funcion la cantidad de tickets comprados
            $showsRepo = new ShowRepository();
            $listadoShows = $showsRepo->getAll();
            foreach($listadoShows as $shows)
            {
                if($shows->getId() == $purchase->getIdShow())
                {
                    $shows->setSeats($shows->getSeats() - $purchase->getQuantityTickets());
                }
            }
        }

        $userControl = new UserController();
        $moviesRepo = new MovieRepository();
        $listMovies = $moviesRepo->getAll();

        
        require_once(VIEWS_PATH . "confirmData.php");

        
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

    public function addCreditCard($company, $number)
    {
        $newCreditCard = new CreditCard();
        $newCreditCard->setNumber($number);
        $newCreditCard->setCompany($company);
        $newCreditCard->setIdUser($_SESSION["loggedUser"]->getId());
        $creditCardRepo = new CreditCardRepository();
        $creditCardRepo->Add($newCreditCard);
        $this->purchaseStep3();
    }

    public function checkButton($value)
    {
        if($value == "confirmPurchase")
        {
            $purchase=$_SESSION["purchase"];
            $purchaseRepo = new PurchaseRepository();
            $purchaseRepo->Add($purchase);
            ?>
            <script>
                alert("La compra se ha realizado con éxito.");
            </script>
            <?php
            $this->generateTickets();
            $this->clearSessionVariables();
            include_once(VIEWS_PATH . "index.php");
        }
        else
        {
            $this->clearSessionVariables();
            include_once(VIEWS_PATH . "index.php");
        }
    }

    public function generateTickets()
    {
        $q_Tickets = $_SESSION["purchase"]->getQuantityTickets();
        for($i=0;$i<$q_Tickets;$i++)
        {
            $ticket = new Ticket();
            $ticket->setIdPurchase();
            $ticketsRepo = new TicketRepository();
            $ticketsRepo->Add($ticket);
        }
    }

    public function clearSessionVariables()
    {
        unset($_SESSION["purchase"]);
        unset($_SESSION["idMovieSearch"]);
        unset($_SESSION["idCinema"]);
        unset($_SESSION["avaiableSeats"]);
        unset($_SESSION["creditCard"]);
        unset($_SESSION["ticketPrice"]);
    }

    

}