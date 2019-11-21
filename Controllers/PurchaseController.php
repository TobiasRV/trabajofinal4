<?php

namespace Controllers;

use Models\Ticket as Ticket;
use Models\Purchase as Purchase;
use Controllers\UserController as UserController;
use Controllers\MovieController as MovieController;
use Models\CreditCard as CreditCard;
//DAO BD
// use DAO\MovieRepository as MovieRepository;
// use DAO\ShowRepository as ShowRepository;
// use DAO\MovieTheaterRepository as MovieTheaterRepository;
// use DAO\CinemaRepository as CinemaRepository;
// use DAO\PurchaseRepository as PurchaseRepository;
// use DAO\CreditCardRepository as CreditCardRepository;
// use DAO\TicketRepository as TicketRepository;
//END DAO BD

//DAO JSON
use DAOJson\movieDAO as MovieRepository;
use DAOJson\ShowDAO as ShowRepository;
use DAOJson\MovieTheaterDAO as MovieTheaterRepository;
use DAOJson\CinemaDAO as CinemaRepository;
use DAOJson\PurchaseRepository as PurchaseRepository;
use DAOJson\CreditCardRepository as CreditCardRepository;
use DAOJson\TicketRepository as TicketRepository;
//END DAO JSON

use Exception;
use PDOException;


class PurchaseController
{


