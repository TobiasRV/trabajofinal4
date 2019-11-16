<?php namespace DAOJson;

use Models\CreditCard as CreditCard;
use DAO\IRepository as IRepository;

class CreditCardRepository implements IRepository
{
    private $creditCardList = array ();

    public function __constructor(){

    }

    public function Add($creditCard){ 

        $this->retrieveData();
    
        if (empty($this->creditCardList)) {
            $newId = 1;
        } else {
            $lastElement = end($this->creditCardList);
            $newId = $lastElement->getId() + 1;
        }
        $creditCard->setId($newId);

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
            $valuesArray["id"] = $creditCard->getId();
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
                
                $creditCard->setId($valuesArray["id"]);
                $creditCard->setCompany($valuesArray["company"]);
                $creditCard->setNumber($valuesArray["number"]);
                $creditCard->setIdUser($valuesArray["idUser"]);
              

                array_push($this->creditCardList, $creditCard);
            }
        }
    }

    public function edit($creditCard)
    {

    //Supongo que en algun momento tendremos que hacer esta

    }

    public function delete($id) 
    {   
    
        //no pusimos status en credit card asi que sera fisica cuando la hagamos XD
        
    }


  //funciones extras

    public function getCreditCards($id_user)
    {
        $this->retrieveData();
        $aux = array();
        $flag = false;

        foreach($this->creditCardList as $values)
        {
            if($id_user == $values->getIdUser()){
                array_push($aux,$values);   
            $flag = true;         
        }
        }

        if($flag){
            return $aux;
        }
        else{
            return $flag;
        }
    }

    public function getId($creditCard)
    {
      $this->retrieveData();
      foreach($this->creditCardList as $values)
      {
           if($values->getNumber() == $creditCard->getNumber())
           {
                $creditCard->setId($values->getId());
           }
      }

      return $creditCard;
    }
    
}
