<?php namespace Models;

class CreditCard{

private $id;
private $company;
private $number;
private $expireDate;
private $securityCode;
private $firstnameOwner;
private $lastnameOwner;
private $dniOwner;


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

public function getNumber(){
    return $this->number;
}

public function setNumber($number){
    $this->number = $number;
}

public function getExpireDate(){
    return $this->expireDate;
}

public function setExpireDate($expireDate){
    $this->expireDate = $expireDate;
}

public function getSecurityCode(){
    return $this->securityCode;
}

public function setSecurityCode($securityCode){
    $this->securityCode = $securityCode;
}

public function getFirstnameOwner(){
    return $this->firstnameOwner;
}

public function setFirstnameOwner($firstnameOwner){
    $this->firstnameOwner = $firstnameOwner;
}

public function getLastnameOwner(){
    return $this->lastnameOwner;
}

public function setLastnameOwner($lastnameOwner){
    $this->lastnameOwner = $lastnameOwner;
}

public function getDniOwner(){
    return $this->dniOwner;
}

public function setDniOwner($dniOwner){
    $this->dniOwner = $dniOwner;
}

}