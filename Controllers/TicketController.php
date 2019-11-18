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
// use DAOJson\ShowRepository as ShowRepository;
// use DAOJson\UserRepository as UserRepository;
//END DAO JSON

use Controllers\UserController as UserController;

class TicketController
{

   public function showTickets($movie = null, $date = null, $listadoTickets = null)
   {
        $userControl = new UserController();

        $result = array ();

        $usersRepo = new UserRepository();
        $creditCardsRepo = new CreditCardRepository();
        $listadoCC = $creditCardsRepo->getAll();
        $purchasesRepo = new PurchaseRepository();
        $listadoP = $purchasesRepo->getAll();
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();

        if($listadoTickets == null)
        {
            $result = $usersRepo->getCreditCardsById($listadoCC);
            $result = $creditCardsRepo->getPurchasesById($listadoP, $result);
            $result = $purchasesRepo->getTicketsById($listadoT, $result);

            $listadoT = $result;
        }
        else
        {
            $listadoT = $listadoTickets;
        }

       require_once(VIEWS_PATH . "myTickets.php");
   }

   public function searchTickets($movie = null, $date = null, $listadoT = null)
    {
        $result = array();
        $ticketList = array();

        $ticketList = $this->getTicketsByDate($date);
        if ($movie != null) 
        {
            $result = $this->getTicketsByMovie($ticketList, $movie);
        } 
        else 
        {
            $result = $ticketList;
        }

        return $result;
    }

    public function getTicketsByMovie($movie)
    {
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();
        $result = array();

        if($listadoT != null)
        {
            if($movie != null)
            {
                $purchasesRepo = new PurchaseRepository();
                $listadoP = $purchasesRepo->getAll();
                $showsRepo = new ShowRepository();
                $listadoS = $showsRepo->getAll();
                $moviesRepo = new MoviesRepository();
                $listadoM = $moviesRepo->getAll();

                if(is_array($listadoP))
                {
                    foreach($listadoP as $purchase)
                    {
                        if(is_array($listadoS))
                        {
                            foreach($listadoS as $show)
                            {
                                if(is_array($listadoT))
                                {
                                    foreach($listadoT as $ticket)
                                    {
                                        if($ticket->getIdPurchase() == $purchase->getIdPurchase())
                                        {
                                            if($purchase->getIdShow == $show->getId())
                                            {
                                                if($show->getIdMovie() == $movie->getIdMovie())
                                                {
                                                    array_push($result, $ticket);
                                                }
                                            }
                                        }
                                    }

                                }
                                else
                                {
                                    if($listadoT->getIdPurchase() == $purchase->getIdPurchase())
                                        {
                                            if($purchase->getIdShow == $show->getId())
                                            {
                                                if($show->getIdMovie() == $movie->getIdMovie())
                                                {
                                                    array_push($result, $listadoT);
                                                }
                                            }
                                        }
                                }
                            }
                        }
                        else
                        {
                            if(is_array($listadoT))
                                {
                                    foreach($listadoT as $ticket)
                                    {
                                        if($ticket->getIdPurchase() == $purchase->getIdPurchase())
                                        {
                                            if($purchase->getIdShow == $listadoS->getId())
                                            {
                                                if($listadoS->getIdMovie() == $movie->getIdMovie())
                                                {
                                                    array_push($result, $ticket);
                                                }
                                            }
                                        }
                                    }

                                }
                                else
                                {
                                    if($listadoT->getIdPurchase() == $purchase->getIdPurchase())
                                        {
                                            if($purchase->getIdShow == $listadoS->getId())
                                            {
                                                if($listadoS->getIdMovie() == $movie->getIdMovie())
                                                {
                                                    array_push($result, $listadoT);
                                                }
                                            }
                                        }
                                }
                        }
                    }
                }
                else
                {

                }

            }
            else
            {
                $result = $listadoT;
            }
        }

        return $result;
    }

    public function getTicketsByDate($date = null)
    {
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();
        $result = array ();

        if($date != null)
        {
            $purchasesRepo = new PurchaseRepository();
            $listadoP = $purchasesRepo->getAll();

            if(is_array($listadoP))
            {
                foreach($listadoP as $purchase)
                {
                    if(is_array($listadoT))
                    {
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
                    else
                    {
                        if($listadoT->getIdPurchase() == $purchase->getIdPurchase())
                            {
                                if($purchase->getPurchaseDate() == $date)
                                {
                                    array_push($result, $listadoT);
                                }
                            }
                    }
                }
            }
            else
            {
                if(is_array($listadoT))
                {
                    foreach($listadoT as $ticket)
                    {
                        if($ticket->getIdPurchase() == $listadoP->getIdPurchase())
                        {
                            if($listadoP->getPurchaseDate() == $date)
                            {
                                array_push($result, $ticket);
                            }
                        }
                    }
                }
                else
                {
                    if($listadoT->getIdPurchase() == $listadoP->getIdPurchase())
                    {
                        if($listadoP->getPurchaseDate() == $date)
                        {
                            array_push($result, $listadoT);
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
}