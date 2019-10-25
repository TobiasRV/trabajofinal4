<?php namespace DAO;

use Models\User as User;
use DAO\IRepository as IRepository;

class UserRepository implements IRepository
{
    private $userList = array ();
    
    public function __constructor(){

    }

    public function Add($user){ //falta completar

        // session_start();

        // $add = true;

        // if(isset($_SESSION['users'])){

        // $userList = $_SESSION['users'];

        // foreach($userList as $key => $value){

        //     if($object->getUser() == $value->getUser()){

        //         $add = false;

        //     }
        // }
        // }
        // if($add){

        //     $userList[] = $user;
        //     $_SESSION['users'] = $userList;

        // }

        $this->getAll();

        array_push($this->userList, $user);

        $this->saveData();
    }

    public function getAll(){

        $this->retrieveData();

        return $this->userList;
    }

    public function saveData(){

        $arrayToJson = array();

        foreach($this->userList as $user){

            $valuesArray["userName"] = $user->getUserName();
            $valuesArray["password"] = $user->getPassword();
            $valuesArray["email"] = $user->getEmail();
            $valuesArray["firstname"] = $user->getFirstname();
            $valuesArray["lastname"] = $user->getLastname();
            $valuesArray["permissions"] = $user->getPermissions();
            $valuesArray["tickets"] = $user->getTickets();
           

            array_push($arrayToJson, $valuesArray);
        }

        $jsonContent = json_enconde($arrayToJson, JSON_PRETTY_PRINT);

        file_put_contents('Data/users.json', $jsonContent);
    }


    public function retrieveData(){

        $this->userList = array ();
       
        if(file_exists('Data/users.json')){

            $jsonContent = file_get_contents('Data/users.json');
    
            $arrayToDecode= ($jsonContent) ? json_decode($jsonContent, true) : array();
         
            foreach($arrayToDecode as $valuesArray){

                $user = new User();
                
                $user->setUserName($valuesArray["userName"]);
                $user->setPassword($valuesArray["password"]);
                $user->setEmail($valuesArray["email"]);
                $user->setFirstname($valuesArray["firstname"]);
                $user->setLastname($valuesArray["lastname"]);
                $user->setPermissions($valuesArray["permissions"]);
                $user->setTickets($valuesArray["tickets"]);
              

                //$user->toString();
                array_push($this->userList, $user);
            }
        }
    }

    public function toString(){

        $i=0;
        for($i=0;$i<sizeof($this->userList);$i++){

        echo $this->userList[$i]->getUserName();          

        }

    }
    
    public function userNameAt($i)
    {

        return $this->userList[$i]->getUserName();

    }

    public function passwordAt($i)
    {
        return $this->userList[$i]->getPassword();

    }
    // private $userName;
    // private $password;
    // private $email;
    // private $firstname;
    // private $lastname;
    // private $permissions;
    // private $tickets = array();

}
