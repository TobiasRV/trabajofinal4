<?php namespace Models;

class CreditCard{

private $id;
private $company;


public function __construct($id = null,$company = null) {
    $this->id = $id;
    $this->company = $company;
}


public function getId(){
    return $this->id;
}

public function setId($id){
    $this->id = $id;
}

public function getCompany(){
    return $this->company;
}

public function setCompany($company){
    $this->company = $company;
}

}