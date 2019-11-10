<?php namespace Controllers;

use Models\Ticket as Ticket;

class TicketController
{


    public function purchase()
    {
        require_once(VIEWS_PATH . "purchase.php");
    }

    public function showCart()
    {
        require_once(VIEWS_PATH . "shoppingCart.php");
    }

    public function ticketPurchase($date, $quantityTickets, $total, $discount, $emailUser)
    {
        echo "En proceso de desarrollo.";
    }

    public function cartPurchase()
    {
        echo "En proceso de desarrollo.";
    }
}