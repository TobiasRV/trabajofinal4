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
            $userList->getAll(); //trae todos los usuarios registrados en el json hasta el momento
            for($i=0;$i<count($userList->getArray());$i++)
            { 
                if($userList->emailAt($i)==$email) //comprueba que no exista un usuario con ese mismo email
                {
                    $add=false;
                }
            }
            if($add){
                $user= new User(); //crea el nuevo usuario y setea los datos
                $user->setUserName($username);
                $user->setPassword($password);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setEmail($email);
                $userList->Add($user);

                //session_start(); se inicia sesion con el nuevo usuario registrado

                $_SESSION["loggedUser"] = $user; //se setea el usuario en sesion a la variable session

                require_once(VIEWS_PATH . "index.php"); //vista del home
            }
            else{
                echo "No se ha podido registrar el usuario. Inténtelo de nuevo." . "<br>";

                $this->signUpForm(); //si no se pudo registrar el usuario se redirecciona al formulario para volver a ingresar datos
            }
    }

    public function logInForm()
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function logIn($user, $password)
    {

            $login=false;
            $userList = new UserRepository();
            $userList->getAll(); //levantar todos los usuarios registrados en el json hasta el momento (comprobado)
            $view=null;
            for($i=0;$i<count($userList->getArray());$i++)
            {
                if(($userList->userNameAt($i)==$user) && ($userList->passwordAt($i)==$password)) //buscar si coinciden usuario y contraseña
                {
                    $login=true;
                    if($userList->permissionsAt($i)==true)
                    {
                        $view="admin";
                    }
                    else
                    {
                        $view="client";
                    }
                }
                
            }
            if($login==true)
            {
                //session_star(); deberia iniciarse sesion aca, al ingresar un usuario registrado a la web

                $loggedUser = new User();
                $loggedUser->setUserName($user);
                $loggedUser->setPassword($password);

                $_SESSION["loggedUser"] = $loggedUser; //se setea el usuario en sesion a la variable session

                if($view=="client")
                {
                    require_once(VIEWS_PATH . "indexClient.php"); //vista del home cliente
                }
                else
                {
                    require_once(VIEWS_PATH . "indexAdmin.php"); //vista del home admin
                }
                 
            }
            else
            {
                echo "Datos incorrectos. Inténtelo de nuevo." . "<br>";
                $this->logInForm(); //al estar incorrectos los datos se redirecciona al formulario para volverlos a ingresar
            }
    }

    public function logOut()
    {
        //session_star(); se inicia sesion en caso de que se oprima el boton logout y no haya usuario en sesion

        //session_destroy(); se destruye la sesion

        require_once(VIEWS_PATH . "index.php"); //vista del home
    }
}