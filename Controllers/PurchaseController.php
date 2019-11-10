<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;

class PurchaseController
{


    public function purchase()
    {
        require_once(VIEWS_PATH . "purchase.php");
    }

    public function showCart()
    {
        require_once(VIEWS_PATH . "shoppingCart.php");
    }

    public function ticketPurchase($idMovie, $quantity, $date)
    {
        echo $idMovie . " Movie <br>";
        echo $quantity . " Cantidad <br>";
        echo $date . " Dia <br>";
    }

    public function cartPurchase()
    {
        echo "En proceso de desarrollo.";
    }
}