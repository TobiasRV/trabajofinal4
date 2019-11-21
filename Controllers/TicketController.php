<?php namespace Controllers;

//DAO BD
use DAO\PurchaseRepository as PurchaseRepository;
use DAO\TicketRepository as TicketRepository;
use DAO\CreditCardRepository as CreditCardRepository;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use DAO\UserRepository as UserRepository;
//END DAO BD

//DAO JSON
// use DAOJson\PurchaseRepository as PurchaseRepository;
// use DAOJson\TicketRepository as TicketRepository;
// use DAOJson\CreditCardRepository as CreditCardRepository;
// use DAOJson\MovieDAO as MovieRepository;
// use DAOJson\ShowDAO as ShowRepository;
// use DAOJson\UserRepository as UserRepository;
//END DAO JSON

use Controllers\UserController as UserController;



class TicketController
{

   public function showTickets()
   {
        $userControl = new UserController();

        $result = array ();

        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();
        
        
        $listadoT = $this->getTicketsByIdUser($_SESSION["loggedUser"]->getId());

        if ($userControl->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 1) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navAdmin.php");
                include_once(VIEWS_PATH . "myTickets.php");
            } 
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    include_once(VIEWS_PATH . "myTickets.php");
                }
            }
        } 
        else 
        {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "index.php");
        }
    }

   public function searchTickets($date = null,$movie = null)
    {
        if($date != null)
        {
            $date = str_replace('/', '-', $date );
            $date = date("Y-m-d", strtotime($date));
        }

        if($movie != null && $date != null)
        {
            $listadoT = $this->getTicketsByMovieAndDate($movie, $date);
        }
        else
        {
            if($movie != null)
            {
                $listadoT = $this->getTicketsByMovie($movie);
            }
            else
            {
                if($date != null)
                {
                    $listadoT = $this->getTicketsByDate($date);
                }
                else
                {
                    $listadoT = $this->getTicketsByIdUser($_SESSION["loggedUser"]->getId());
                }
            }
        }


        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();
        
        $userControl = new UserController();

        if ($userControl->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 1) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navAdmin.php");
                include_once(VIEWS_PATH . "myTickets.php");
            } 
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    include_once(VIEWS_PATH . "myTickets.php");
                }
            }
        } 
        else 
        {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "index.php");
        }
    }

    public function getTicketsByMovie($movie)
    {
        $listadoT = $this->getTicketsByIdUser($_SESSION["loggedUser"]->getId());
        $result = array();

        if($listadoT != null)
        {
            if($movie != null)
            {
                $purchasesRepo = new PurchaseRepository();
                $listadoP = $purchasesRepo->getAll();
                $showsRepo = new ShowRepository();
                $listadoS = $showsRepo->getAll();
                $moviesRepo = new MovieRepository();
                $listadoM = $moviesRepo->getAll();

                if(! is_array($listadoP))
                {
                    $aux = $listadoP;
                    $listadoP = array();
                    array_push($listadoP,$aux);
                }
                foreach($listadoP as $purchase)
                {
                    if(! is_array($listadoS))
                    {
                        $aux = $listadoS;
                        $listadoS = array();
                        array_push($listadoS,$aux);
                    }
                    foreach($listadoS as $show)
                    {
                        if(! is_array($listadoT))
                        {
                            $aux = $listadoT;
                            $listadoT = array();
                            array_push($listadoT,$aux);
                        }
                        foreach($listadoT as $ticket)
                        {
                            if($ticket->getIdPurchase() == $purchase->getIdPurchase())
                            {
                                if($purchase->getIdShow() == $show->getId())
                                {
                                    if($show->getIdMovie() == $movie)
                                    {
                                        array_push($result, $ticket);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                $result = $listadoT;
            }
        }

        return $result;
    }

    public function getTicketsByDate($date)
    {
        $listadoT = $this->getTicketsByIdUser($_SESSION["loggedUser"]->getId());
        $result = array ();

        if($date != null)
        {
            $purchasesRepo = new PurchaseRepository();
            $listadoP = $purchasesRepo->getAll();
            if($listadoP != false)
            {
                if(! is_array($listadoP))
                {
                    $aux = $listadoP;
                    $listadoP = array();
                    array_push($listadoP,$aux);
                }
                foreach($listadoP as $purchase)
                {
                    if(! is_array($listadoT))
                    {
                        $aux = $listadoT;
                        $listadoT = array();
                        array_push($listadoT,$aux);
                    }  
                    foreach($listadoT as $ticket)
                    {
                        if($ticket->getIdPurchase() == $purchase->getIdPurchase())
                        {
                            if($purchase->getPurchaseDate() == $date)
                            {
                                array_push($result, $ticket);
                            }
                        }
                    }
                }
            }
        }
        else
        {
            $result = $listadoT;
        }
        
        return $result;
    }

    public function getTicketsByMovieAndDate($movie, $date)
    {
        $result = array ();
        $purchasesRepo = new PurchaseRepository();
        $listadoP = $purchasesRepo->getAll();
        $showsRepo = new ShowRepository();
        $listadoS = $showsRepo->getAll();

        $listadoT = $this->getTicketsByIdUser($_SESSION["loggedUser"]->getId());

        if($listadoP != false)
        {
            if(! is_array($listadoP))
            {
                $aux = $listadoP;
                $listadoP = array();
                array_push($listadoP,$aux);
            }
            foreach($listadoP as $purchase)
            {
                if(! is_array($listadoS))
                {
                    $aux = $listadoS;
                    $listadoS = array();
                    array_push($listadoS,$aux);
                }
                foreach($listadoS as $show)
                {
                    if(! is_array($listadoT))
                    {
                        $aux = $listadoT;
                        $listadoT = array();
                        array_push($listadoT,$aux);
                    }
                    foreach($listadoT as $ticket)
                    {
                        if($ticket->getIdPurchase() == $purchase->getIdPurchase() && $purchase->getPurchaseDate() == $date)
                        {
                            if($purchase->getIdShow() == $show->getId())
                            {
                                if($show->getIdMovie() == $movie)
                                {
                                    array_push($result, $ticket);
                                }
                            }
                        }
                    }
                        
                }
            }
        }

        return $result;
    }



    public function getTicketsByIdUser($idUser)
    {
        $creditCardsRepo = new CreditCardRepository();
        $purchasesRepo = new PurchaseRepository();
        $ticketsRepo = new TicketRepository();

        $listadoCC = $creditCardsRepo->getCreditCardsByIdUser($idUser);
        $listadoP = $purchasesRepo->getAll();
        $listadoT = $ticketsRepo->getAll();
        $result = array();

        if($listadoCC != null)
        {
            if(! is_array($listadoCC))
            {
                $aux = $listadoCC;
                $listadoCC = array();
                array_push($listadoCC,$aux);
            }
            foreach($listadoCC as $creditCard)
            {
                if($listadoP != null)
                {
                    if(! is_array($listadoP))
                    {
                        $aux = $listadoP;
                        $listadoP = array();
                        array_push($listadoP,$aux);
                    }
                    foreach($listadoP as $purchase)
                    {
                        if($creditCard->getId() == $purchase->getIdCreditCard())
                        {
                            if($listadoT != null)
                            {
                                if(! is_array($listadoT))
                                {
                                    $aux = $listadoT;
                                    $listadoT = array();
                                    array_push($listadoT,$aux);
                                }
                                foreach($listadoT as $ticket)
                                {
                                    if($purchase->getIdPurchase() == $ticket->getIdPurchase())
                                    {
                                        array_push($result, $ticket);
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }

        return $result;
    }


//end of class    
}