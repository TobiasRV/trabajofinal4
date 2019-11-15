<?php namespace DAOJson;

use Models\CreditCard as CreditCard;
use DAO\IRepository as IRepository;

class CreditCardRepository implements IRepository
{
    private $creditCardList = array ();

    public function __constructor(){

    }

    public function Add($creditCard){ 

        $this->getAll();

        array_push($this->creditCardList, $creditCard);

        $this->saveData();
    }

    public function read($id)
    {
        $this->retrieveData();
        $flag=false;
        $creditCardReturn = new CreditCard();
        foreach($this->creditCardList as $cc)
        {
            if(!$flag)
            {
                if($id==$cc->getId())
                {
                    $flag=true;
                    $creditCardReturn=$cc;
                }
            }
        }
        return $creditCardReturn;
    }

    public function getAll(){

        $this->retrieveData();

        return $this->creditCardList;
    }

    public function saveData(){

        $arrayToJson = array();

        foreach($this->creditCardList as $creditCard){

            //id?
            $valuesArray["company"] = $creditCard->getCompany();
            $valuesArray["number"] = $creditCard->getNumber();
            $valuesArray["idUser"] = $creditCard->getIdUser();
           

            array_push($arrayToJson, $valuesArray);
        }

        $jsonContent = json_encode($arrayToJson, JSON_PRETTY_PRINT);

        file_put_contents('Data/creditCards.json', $jsonContent);
    }


    public function retrieveData(){

        $this->creditCardList = array ();
       
        if(file_exists('Data/creditCards.json')){

            $jsonContent = file_get_contents('Data/creditCards.json');
    
            $arrayToDecode= ($jsonContent) ? json_decode($jsonContent, true) : array();
         
            foreach($arrayToDecode as $valuesArray){

                $creditCard = new CreditCard();
                
                //id?
                $creditCard->setCompany($valuesArray["company"]);
                $creditCard->setNumber($valuesArray["number"]);
                $creditCard->setIdUser($valuesArray["idUser"]);
              

                array_push($this->creditCardList, $creditCard);
            }
        }
    }

    public function edit($creditCard)
    {

        //se supone que no podes editar una compra

    }

    public function delete($id) 
    {
        
    }


  //funciones extras

    public function getCreditCards($id_user)
    {

    }

    public function getCompany($id_creditcard)
    {
        return $this->read($id_creditcard)->getCompany();
    }

    public function getId($creditCard)
    {

    }
    
}
