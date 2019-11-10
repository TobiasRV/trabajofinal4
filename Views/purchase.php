<body class="home">

<?php 

date_default_timezone_set('America/Argentina/Buenos_Aires');
$date= date('d/m/Y');
$mod_date = strtotime($date."+ 6 days");

include_once(VIEWS_PATH . "header.php"); 

use Controllers\UserController as UserController;
use DAO\MovieRepository as MovieRepository;

$userControl = new UserController();

$movieRepo = new MovieRepository();
$listado=$movieRepo->getNowPlayingMovies();

if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>
<body>

  <div class="container" align="center">
    <h2 class="mb-4">Comprar Tickets</h2>
    <form action="<?php echo FRONT_ROOT ?>Purchase/ticketPurchase" method="post">
        <!-- <input type="hidden" id="id" name="id" value=""> -->
        <label for="cinema_id">Película</label><br>
        <select style="width:170px" id="movie" name="movie">
        <?php 
            foreach ($listado as $movies)
            {
                ?>
            <option value=<?php $movies->getIdMovie(); ?>><?php echo $movies->getTitle(); ?></option>
                <?php
            }
        ?>
        </select><br><br>
        <label for="quantityTickets">Cantidad</label><br>
        <input type="number" style="width:170px" id="quantityTickets" name="quantityTickets" placeholder="Cantidad de Tickets" required min=1 max=6 title="Solo números (máximo 6 tickets por compra)"><br>
        <label for="date">Fecha</label><br>
        <!-- ver como limitar el rango de las fechas -->
        <input type="date" style="width:170px" id="date" name="date" required min="<?php $date ?>" max="<?php $mod_date ?>" title="La fecha de la función no puede ser mayor a una semana a partir de la fecha actual"><br>
        <input id="emailUser" name="emailUser" type="hidden" required value="<?php $_SESSION["loggedUser"]->getEmail() ?>">
        <br><button name="submit" type="submit">Comprar</button>
    </form>
  </div>
<?php include_once(VIEWS_PATH . "footer.php"); ?>
    
 <?php 
 } 
    else 
    {
        if ($_SESSION["loggedUser"]->getPermissions() == 1) 
        {
            include_once(VIEWS_PATH . "index.php");
        }
    }
} 
else 
{
    include_once(VIEWS_PATH . "index.php");
}


?>