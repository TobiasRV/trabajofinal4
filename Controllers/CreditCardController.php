<?php

namespace Controllers;

//DAO BD
use DAO\CreditCardRepository as CreditCardRepository;
//END DAO BD

//DAO JSON
//use DAOJson\CreditCardRepository as CreditCardRepository;
//END DAO JSON

use Models\CreditCard as CreditCard;
use Controllers\UserController as UserController;

use Exception;
use PDOException;


class CreditCardController
{
    

    public function showCreditCards()
    {
        $creditcardsRepo = new CreditCardRepository();
        try {
            $listadoCC = $creditcardsRepo->getAll();
            $userControl = new UserController();
            if ($listadoCC != false) {
                if (!is_array($listadoCC)) {
                    $aux = $listadoCC;
                    $listadoCC = array();
                    array_push($listadoCC, $aux);
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {
            if ($userControl->checkSession() != false) {
                if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navAdmin.php");
                    include_once(VIEWS_PATH . "myCreditCards.php");
                } else {
                    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navClient.php");
                        include_once(VIEWS_PATH . "myCreditCards.php");
                    }
                }
            } else {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "nav.php");
                include_once(VIEWS_PATH . "index.php");
            }
        }
    }

    public function changeStatus($id)
    {
        $creditcardsRepo = new CreditCardRepository();
        try {

            $listadoCC = $creditcardsRepo->getAll();
            if ($listadoCC != false) {
                if (!is_array($listadoCC)) {
                    $aux = $listadoCC;
                    $listadoCC = array();
                    array_push($listadoCC, $aux);
                }
                foreach ($listadoCC as $cc) {
                    if ($cc->getId() == $id) {
                        if ($cc->getStatus() == true) {
                            $cc->setStatus(false);
                            $creditcardsRepo->edit($cc);
                        } else {
                            $cc->setStatus(true);
                            $creditcardsRepo->edit($cc);
                        }
                    }
                }
            }
            $this->showCreditCards();
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function addCreditCard($company, $number)
    {
        $newCreditCard = new CreditCard();
        $newCreditCard->setNumber($number);
        $newCreditCard->setCompany($company);
        $newCreditCard->setIdUser($_SESSION["loggedUser"]->getId());
        $creditCardRepo = new CreditCardRepository();
        try {
            $creditCardRepo->Add($newCreditCard);
            $this->showCreditCards();
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }
}
