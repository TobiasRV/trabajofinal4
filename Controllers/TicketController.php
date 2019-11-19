<?php namespace Controllers;

//DAO BD
// use DAO\PurchaseRepository as PurchaseRepository;
// use DAO\TicketRepository as TicketRepository;
// use DAO\CreditCardRepository as CreditCardRepository;
// use DAO\MovieRepository as MovieRepository;
// use DAO\ShowRepository as ShowRepository;
// use DAO\UserRepository as UserRepository;
//END DAO BD

//DAO JSON
use DAOJson\PurchaseRepository as PurchaseRepository;
use DAOJson\TicketRepository as TicketRepository;
use DAOJson\CreditCardRepository as CreditCardRepository;
use DAOJson\MovieDAO as MovieRepository;
use DAOJson\ShowDAO as ShowRepository;
use DAOJson\UserRepository as UserRepository;
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
        $usersRepo = new UserRepository();
        $creditCardsRepo = new CreditCardRepository();
        $listadoCC = $creditCardsRepo->getAll();
        $purchasesRepo = new PurchaseRepository();
        $listadoP = $purchasesRepo->getAll();
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();

        $result = $usersRepo->getCreditCardsById($listadoCC);
        $result = $creditCardsRepo->getPurchasesById($listadoP, $result);
        $result = $purchasesRepo->getTicketsById($listadoT, $result);

        $listadoT = $result;

       require_once(VIEWS_PATH . "myTickets.php");
   }

   public function searchTickets($movie = null, $date = null)
    {
        if($movie != null && $date != null)
        {
            $result = array ();
            $usersRepo = new UserRepository();
            $creditCardsRepo = new CreditCardRepository();
            $listadoCC = $creditCardsRepo->getAll();
            $purchasesRepo = new PurchaseRepository();
            $listadoP = $purchasesRepo->getAll();
            $ticketsRepo = new TicketRepository();
            $listadoT = $ticketsRepo->getAll();

            $result = $usersRepo->getCreditCardsById($listadoCC);
            $result = $creditCardsRepo->getPurchasesById($listadoP, $result);
            $result = $purchasesRepo->getTicketsById($listadoT, $result);

            $listadoT = $this->getTicketsByMovieAndDate($movie, $date, $result);
            
        }
        else
        {
            if($movie != null)
            {
                $result = array ();
                $usersRepo = new UserRepository();
                $creditCardsRepo = new CreditCardRepository();
                $listadoCC = $creditCardsRepo->getAll();
                $purchasesRepo = new PurchaseRepository();
                $listadoP = $purchasesRepo->getAll();
                $ticketsRepo = new TicketRepository();
                $listadoT = $ticketsRepo->getAll();

                $result = $usersRepo->getCreditCardsById($listadoCC);
                $result = $creditCardsRepo->getPurchasesById($listadoP, $result);
                $result = $purchasesRepo->getTicketsById($listadoT, $result);
                $listadoT = $this->getTicketsByMovie($movie, $result);
            }
            else
            {
                if($date != null)
                {
                    $result = array ();
                    $usersRepo = new UserRepository();
                    $creditCardsRepo = new CreditCardRepository();
                    $listadoCC = $creditCardsRepo->getAll();
                    $purchasesRepo = new PurchaseRepository();
                    $listadoP = $purchasesRepo->getAll();
                    $ticketsRepo = new TicketRepository();
                    $listadoT = $ticketsRepo->getAll();

                    $result = $usersRepo->getCreditCardsById($listadoCC);
                    $result = $creditCardsRepo->getPurchasesById($listadoP, $result);
                    $result = $purchasesRepo->getTicketsById($listadoT, $result);
                    $listadoT = $this->getTicketsByDate($date, $result);
                }
                else
                {
                    $result = array ();
                    $usersRepo = new UserRepository();
                    $creditCardsRepo = new CreditCardRepository();
                    $listadoCC = $creditCardsRepo->getAll();
                    $purchasesRepo = new PurchaseRepository();
                    $listadoP = $purchasesRepo->getAll();
                    $ticketsRepo = new TicketRepository();
                    $listadoT = $ticketsRepo->getAll();

                    $result = $usersRepo->getCreditCardsById($listadoCC);
                    $result = $creditCardsRepo->getPurchasesById($listadoP, $result);
                    $result = $purchasesRepo->getTicketsById($listadoT, $result);

                    $listadoT = $result;
                }
            }
        }


        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();
        
        $userControl = new UserController();

        require_once(VIEWS_PATH . "myTickets.php");
    }

    public function getTicketsByMovie($movie, $listadoT)
    {
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
                                else
                                {
                                    if($listadoT->getIdPurchase() == $purchase->getIdPurchase())
                                        {
                                            if($purchase->getIdShow == $show->getId())
                                            {
                                                if($show->getIdMovie() == $movie)
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
                                                if($listadoS->getIdMovie() == $movie)
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
                                                if($listadoS->getIdMovie() == $movie)
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
                    if(is_array($listadoS))
                    {
                        foreach($listadoS as $show)
                        {
                            if(is_array($listadoT))
                            {
                                foreach($listadoT as $ticket)
                                {
                                    if($ticket->getIdPurchase() == $listadoP->getIdPurchase())
                                    {
                                        if($listadoP->getIdShow() == $show->getId())
                                        {
                                            if($show->getIdMovie() == $movie)
                                            {
                                                array_push($result, $ticket);
                                            }
                                        }
                                    }
                                }

                            }
                            else
                            {
                                if($listadoT->getIdPurchase() == $listadoP->getIdPurchase())
                                {
                                    if($listadoP->getIdShow() == $show->getId())
                                    {
                                        if($show->getIdMovie() == $movie)
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
                                if($ticket->getIdPurchase() == $listadoP->getIdPurchase())
                                {
                                    if($listadoP->getIdShow() == $listadoS->getId())
                                    {
                                        if($listadoS->getIdMovie() == $movie)
                                        {
                                            array_push($result, $ticket);
                                        }
                                    }
                                }
                            }

                        }
                        else
                        {
                            if($listadoT->getIdPurchase() == $listadoP->getIdPurchase())
                            {
                                if($listadoP->getIdShow() == $listadoS->getId())
                                {
                                    if($listadoS->getIdMovie() == $movie)
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
                $result = $listadoT;
            }
        }

        return $result;
    }

    public function getTicketsByDate($date, $listadoT)
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

    public function getTicketsByMovieAndDate($movie, $date, $listadoT)
    {
        $result = array();

        if($listadoT != null)
        {
            if($movie != null && $date != null)
            {
                $result = array ();
                $usersRepo = new UserRepository();
                $creditCardsRepo = new CreditCardRepository();
                $listadoCC = $creditCardsRepo->getAll();
                $purchasesRepo = new PurchaseRepository();
                $listadoP = $purchasesRepo->getAll();
                $ticketsRepo = new TicketRepository();
                $listadoT = $ticketsRepo->getAll();

                $result = $usersRepo->getCreditCardsById($listadoCC);
                $listadoCC = $result;
                $result = $creditCardsRepo->getPurchasesById($listadoP, $listadoCC);
                $listadoP = $result;
                $result = $purchasesRepo->getTicketsById($listadoT, $listadoP);
                $listadoT = $result;

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
                                        if($ticket->getIdPurchase() == $purchase->getIdPurchase() && $purchase->getPurchaseDate() == $date)
                                        {
                                            if($purchase->getIdShow() == $show->getId())
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
                                    if($listadoT->getIdPurchase() == $purchase->getIdPurchase() && $purchase->getPurchaseDate() == $date)
                                        {
                                            if($purchase->getIdShow() == $show->getId())
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
                                        if($ticket->getIdPurchase() == $purchase->getIdPurchase() && $purchase->getPurchaseDate() == $date)
                                        {
                                            if($purchase->getIdShow() == $listadoS->getId())
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
                                    if($listadoT->getIdPurchase() == $purchase->getIdPurchase() && $purchase->getPurchaseDate() == $date)
                                        {
                                            if($purchase->getIdShow() == $listadoS->getId())
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
                    if(is_array($listadoS))
                    {
                        foreach($listadoS as $show)
                        {
                            if(is_array($listadoT))
                            {
                                foreach($listadoT as $ticket)
                                {
                                    if($ticket->getIdPurchase() == $listadoP->getIdPurchase() && $listadoP->getPurchaseDate() == $date)
                                    {
                                        if($listadoP->getIdShow() == $show->getId())
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
                                if($listadoT->getIdPurchase() == $listadoP->getIdPurchase() && $listadoP->getPurchaseDate() == $date)
                                {
                                    if($listadoP->getIdShow() == $show->getId())
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
                                if($ticket->getIdPurchase() == $listadoP->getIdPurchase() && $listadoP->getPurchaseDate() == $date)
                                {
                                    if($listadoP->getIdShow() == $listadoS->getId())
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
                            if($listadoT->getIdPurchase() == $listadoP->getIdPurchase() && $listadoP->getPurchaseDate() == $date)
                            {
                                if($listadoP->getIdShow() == $listadoS->getId())
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
                $result = $listadoT;
            }
        }

        return $result;
    }
}