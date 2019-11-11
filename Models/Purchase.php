<?php namespace Models;

class Purchase
{
    private $idPurchase;
    private $purchaseDate;
    private $quantityTickets;
    private $total;
    private $discount;
    private $emailUser;
    private $movieId; //show ya tiene movie_id
    private $showId;

    public function __construct($id=null, $purchaseDate=null, $quantityTickets=null, $total=null, $discount=null, $emailUser=null, $movieId=null, $showId=null)
    {
        
    }

    public function getIdPurchase()
    {
        return $this->id;
    }

    public function setIdPurchase()
    {
        $this->idPurchase=$idPurchase;
    }
    
    public function getMovieId()
    {
        return $this->movieId;
    }

    public function setMovieId()
    {
        $this->movieId=$movieId;
    }

    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }
    
    public function getQuantityTickets()
    {
        return $this->quantityTickets;
    }
    
    public function getTotal()
    {
        return $this->total;
    }
    
    public function getDiscount()
    {
        return $this->discount;
    }
    
    public function getEmailUser()
    {
        return $this->emailUser;
    }
    

    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate=$purchaseDate;
    }

    public function setQuantityTickets($quantityTickets)
    {
        $this->quantityTickets=$quantityTickets;
    }

    public function setTotal($total)
    {
        $this->total=$total;
    }

    public function setDiscount($discount)
    {
        $this->discount=$discount;
    }

    public function setEmailUser($emailUser)
    {
        $this->emailUser=$emailUser;
    }

    public function getEmailUser()
    {
        return $this->emailUser;
    }
    
    public function getEmailUser()
    {
        return $this->emailUser;
    }

    public function setEmailUser($emailUser)
    {
        $this->emailUser=$emailUser;
    }

    public function setEmailUser($emailUser)
    {
        $this->emailUser=$emailUser;
    }
}