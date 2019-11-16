<?php namespace Controllers;

//DAO BD
// use DAO\PurchaseRepository as PurchaseRepository;
// use DAO\TicketRepository as TicketRepository;
// use DAO\CreditCardRepository as CreditCardRepository;
//END DAO BD

//DAO JSON
use DAOJson\PurchaseRepository as PurchaseRepository;
use DAOJson\TicketRepository as TicketRepository;
use DAOJson\CreditCardRepository as CreditCardRepository;
//END DAO JSON

use Controllers\UserController as UserController;

class TicketController
{

   public function showTickets()
   {
       $ticketsRepo = new TicketRepository();
       $listadoT = $ticketsRepo->getAll();
       $purchasesRepo = new PurchaseRepository();
       $listadoP = $purchasesRepo->getAll();
       $creditcardsRepo = new CreditCardRepository();
       $listadoCC = $creditcardsRepo->getAll();
       $userControl = new UserController();
       require_once(VIEWS_PATH . "myTickets.php");
   }


}