    public function purchaseStep1()
    {
        $userControl = new UserController();
        $movieRepo = new MovieRepository();
        try {
            $listado = $movieRepo->getNowPlayingMovies();
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {


            if ($userControl->checkSession() != false) {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    require_once(VIEWS_PATH . "purchaseStep1.php");
                } else {
                    if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navAdmin.php");
                        include_once(VIEWS_PATH . "index.php");
                    }
                }
            } else {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "nav.php");
                include_once(VIEWS_PATH . "index.php");
            }
        }
    }

    public function purchaseStep2()
    {
        $userControl = new UserController();
        $showRepo = new ShowRepository();
        try {
            $listadoS = $showRepo->getAll();
            $listadoMT = new MovieTheaterRepository();
            $movieTheaters = $listadoMT->getAll();
            $cinemasRepo = new CinemaRepository();
            $listadoCinemas = $cinemasRepo->getAll();
            $listado = array();

            if (!is_array($listadoS)) {
                $aux = $listadoS;
                $listadoS = array();
                array_push($listadoS, $aux);
            }
            if ($listadoS != null) {
                foreach ($listadoS as $show) {
                    if ($show->getIdMovie() == $_SESSION["idMovieSearch"] && $show->getStatus() == true) {
                        array_push($listado, $show);
                    }
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {

            if ($userControl->checkSession() != false) {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    require_once(VIEWS_PATH . "purchaseStep2.php");
                } else {
                    if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navAdmin.php");
                        include_once(VIEWS_PATH . "index.php");
                    }
                }
            } else {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "nav.php");
                include_once(VIEWS_PATH . "index.php");
            }
        }
    }
    public function continuePurchase1($idMovie)
    {
        $_SESSION["idMovieSearch"] = $idMovie;
        $this->purchaseStep2();
    }

    public function continuePurchase2($idShow)
    {
        $purchase = new Purchase();
        $purchase->setIdShow($idShow);
        $showRepo = new ShowRepository();
        $showObj = $showRepo->read($idShow);
        $_SESSION["purchase"] = $purchase;
        $_SESSION["idCinema"] = $showObj->getIdCinema();
        $_SESSION["avaiableSeats"] = $showObj->getSeats();
        //setear nombre de cine en session
        $cinemas = new CinemaRepository();

        try {
            $cinemasRepo = $cinemas->getAll();
            $idMovieTheater = 0;
            foreach ($cinemasRepo as $cinemas) {
                if ($cinemas->getId() == $_SESSION["idCinema"]) {
                    $idMovieTheater = $cinemas->getIdMovieTheater();
                }
            }

            $movieTheaters = new MovieTheaterRepository();
            $movieTheatersRepo = $movieTheaters->getAll();
            $nameMovieTheater = "";
            foreach ($movieTheatersRepo as $movieTheaters) {
                if ($movieTheaters->getId() == $idMovieTheater) {
                    $nameMovieTheater = $movieTheaters->getName();
                }
            }
            $_SESSION["nameMovieTheater"] = $nameMovieTheater;

            $_SESSION["checkCreditCard"] = false;
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        } else {

            $this->purchaseStep3();
        }
    }

    public function purchaseStep3()
    {
        $userControl = new UserController();
        $creditCardsRepo = new CreditCardRepository();
        $listado = $creditCardsRepo->getCreditCards($_SESSION["loggedUser"]->getId());
        if ($listado != null) {
            if (!is_array($listado)) {
                $aux = $listado;
                $listado = array();
                array_push($listado, $aux);
            }
        }

        if ($userControl->checkSession() != false) {
            if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "navClient.php");
                require_once(VIEWS_PATH . "purchaseStep3.php");
            } else {
                if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navAdmin.php");
                    include_once(VIEWS_PATH . "index.php");
                }
            }
        } else {
            include_once(VIEWS_PATH . "header.php");
            include_once(VIEWS_PATH . "nav.php");
            include_once(VIEWS_PATH . "index.php");
        }
    }

    public function confirmPurchase($id_creditcard,  $creditCardNumber, $qTickets)
    {
        $this->checkCreditCardNumber($creditCardNumber);
        if ($_SESSION["checkCreditCard"] == true) {
            $ccRepo = new CreditCardRepository();
            try {
                $listadoCC = $ccRepo->getAll();
                foreach ($listadoCC as $ccs) {
                    if ($ccs->getId() == $id_creditcard) {

                        $creditCard = new CreditCard();
                        $creditCard->setCompany($ccs->getCompany());
                        $creditCard->setNumber($ccs->getNumber());
                        $creditCard->setIdUser($ccs->getIdUser($_SESSION["loggedUser"]->getId()));
                    }
                }
                $creditCard = $ccRepo->getId($creditCard);
                $_SESSION["creditCard"] = $creditCard;

                $listado = new CinemaRepository();
                $cinemas = $listado->getAll();
                foreach ($cinemas as $cm) {
                    if ($cm->getId() == $_SESSION["idCinema"]) {
                        $_SESSION["ticketPrice"] = $cm->getTicketPrice();
                    }
                }

                //se comprueba que haya suficientes asientos libres para realizar la compra
                if ($_SESSION["avaiableSeats"] >= $qTickets) {
                    $purchase = new Purchase();
                    $purchase = $_SESSION["purchase"];
                    $purchase->setPurchaseDate(date('Y-m-d'));
                    $purchase->setQuantityTickets($qTickets);

                    $totalAux = $purchase->getQuantityTickets() * $_SESSION["ticketPrice"];
                    if ($this->checkDiscount() == true) {
                        $purchase->setDiscount(0.25);
                    }
                    $purchase->setTotal($totalAux - ($totalAux * $purchase->getDiscount()));
                    $purchase->setIdCreditCard($_SESSION["creditCard"]->getId());

                    $_SESSION["purchase"] = $purchase;
                }

                $userControl = new UserController();
                $moviesRepo = new MovieRepository();
                $showsRepo = new ShowRepository();
                $listMovies = $moviesRepo->getAll();
                $nameMovie = "";
                foreach ($listMovies as $lm) {
                    if ($lm->getIdMovie() == $_SESSION["idMovieSearch"]) {
                        $nameMovie = $lm->getTitle();
                    }
                }

                $showData = $showsRepo->getShowData($_SESSION["purchase"]->getIdShow());
            } catch (Exception $ex) {
                $msj = $ex;
            }
            if (isset($msj)) {
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "error.php");
                require_once(VIEWS_PATH . "footer.php");
            } else {


                if ($userControl->checkSession() != false) {
                    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navClient.php");
                        require_once(VIEWS_PATH . "confirmData.php");
                    } else {
                        if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                            include_once(VIEWS_PATH . "header.php");
                            include_once(VIEWS_PATH . "navAdmin.php");
                            include_once(VIEWS_PATH . "index.php");
                        }
                    }
                } else {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "nav.php");
                    include_once(VIEWS_PATH . "index.php");
                }
            }
        } else {
            ?>
            <script>
                alert("Número de Tarjeta incorrecto, por favor ingrese de nuevo los datos.");
            </script>
<?php

            $this->purchaseStep3();
        }
    }

    public function checkDiscount()
    {
        $flag = false;
        $day = date('l');
        if ($day == "Tuesday" || $day == "Wednesday") {
            if ($_SESSION["purchase"]->getQuantityTickets() >= 2) {
                $flag = true;
            }
        }

        return $flag;
    }

    public function addCreditCard($company, $number)
    {
        $newCreditCard = new CreditCard();
        $newCreditCard->setNumber($number);
        $newCreditCard->setCompany($company);
        $newCreditCard->setIdUser($_SESSION["loggedUser"]->getId());
        $creditCardRepo = new CreditCardRepository();
        try {
            $creditCardRepo->Add($newCreditCard);
            $this->purchaseStep3();
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }



    public function checkButton($value)
    {
        if ($value == "CONFIRMAR") {
            try {
                $purchase = $_SESSION["purchase"];
                $purchaseRepo = new PurchaseRepository();
                $purchaseRepo->Add($purchase);
                $ticketsRepo = new TicketRepository();
                $_SESSION["idPurchase"] = $purchaseRepo->getLastPurchase()->getIdPurchase();
                $this->generateTickets();
                $ticketsEmail = $ticketsRepo->getTicketsByIdPurchase($_SESSION["idPurchase"]);
                if (!is_array($ticketsEmail)) {
                    $aux = $ticketsEmail;
                    $ticketsEmail = array();
                    array_push($ticketsEmail, $aux);
                }
                $this->emailTickets($ticketsEmail);
                $this->clearSessionVariables();
                $userControl = new UserController();
            } catch (Exception $ex) {
                $msj = $ex;
            }
            if (isset($msj)) {
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "error.php");
                require_once(VIEWS_PATH . "footer.php");
            } else {

                if ($userControl->checkSession() != false) {
                    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navClient.php");
                        require_once(VIEWS_PATH . "index.php");
                    } else {
                        if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                            include_once(VIEWS_PATH . "header.php");
                            include_once(VIEWS_PATH . "navAdmin.php");
                            include_once(VIEWS_PATH . "index.php");
                        }
                    }
                } else {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "nav.php");
                    include_once(VIEWS_PATH . "index.php");
                }
            }
        } else {
            $this->clearSessionVariables();
            $userControl = new UserController();
            if ($userControl->checkSession() != false) {
                if ($_SESSION["loggedUser"]->getPermissions() == 2) {
                    include_once(VIEWS_PATH . "header.php");
                    include_once(VIEWS_PATH . "navClient.php");
                    require_once(VIEWS_PATH . "index.php");
                } else {
                    if ($_SESSION["loggedUser"]->getPermissions() == 1) {
                        include_once(VIEWS_PATH . "header.php");
                        include_once(VIEWS_PATH . "navAdmin.php");
                        include_once(VIEWS_PATH . "index.php");
                    }
                }
            } else {
                include_once(VIEWS_PATH . "header.php");
                include_once(VIEWS_PATH . "nav.php");
                include_once(VIEWS_PATH . "index.php");
            }
        }
    }

    public function generateTickets()
    {
        try {
            $q_Tickets = $_SESSION["purchase"]->getQuantityTickets();
            for ($i = 0; $i < $q_Tickets; $i++) {
                $ticket = new Ticket();
                $ticket->setIdPurchase($_SESSION["idPurchase"]);
                $ticketsRepo = new TicketRepository();
                $ticketsRepo->Add($ticket);
            }

            //Se resta de la capacidad de asientos de la funcion la cantidad de tickets comprados
            $purchase = $_SESSION["purchase"];
            $showsRepo = new ShowRepository();
            $listadoShows = $showsRepo->getAll();
            if (!is_array($listadoShows)) {
                $aux = $listadoShows;
                $listadoShows = array();
                array_push($listadoShows, $aux);
            }
            foreach ($listadoShows as $shows) {
                if ($shows->getId() == $purchase->getIdShow()) {
                    $shows->setSeats($shows->getSeats() - $purchase->getQuantityTickets());
                    $_SESSION["show"] = $shows;
                }
            }
            $showsRepo->edit($_SESSION["show"]);
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function clearSessionVariables()
    {
        unset($_SESSION["purchase"]);
        unset($_SESSION["idMovieSearch"]);
        unset($_SESSION["idCinema"]);
        unset($_SESSION["avaiableSeats"]);
        unset($_SESSION["creditCard"]);
        unset($_SESSION["ticketPrice"]);
        unset($_SESSION["idPurchase"]);
        unset($_SESSION["nameMovieTheater"]);
        unset($_SESSION["show"]);
        unset($_SESSION["checkCreditCard"]);
    }

    public function checkCreditCardNumber($number)
    {
        try {
            $creditCardsRepo = new CreditCardRepository();
            $listadoCC = $creditCardsRepo->getAll();
            foreach ($listadoCC as $cc) {
                if ($cc->getNumber() == $number) {
                    $_SESSION["checkCreditCard"] = true;
                }
            }
        } catch (Exception $ex) {
            $msj = $ex;
        }
        if (isset($msj)) {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "error.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function emailTickets($tickets)
    {
        $movieController = new MovieController();
        if (!is_array($tickets)) {
            $aux = $tickets;
            $tickets = array();
            array_push($tickets, $aux);
        }

        $to_email = $_SESSION['loggedUser']->getEmail();
        $subject = 'Entradas compradas en MoviePass';
        $message = "
        <html> <head>
        <title>MoviePass</title>
        </head> 
        <body>
        <p> Felicidades usted adquirio " . count($tickets) . " entradas para " . $movieController->searchMovieById($_SESSION["idMovieSearch"])->getTitle() . ", aqui estan sus codigos QR </p>";

        foreach ($tickets as $t) {
            $message .=
                "<td><img src=" . " https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl= " . $t->getIdTicket() . "&choe=UTF-8 hspace=" . "20" . "></td><br></br><br></br>";
        }
        $message .= "  </body>
        </html>";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //$headers .= 'From: El equipo de MoviePass, por favor no responder. Le deseamos una buena jornada.';
        mail($to_email, $subject, $message, $headers);
    }
}
