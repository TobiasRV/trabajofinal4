<?php

namespace Controllers;

// use DAOJson\UserRepository as UserRepository;
// use DAOJson\MovieDAO as MovieRepository;
// use DAOJson\TicketRepository as TicketRepository;
// use DAOJson\ShowDAO as ShowRepository;
// use DAOJson\PurchaseRepository as PurchaseRepository;
// use DAOJson\MovieTheaterDAO as MovieTheaterRepository;
// use DAOJson\CinemaDAO as CinemaRepository;




use DAO\UserRepository as UserRepository;
use DAO\MovieRepository as MovieRepository;
use DAO\TicketRepository as TicketRepository;
use DAO\ShowRepository as ShowRepository;
use DAO\PurchaseRepository as PurchaseRepository;
use DAO\MovieTheaterRepository as MovieTheaterRepository;
use DAO\CinemaRepository as CinemaRepository;

use Models\Purchase as Purchase;
use Models\User as User;
use Models\Show as Show;

class UserController
{


    public function signUpForm()
    {
        require_once(VIEWS_PATH . "signup.php");
    }

    public function userProfile()
    {
        if ($this->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 1) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navAdmin.php");
                include_once(VIEWS_PATH . "profile.php");
            } 
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    include_once(VIEWS_PATH . "profile.php");
                }
            }
        } 
        else 
        {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "index.php");
        }
    }

    public function signUp($username, $password, $email, $firstname, $lastname, $dni)
    {
        $add = true;

        $userRepo = new UserRepository();
        foreach ($userRepo->getAll() as $values) {
            if ($values->getEmail() == $email || $values->getUserName() == $username) {
                $add = false;
            }
        }
        if ($add) {
            $user = new User(); //crea el nuevo usuario y setea los datos
            $user->setUserName($username);
            $user->setPassword($password);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPermissions(2);
            $user->setDni($dni);
            $userRepo->Add($user);

            $_SESSION["loggedUser"] = $user; //se setea el usuario en sesion a la variable session  
            require_once(VIEWS_PATH . "index.php"); //vista del home
        } else {
            echo "No se ha podido registrar el usuario. Inténtelo de nuevo." . "<br>"; //manejar mensajes con excepciones
            $this->signUpForm(); //si no se pudo registrar el usuario se redirecciona al formulario para volver a ingresar datos
        }
    }



    public function logInForm($msj = null)
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function logIn($user = null, $password = null)
    {

        $msj = "Datos incorrectos";
        $userRepo = new UserRepository();
        $userList = $userRepo->getAll(); //levantar todos los usuarios registrados en el json hasta el momento (comprobado)
        $view = null;
        $i = 0;
        foreach ($userList as $values) {

            if (($values->getUserName() == $user) && ($values->getPassword() == $password)) {


                $msj = null;
                $loggedUser = new User();
                $loggedUser->setId($values->getId());
                $loggedUser->setUserName($user);
                $loggedUser->setPassword($password);
                $loggedUser->setFirstname($values->getFirstName());
                $loggedUser->setLastname($values->getLastName());
                $loggedUser->setEmail($values->getEmail());
                $loggedUser->setPermissions($values->getPermissions());
                $loggedUser->setDni($values->getDni());
                $_SESSION["loggedUser"] = $loggedUser; //se setea el usuario en sesion a la variable session
                $movieRepo = new MovieRepository();
                $movieRepo->updateDataBase();
                require_once(VIEWS_PATH . "index.php");
            }
        }

        if ($msj != null) {
            $this->logInForm($msj); //al estar incorrectos los datos se redirecciona al formulario para volverlos a ingresar
        }
    }

    public function logOut()
    {
        unset($_SESSION["loggedUser"]); //se vacia la variable global
        //echo "Ha cerrado sesion correctamente"; ponerlo de forma mas bonita visualmente
        //var_dump($_SESSION["loggedUser"]);
        require_once(VIEWS_PATH . "index.php"); //vista del home
    }

    public function checkSession()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        if (isset($_SESSION['loggedUser'])) {
            $userRepo = new UserRepository();

            $user = $userRepo->read($_SESSION['loggedUser']->getEmail());

            if ($user->getPassword() == $_SESSION['loggedUser']->getPassword())
                return $user;
        } else {
            return false;
        }
    }

    public function modifyUser($firstname, $lastname, $email, $dni, $username, $password)
    {
        $newUser = new User();
        $newUser->setId($_SESSION['loggedUser']->getId());
        $newUser->setFirstname($firstname);
        $newUser->setLastname($lastname);
        $newUser->setEmail($email);
        $newUser->setDni($dni);
        $newUser->setUsername($username);
        $newUser->setPassword($password);
        $userList = new UserRepository();
        $userList->edit($newUser);
        $this->logOut();
    }

    //funciones del admin

    //esta funciona bien, para que funcione bien la muestra de datos,
    //antes de llamar a la vista es necesario setearle valores a las variables
    //soldTickets, toSoldTickets, earnings, registeredUsers (respetando esos nombres)
    public function consultData()
    {
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();
        if (!is_array($listadoT)) {
            $aux = $listadoT;
            $listadoT = array();
            array_push($listadoT, $aux);
        }
        //variable que va a la vista
        $soldTickets = count($listadoT);

        //devuelve los tickets sin vender
        $toSoldTickets = $this->toSoldTickets();

        //variable que va a la vista
        $earnings = $this->calculateEarnings();

        $usersRepo = new UserRepository();
        $listadoU = $usersRepo->getAll();
        if (!is_array($listadoU)) {
            $aux = $listadoU;
            $listadoU = array();
            array_push($listadoU, $aux);
        }
        //variable que va a la vista
        $registeredUsers = count($listadoU);

        //lista de pelis que va a la vista(para elegir filtros)
        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();

        //lista de Cines que va a la vista(para elegir filtros)
        $movieTheatersRepo = new MovieTheaterRepository();
        $listadoMT = $movieTheatersRepo->getAll();
        if (!is_array($listadoMT)) {
            $aux = $listadoMT;
            $listadoMT = array();
            array_push($listadoMT, $aux);
        }

        if ($this->checkSession() != false) 
        {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    require_once(VIEWS_PATH . "index.php");
                }
                else 
                {
                    if ($_SESSION["loggedUser"]->getPermissions() == 1) 
                    {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navAdmin.php");
                        include_once(VIEWS_PATH . "consultData.php");
                    }
                } 
            } 
            else 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "nav.php");
                include_once(VIEWS_PATH . "index.php");
            }
    }

    public function toSoldTickets($listadoS = null)
    {
        $quantity = 0;
        if($listadoS == null)
        {
            $showsRepo = new ShowRepository();
            $listadoS = $showsRepo->getAll();
        }
        if(!is_array($listadoS))
        {
            $aux = $listadoS;
            $listadoS = array();
            array_push($listadoS,$aux);
        }
        foreach($listadoS as $show)
        {
            $quantity += $show->getSeats();
        }

        return $quantity;
    }

    public function calculateEarnings($listadoP = null)
    {
        $quantity = 0;
        if($listadoP == null)
        {
            echo "asd";
            $purchasesRepo = new PurchaseRepository();
            $listadoP = $purchasesRepo->getAll();

        }
        if(!is_array($listadoP))
        {
            $aux = $listadoP;
            $listadoP = array();
            array_push($listadoP,$aux);
        }
        foreach($listadoP as $purchase)
        {
            $quantity += $purchase->getTotal();
        }    
        return $quantity;
    }

    //andando
    public function searchByDates($dateInit, $dateFin)
    {
        $dateInit = str_replace('/', '-', $dateInit);
        $dateInit = date("Y-m-d", strtotime($dateInit));
        $dateFin = str_replace('/', '-', $dateFin);
        $dateFin = date("Y-m-d", strtotime($dateFin));

        $purchasesRepo = new PurchaseRepository();
        $listadoP = $purchasesRepo->getAll();
        $showsRepo = new ShowRepository();
        $listadoS = $showsRepo->getAll();
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();

        $resultPurchase = array();
        $resultShow = array();
        $resultTicket = array();

        if (!is_array($listadoP)) {
            $aux = $listadoP;
            $listadoP = array();
            array_push($listadoP, $aux);
        }
        if(! is_array($listadoS))
        {
            $aux = $listadoS;
            $listadoS = array();
            array_push($listadoS,$aux);
        }
        if(! is_array($listadoT))
        {
            $aux = $listadoT;
            $listadoT = array();
            array_push($listadoT,$aux);
        }

        foreach($listadoP as $purchase)
        {
            if($purchase->getPurchaseDate() >= $dateInit && $purchase->getPurchaseDate() <= $dateFin)
            {
                foreach($listadoT as $ticket)
                {
                    if($purchase->getIdPurchase() == $ticket->getIdPurchase())
                    {
                        array_push($resultTicket, $ticket);
                    }
                }
                array_push($resultPurchase, $purchase);
            }
        }
        foreach($listadoS as $show)
        {
            if($show->getDate() >= $dateInit && $show->getDate() <= $dateFin)
            {
                array_push($resultShow, $show);
            }
        }

        $soldTickets = count($resultTicket);
        $toSoldTickets = $this->toSoldTickets($resultShow);
        $earnings = $this->calculateEarnings($resultPurchase);

        $usersRepo = new UserRepository();
        $listadoU = $usersRepo->getAll();
        if (!is_array($listadoU)) {
            $aux = $listadoU;
            $listadoU = array();
            array_push($listadoU, $aux);
        }
        $registeredUsers = count($listadoU);

        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();

        $movieTheatersRepo = new MovieTheaterRepository();
        $listadoMT = $movieTheatersRepo->getAll();
        if (!is_array($listadoMT)) {
            $aux = $listadoMT;
            $listadoMT = array();
            array_push($listadoMT, $aux);
        }

        require_once(VIEWS_PATH . "consultData.php");
    }

    //esta está hecha a medias
    public function searchByMovieTheater($movieTheaterId)
    {
        $purchasesRepo = new PurchaseRepository();
        $listadoP = $purchasesRepo->getAll();
        $showsRepo = new ShowRepository();
        $listadoS = $showsRepo->getAll();
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();
        $cinemaRepo = new CinemaRepository();
        $listadoC = $cinemaRepo->getAll();

        $resultPurchase = array();
        $resultShow = array();
        $resultTicket = array();

        if(!is_array($listadoC)){
            $aux=$listadoC;
            $listadoC = array();
            array_push($listadoC,$aux);
        }

        if(!is_array($listadoS)){
            $aux=$listadoS;
            $listadoS = array();
            array_push($listadoS,$aux);
        }

        if(!is_array($listadoP)){
            $aux=$listadoP;
            $listadoP = array();
            array_push($listadoP,$aux);
        }

        if(!is_array($listadoT)){
            $aux=$listadoT;
            $listadoT = array();
            array_push($listadoT,$aux);
        }

        foreach($listadoC as $cinema){
            if($cinema->getIdMovieTheater() == $movieTheaterId){
                foreach($listadoS as $show){
                    if($show->getIdCinema() == $cinema->getId()){
                        array_push($resultShow,$show);
                        foreach($listadoP as $purchase){
                            if($purchase->getIdShow() == $show->getId()){
                                array_push($resultPurchase,$purchase);
                                foreach($listadoT as $ticket){
                                    if($ticket->getIdPurchase() == $purchase->getIdPurchase()){
                                        array_push($resultTicket,$ticket);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }



        $soldTickets = count($resultTicket);
        $toSoldTickets = $this->toSoldTickets($resultShow);
        if($resultPurchase == null){
            $resultPurchase = new Purchase();
        }
        $earnings = $this->calculateEarnings($resultPurchase);


        $usersRepo = new UserRepository();
        $listadoU = $usersRepo->getAll();
        if(! is_array($listadoU))
        {
            $aux = $listadoU;
            $listadoU = array();
            array_push($listadoU,$aux);
        }
        $registeredUsers = count($listadoU);

        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();

        $movieTheatersRepo = new MovieTheaterRepository();
        $listadoMT = $movieTheatersRepo->getAll();
        if(! is_array($listadoMT))
        {
            $aux = $listadoMT;
            $listadoMT = array();
            array_push($listadoMT,$aux);
        }



        if ($this->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 2) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navClient.php");
                require_once(VIEWS_PATH . "index.php");
            }
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 1) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navAdmin.php");
                    include_once(VIEWS_PATH . "consultData.php");
                }
            } 
        } 
        else 
        {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "index.php");
        }

    }

    public function searchByMovie($idMovie){
        $purchasesRepo = new PurchaseRepository();
        $listadoP = $purchasesRepo->getAll();
        $showsRepo = new ShowRepository();
        $listadoS = $showsRepo->getAll();
        $ticketsRepo = new TicketRepository();
        $listadoT = $ticketsRepo->getAll();

        
        $resultPurchase = array();
        $resultShow = array();
        $resultTicket = array();

        if(!is_array($listadoS)){
            $aux=$listadoS;
            $listadoS = array();
            array_push($listadoS,$aux);
        }

        if(!is_array($listadoP)){
            $aux=$listadoP;
            $listadoP = array();
            array_push($listadoP,$aux);
        }

        if(!is_array($listadoT)){
            $aux=$listadoT;
            $listadoT = array();
            array_push($listadoT,$aux);
        }


        foreach($listadoS as $show){
            if($show->getIdMovie() == $idMovie){
                array_push($resultShow,$show);
                foreach($listadoP as $purchase){
                    if($purchase->getIdShow() == $show->getId()){
                        array_push($resultPurchase,$purchase);
                        foreach($listadoT as $ticket){
                            if($ticket->getIdPurchase() == $purchase->getIdPurchase()){
                                array_push($resultTicket,$ticket);
                            }
                        }
                    }
                }
            }
        }
        

        $soldTickets = count($resultTicket);
        if($resultShow == null){
            $resultShow = new Show();
        }
        $toSoldTickets = $this->toSoldTickets($resultShow);
        if($resultPurchase == null){
            $resultPurchase = new Purchase();
        }
        $earnings = $this->calculateEarnings($resultPurchase);


        $usersRepo = new UserRepository();
        $listadoU = $usersRepo->getAll();
        if(! is_array($listadoU))
        {
            $aux = $listadoU;
            $listadoU = array();
            array_push($listadoU,$aux);
        }
        $registeredUsers = count($listadoU);

        $moviesRepo = new MovieRepository();
        $listadoM = $moviesRepo->getAll();

        $movieTheatersRepo = new MovieTheaterRepository();
        $listadoMT = $movieTheatersRepo->getAll();
        if(! is_array($listadoMT))
        {
            $aux = $listadoMT;
            $listadoMT = array();
            array_push($listadoMT,$aux);
        }



        if ($this->checkSession() != false) 
        {
            if ($_SESSION["loggedUser"]->getPermissions() == 2) 
            {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navClient.php");
                require_once(VIEWS_PATH . "index.php");
            }
            else 
            {
                if ($_SESSION["loggedUser"]->getPermissions() == 1) 
                {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navAdmin.php");
                    include_once(VIEWS_PATH . "consultData.php");
                }
            } 
        } 
        else 
        {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "index.php");
        }
    

     }

}
