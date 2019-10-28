<?php namespace Controllers;

use DAOJson\UserRepository as UserRepository;
use Models\User as User;

class UserController {


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

    public function logIn($user=null, $password=null)
    {
           
            $login=false;
            $userList = new UserRepository();
            $userList->getAll(); //levantar todos los usuarios registrados en el json hasta el momento (comprobado)
            $view=null;
            $i=0;
            $flag=0;
            for($i=0;$i<count($userList->getArray()) && $flag==0;$i++)
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
                    $flag=1;
                }
                
            }
            if($login==true)
            {
                //session_start();
                $loggedUser = new User();
                $loggedUser->setUserName($user);
                $loggedUser->setPassword($password);
                // $loggedUser->$userList->firstNameAt($i);
                // $loggedUser->$userList->lastNameAt($i);
                // $loggedUser->$userList->emailAt($i);
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
        unset($_SESSION["loggedUser"]); //se vacia la variable global
        //echo "Ha cerrado sesion correctamente"; ponerlo de forma mas bonita visualmente
        //var_dump($_SESSION["loggedUser"]);
        require_once(VIEWS_PATH . "index.php"); //vista del home
    }

    // public function checkSession($user=null)
    // {   
    //     if($user==null)
    //     {
    //         return false;
    //     }
    //     else
    //     {
    //         $userRepo = new UserRepository();
    //         $userRepo->getAll();

    //         while($flag==false && $i <count($userRepo))
    //         { 
    //             if($user->getUserName()==$userList->userNameAt($i))
    //             {
    //                 if($user->getPassword() == $userList->passwordAt($i)){ 
    //                     return $user;    
    //                 }
    //                 $flag=true;
    //             }
    //             $i++;         
    //         }

    //     }
    //     return false;
    // }
    public function checkSession() {
        if (session_status() == PHP_SESSION_NONE)
             session_start();

        if(isset($_SESSION['loggedUser'])) {
             $userRepo = new UserRepository();

             $user = $userRepo->searchUser($_SESSION['loggedUser']->getUserName());

             if($user->getPassword() == $_SESSION['loggedUser']->getPassword())
                  return $user;

        } else {
             return false;
        }
   }
}