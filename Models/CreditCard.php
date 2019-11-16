<?php namespace Models;

class CreditCard{

private $id;
private $company;
private $number;
private $status;
private $idUser;


public function __construct($id = null,$company = null) {
    $this->id = $id;
    $this->company = $company;
    $this->status=true;
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

// public function getExpireDate(){
//     return $this->expireDate;
// }

// public function setExpireDate($expireDate){
//     $this->expireDate = $expireDate;
// }

// public function getSecurityCode(){
//     return $this->securityCode;
// }

// public function setSecurityCode($securityCode){
//     $this->securityCode = $securityCode;
// }

// public function getFirstnameOwner(){
//     return $this->firstnameOwner;
// }

// public function setFirstnameOwner($firstnameOwner){
//     $this->firstnameOwner = $firstnameOwner;
// }

// public function getLastnameOwner(){
//     return $this->lastnameOwner;
// }

// public function setLastnameOwner($lastnameOwner){
//     $this->lastnameOwner = $lastnameOwner;
// }

// public function getDniOwner(){
//     return $this->dniOwner;
// }

// public function setDniOwner($dniOwner){
//     $this->dniOwner = $dniOwner;
// }

public function getIdUser(){
    return $this->idUser;
}

public function setIdUser($idUser){
    $this->idUser = $idUser;
}

public function getStatus(){
    return $this->status;
}

public function setStatus($status){
    $this->status = $status;
}

}