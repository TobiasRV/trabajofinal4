<?php namespace Models;

class Purchase
{
    private $idPurchase;
    private $purchaseDate;
    private $quantityTickets;
    private $total;
    private $discount;
    private $idShow;
    private $idCreditCard;

    public function __construct()
    {
        
    }

    public function getIdPurchase()
    {
        return $this->id;
    }

    public function setIdPurchase($idPurchase)
    {
        $this->idPurchase=$idPurchase;
    }
   

    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate=$purchaseDate;
    }
    
    public function getQuantityTickets()
    {
        return $this->quantityTickets;
    }
    public function setQuantityTickets($quantityTickets)
    {
        $this->quantityTickets=$quantityTickets;
    }
    
    public function getTotal()
    {
        return $this->total;
    }
    public function setTotal($total)
    {
        $this->total=$total;
    }

    
    public function getDiscount()
    {
        return $this->discount;
    }
    public function setDiscount($discount)
    {
        $this->discount=$discount;
    }
    
    public function getEmailUser()
    {
        return $this->emailUser;
    }
    public function setEmailUser($emailUser)
    {
        $this->emailUser=$emailUser;
    }

    public function getIdShow()
    {
        return $this->idShow;
    }
    public function setIdShow($idShow)
    {
        $this->idShow=$idShow;
    }

    public function getIdCreditCard()
    {
        return $this->idCreditCard;
    }
    public function setIdCreditCard($idCreditCard)
    {
        $this->idCreditCard=$idCreditCard;
    }

}