<?php namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;
use Controllers\UserController as UserController;

class PurchaseController
{


    public function purchase()
    {
        $userControl = new UserController();
        $movieRepo = new MovieRepository();
        $listado=$movieRepo->getNowPlayingMovies();
        require_once(VIEWS_PATH . "purchase.php");
    }

    public function showCart()
    {
        $userControl = new UserController();
        $showRepo = new ShowRepository();
        $listado = $showRepo->getAll();
        require_once(VIEWS_PATH . "shoppingCart.php");
    }

    public function ticketPurchase($id, $quant, $dt)
    {
       $idMovie=$id;
       $quantity=$quant;
       $date=$dt;
       $this->showCart();
    }

    public function cartPurchase($id, $desc)
    {
        //vista donde se incluye valor total de la compra con/sin descuentos
        //elegir metodo de pago, ingresar datos de la tarjeta, chequear datos del usuario
        $idShow=$id;
        $discount=$desc;
        
    }

    public function confirmPurchase()
    {
        require_once(VIEWS_PATH . "confirmPurchase.php");
    }
}