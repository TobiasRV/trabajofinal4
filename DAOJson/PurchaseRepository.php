<?php namespace DAOJson;

use Models\Purchase as Purchase;
use DAO\IRepository as IRepository;

class PurchaseRepository implements IRepository
{
    private $purchaseList = array ();

    public function __constructor(){

    }

    public function Add($purchase){ 

        $this->getAll();

        array_push($this->purchaseList, $purchase);

        $this->saveData();
    }

    public function read($id)
    {
        $this->retrieveData();
        $flag=false;
        $purchaseReturn = new Ticket();
        foreach($this->purchaseList as $p)
        {
            if(!$flag)
            {
                if($id==$p->getIdPurchase())
                {
                    $flag=true;
                    $purchaseReturn=$p;
                }
            }
        }
        return $purchaseReturn;
    }

    public function getAll(){

        $this->retrieveData();

        return $this->purchaseList;
    }

    public function saveData(){

        $arrayToJson = array();

        foreach($this->purchaseList as $purchase){

            //id?
            $valuesArray["purchaseDate"] = $purchase->getPurchaseDate();
            $valuesArray["quantityTickets"] = $purchase->getQuantityTickets();
            $valuesArray["total"] = $purchase->getTotal();
            $valuesArray["discount"] = $purchase->getDiscount();
            $valuesArray["idShow"] = $purchase->getIdShow();
            $valuesArray["idCreditCard"] = $purchase->getIdCreditCard();
           

            array_push($arrayToJson, $valuesArray);
        }

        $jsonContent = json_encode($arrayToJson, JSON_PRETTY_PRINT);

        file_put_contents('Data/purchases.json', $jsonContent);
    }


    public function retrieveData(){

        $this->purchaseList = array ();
       
        if(file_exists('Data/purchases.json')){

            $jsonContent = file_get_contents('Data/purchases.json');
    
            $arrayToDecode= ($jsonContent) ? json_decode($jsonContent, true) : array();
         
            foreach($arrayToDecode as $valuesArray){

                $purchase = new Purchase();
                
                //id?
                $purchase->setPurchaseDate($valuesArray["purchaseDate"]);
                $purchase->setQuantityTickets($valuesArray["quantityTickets"]);
                $purchase->setTotal($valuesArray["total"]);
                $purchase->setDiscount($valuesArray["discount"]);
                $purchase->setIdShow($valuesArray["idShow"]);
                $purchase->setIdCreditCard($valuesArray["idCreditCard"]);
              

                //$purchase->toString();
                array_push($this->purchaseList, $purchase);
            }
        }
    }

    public function edit($purchase) {

        //se supone que no podes editar una compra
      }


          
        public function delete($name) {
           //No nos pidieron reembolsos asi que queda asi por ahora
            }


    public function getLastPurchase()
    {

        $this->retrieveData();
        return end($this);
    }

}
