<?php namespace Controllers;

//DAO BD
// use DAO\CreditCardRepository as CreditCardRepository;
//END DAO BD

//DAO JSON
use DAOJson\CreditCardRepository as CreditCardRepository;
//END DAO JSON

use Controllers\UserController as UserController;

class CreditCardController
{

   public function showCreditCards()
   {
       $creditcardsRepo = new CreditCardRepository();
       $listadoCC = $creditcardsRepo->getAll();
       $userControl = new UserController();
       require_once(VIEWS_PATH . "myCreditCards.php");
   }

   public function changeStatus($id)
   {
        $creditcardsRepo = new CreditCardRepository();
        $listadoCC = $creditcardsRepo->getAll();
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
        //var_dump($_POST);
        $this->showCreditCards();
   }


}