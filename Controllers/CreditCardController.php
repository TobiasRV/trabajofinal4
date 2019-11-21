<?php namespace Controllers;

//DAO BD
use DAO\CreditCardRepository as CreditCardRepository;
//END DAO BD

//DAO JSON
// use DAOJson\CreditCardRepository as CreditCardRepository;
//END DAO JSON

use Models\CreditCard as CreditCard;
use Controllers\UserController as UserController;

class CreditCardController
{

   public function showCreditCards()
   {
       $creditcardsRepo = new CreditCardRepository();
       $listadoCC = $creditcardsRepo->getAll();
       $userControl = new UserController();
       if($listadoCC != false)
       {
            if(! is_array($listadoCC))
            {
                $aux = $listadoCC;
                $listadoCC = array();
                array_push($listadoCC,$aux);
            }
        }

        if ($userControl->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 1) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navAdmin.php");
                include_once(VIEWS_PATH . "myCreditCards.php");
            } 
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    include_once(VIEWS_PATH . "myCreditCards.php");
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

   public function changeStatus($id)
   {
        $creditcardsRepo = new CreditCardRepository();
        $listadoCC = $creditcardsRepo->getAll();
        if($listadoCC != false){
        if(! is_array($listadoCC)){
            $aux = $listadoCC;
            $listadoCC = array();
            array_push($listadoCC,$aux);
        }
        foreach($listadoCC as $cc)
        {
            if($cc->getId() == $id)
            {
                if($cc->getStatus()==true)
                {
                    $cc->setStatus(false);
                    $creditcardsRepo->edit($cc);
                }
                else
                {
                    $cc->setStatus(true);
                    $creditcardsRepo->edit($cc);
                }
            }
        }
    }
        
        $this->showCreditCards();
   }

   public function addCreditCard($company, $number)
    {
        $newCreditCard = new CreditCard();
        $newCreditCard->setNumber($number);
        $newCreditCard->setCompany($company);
        $newCreditCard->setIdUser($_SESSION["loggedUser"]->getId());
        $creditCardRepo = new CreditCardRepository();
        $creditCardRepo->Add($newCreditCard);
        $this->showCreditCards();
    }


}