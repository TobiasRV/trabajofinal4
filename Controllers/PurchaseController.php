<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use Controllers\UserController as UserController;
use Models\CreditCard as CreditCard;
//DAO BD
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use DAO\MovieTheaterRepository as MovieTheaterRepository;
use DAO\CinemaRepository as CinemaRepository;
use DAO\PurchaseRepository as PurchaseRepository;
use DAO\CreditCardRepository as CreditCardRepository;
use DAO\TicketRepository as TicketRepository;
//END DAO BD

//DAO JSON
// use DAOJson\movieDAO as MovieRepository;
// use DAOJson\ShowDAO as ShowRepository;
// use DAOJson\MovieTheaterDAO as MovieTheaterRepository;
// use DAOJson\CinemaDAO as CinemaRepository;
// use DAOJson\PurchaseRepository as PurchaseRepository;
// use DAOJson\CreditCardRepository as CreditCardRepository;
// use DAOJson\TicketRepository as TicketRepository;
//END DAO JSON

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
        $cinemasRepo = new CinemaRepository();
        $listadoCinemas = $cinemasRepo->getAll();
                
        require_once(VIEWS_PATH . "purchaseStep2.php");
    }

    public function continuePurchase1($idMovie)
    {
        $_SESSION["idMovieSearch"] = $idMovie;
        $this->purchaseStep2();
    }

    public function continuePurchase2($idShow)
    {
        $purchase = new Purchase();
        $purchase->setIdShow($idShow);
        $showRepo = new ShowRepository();
        $showObj = $showRepo->read($idShow); 
        $_SESSION["purchase"] = $purchase;
        $_SESSION["idCinema"]=$showObj->getIdCinema();
        $_SESSION["avaiableSeats"]=$showObj->getSeats();
        //setear nombre de cine en session
        $cinemas = new CinemaRepository();
        $cinemasRepo = $cinemas->getAll();
        $idMovieTheater=0;
        foreach($cinemasRepo as $cinemas)
        {
            if($cinemas->getId() == $_SESSION["idCinema"])
            {
                $idMovieTheater = $cinemas->getIdMovieTheater();
            }
        }

        $movieTheaters = new MovieTheaterRepository();
        $movieTheatersRepo = $movieTheaters->getAll();
        $nameMovieTheater="";
        foreach($movieTheatersRepo as $movieTheaters)
        {
            if($movieTheaters->getId() == $idMovieTheater)
            {
                $nameMovieTheater = $movieTheaters->getName();
            }
        }
        $_SESSION["nameMovieTheater"] = $nameMovieTheater;

        $_SESSION["checkCreditCard"] = false;

        $this->purchaseStep3();
        
    }

    public function purchaseStep3()
    {
        $userControl = new UserController();
        $creditCardsRepo = new CreditCardRepository();
        $listado = $creditCardsRepo->getCreditCards($_SESSION["loggedUser"]->getId());

       require_once(VIEWS_PATH . "purchaseStep3.php");
    }

    public function confirmPurchase($id_creditcard,  $creditCardNumber, $qTickets)
    {
        $this->checkCreditCardNumber($creditCardNumber);
        if($_SESSION["checkCreditCard"] == true)
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
                    $creditCard->setIdUser($ccs->getIdUser($_SESSION["loggedUser"]->getId()));
                }
            }
            $creditCard = $ccRepo->getId($creditCard);
            $_SESSION["creditCard"] = $creditCard;

            $listado = new CinemaRepository();
            $cinemas = $listado->getAll();
            foreach($cinemas as $cm)
            {
                if($cm->getId() == $_SESSION["idCinema"])
                {
                    $_SESSION["ticketPrice"] = $cm->getTicketPrice();
                    
                }
            }
        
            //se comprueba que haya suficientes asientos libres para realizar la compra
            if($_SESSION["avaiableSeats"] >= $qTickets)
            {
                $purchase = new Purchase();
                $purchase=$_SESSION["purchase"];
                $purchase->setPurchaseDate(date('Y-m-d'));
                $purchase->setQuantityTickets($qTickets);
                
                $totalAux=$purchase->getQuantityTickets() * $_SESSION["ticketPrice"];
                if($this->checkDiscount()==true)
                {
                    $purchase->setDiscount(0.25);
                }
                $purchase->setTotal($totalAux - ($totalAux * $purchase->getDiscount()));
                $purchase->setIdCreditCard($_SESSION["creditCard"]->getId());

                $_SESSION["purchase"] = $purchase;
                

                
            }

            $userControl = new UserController();
            $moviesRepo = new MovieRepository();
            $showsRepo = new ShowRepository();
            $listMovies = $moviesRepo->getAll();
            $nameMovie="";
            foreach($listMovies as $lm)
            {
                if($lm->getIdMovie() == $_SESSION["idMovieSearch"])
                {
                    $nameMovie=$lm->getTitle();
                }
            }

            $showData = $showsRepo->getShowData($_SESSION["purchase"]->getIdShow());
            
            require_once(VIEWS_PATH . "confirmData.php");
        
        ?>
            <!-- <script>
                alert("Corrobore que los datos sean correctos y confirme su compra.");
            </script> -->
            <?php
        }
        else
        {
            ?>
            <script>
                alert("Número de Tarjeta incorrecto, por favor ingrese de nuevo los datos.");
            </script>
            <?php

            $this->purchaseStep3();
        }
        
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
        if($value == "CONFIRMAR")
        {
            $purchase=$_SESSION["purchase"];
            $purchaseRepo = new PurchaseRepository();
            $purchaseRepo->Add($purchase);
            $_SESSION["idPurchase"] = $purchaseRepo->getLastPurchase();
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
            $ticket->setIdPurchase($_SESSION["idPurchase"]);
            $ticketsRepo = new TicketRepository();
            $ticketsRepo->Add($ticket);
        }

        //Se resta de la capacidad de asientos de la funcion la cantidad de tickets comprados
        $purchase = $_SESSION["purchase"];
        $showsRepo = new ShowRepository();
        $listadoShows = $showsRepo->getAll();
        foreach($listadoShows as $shows)
        {
            if($shows->getId() == $purchase->getIdShow())
            {
                $shows->setSeats($shows->getSeats() - $purchase->getQuantityTickets());
                $_SESSION["show"]=$shows;
            }
        }
        $showsRepo->edit($_SESSION["show"]);

        $this->clearSessionVariables();
    }

    public function clearSessionVariables()
    {
        unset($_SESSION["purchase"]);
        unset($_SESSION["idMovieSearch"]);
        unset($_SESSION["idCinema"]);
        unset($_SESSION["avaiableSeats"]);
        unset($_SESSION["creditCard"]);
        unset($_SESSION["ticketPrice"]);
        unset($_SESSION["idPurchase"]);
        unset($_SESSION["nameMovieTheater"]);
        unset($_SESSION["show"]);
        unset($_SESSION["checkCreditCard"]);
    }


    public function checkCreditCardNumber($number)
    {
        $creditCardsRepo = new CreditCardRepository();
        $listadoCC = $creditCardsRepo->getAll();

        foreach($listadoCC as $cc)
        {
            if($cc->getNumber() == $number)
            {
                $_SESSION["checkCreditCard"] = true;
            }
        }
    }

}