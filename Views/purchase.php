<body class="home">

<?php 

include_once(VIEWS_PATH . "header.php"); 

use Controllers\UserController as UserController;
use DAOJson\CinemaRepository as CinemaRepository;

$userControl = new UserController();

$cinemaRepo = new CinemaRepository();
$listado=$cinemaRepo->getAll();

if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>
<body>

  <div class="container" align="center">
    <h2 class="mb-4">Comprar Tickets</h2>
    <form action="<?php echo FRONT_ROOT ?>Ticket/ticketPurchase" method="post">
        <input type="hidden" id="id" name="id" value="<?php //id purchase ?>">
        <label for="cinema_id">Cine</label><br>
        <select style="width:170px">
        <?php 
            foreach ($listado as $cine)
            {
                ?>
            <option value=<?php $cine->getId(); ?>><?php echo $cine->getName(); ?></option>
                <?php
            }
        ?>
        </select><br>
        <!-- falta hacer un select con las funciones disponibles por cine y por pelicula -->
        <label for="quantityTickets">Cantidad</label><br>
        <input type="text" id="quantityTickets" name="quantityTickets" placeholder="Cantidad de Tickets" required min=1 max=6 title="Solo números (máximo 6 tickets por compra)"><br>
        <label for="discount">Descuento</label><br>
        <input id="discount" name="discount" type="number" value="<?php //valor del descuento si es que esta habilitado para la compra ?>" readonly><br>
        <label for="total">Total</label><br>
        <input id="total" name="total" type="number" value="<?php //suma del total de los tickets a comprar ?>" readonly><br>
        <input id="emailUser" name="emailUser" type="hidden" required value="<?php //email del usuario realizando la compra ?>">
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