<?php namespace Controllers;

use DAOJson\MovieTheaterRepository as MovieTheaterRepository;
use Models\MovieTheater as MovieTheater;

class MovieTheaterJuanController{

    public function __construct()
    {

    }

    public function createMovieTheater($name, $address, $ticketPrice, $cinemas = array(), $moviechecked = array())
    {
        $add = true;
        $movieTheaterRepo = new MovieTheaterRepository();
       foreach($movieTheaterRepo->getAll() as $values){
           if($values->getName() == $name){
               $add=false;
           }
        } 

        if($add){  

        $movieTheater = new MovieTheater();
        $movieTheater->setId($this->getNextId());
        $movieTheater->setName($name);
        $movieTheater->setAddress($address);
        $movieTheater->setTicketPrice($ticketPrice);
        $movieTheater->setCinemas($cinemas);
        $movieTheater->setBillBoard($moviechecked);
          
        $movieTheaterRepo->Add($movieTheater);

        require_once(VIEWS_PATH . "index.php");
        }

        else
        {   
            echo "No se ha podido registrar el cine por name repetido." . "<br>";
            
        }

    }


    public function modifyUser($firstname, $lastname, $email, $username, $password)
    {
       
        
        $newUser = new User();
        $newUser->setId($_SESSION['loggedUser']->getId());
        $newUser->setFirstname($firstname);
        $newUser->setLastname($lastname);
        $newUser->setEmail($email);
        $newUser->setUsername($username);
        $newUser->setPassword($password);
         $userList = new UserRepository();
        $userList->edit($newUser);
        $this->logOut();
      // require_once(VIEWS_PATH . "profile.php");
    }

    public function modifyMovieTheater($id, $status, $name, $address, $ticketPrice){

        $newMT = new MovieTheater();
        $newMT->setId($id);
        $newMT->setStatus($status);
        $newMT->setName($name);
        $newMT->setAddress($address);
        $newMT->setTicketPrice($ticketPrice);
        $movieTheaterRepo = new MovieTheaterRepository();
        $movieTheaterRepo->edit($newMT);
     }
}
        
