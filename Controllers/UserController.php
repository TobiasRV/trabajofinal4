<?php namespace Controllers;

use DAO\UserRepository as UserRepository;
use Models\User as User;

class UserController{

    public function signUpForm()
    {
        require_once(VIEWS_PATH . "signup.php");
    }

    public function signUp($username, $password, $firstname, $lastname, $email)
    {
            $add=true;
            $userList= new UserRepository();
            $userList->getAll();
            foreach($userList as $values){
                if($values->getEmail()==$email){
                    $add=false;
                }
            }
            if($add){
                $user= new User();
                $user->setUserName($username);
                $user->setPassword($password);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setEmail($email);
                $userList->Add($user);
                require_once(VIEWS_PATH . "index.php");
            }
    }

    public function logInForm()
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function logIn($email, $password)
    {

            $login=false;
            $userList = new UserRepository();
            $userList->getAll();
            foreach ($userList as $values) {
                if($values->getEmail()==$email && $values->getPassword()==$password){
                    $login=true;
                }
            }
            if($login){
                require_once(VIEWS_PATH . "index.php");
            }
            else{
                echo "Datos incorrectos. Inténtelo de nuevo.";
                $this->logInForm();
            }
    }
}