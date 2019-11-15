<?php namespace Controllers;

use DAO\PurchaseRepository as PurchaseRepository;
use DAO\TicketRepository as TicketRepository;
use DAO\CreditCardRepository as CreditCardRepository;
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