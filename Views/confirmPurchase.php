<body class="home">

<?php 

include_once(VIEWS_PATH . "header.php"); 


if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>

<body>

  <div class="container" align="center">
    <h2 class="mb-4">Comprar Tickets</h2>
    <h4 class="mb-4">Paso 3 de 3</h4>
    <form action="<?php echo FRONT_ROOT ?>Purchase/confirmPurchase" method="POST">
        <!-- <input type="hidden" id="id" name="id" value=""> -->

        <label for="cinema_id">Método de Pago</label><br>
        <select style="width:170px">
        <option value="Visa">Tarjeta de Crédito Visa</option>
        <option value="Master">Tarjeta de Crédito Master</option>
        </select><br>

        <label for="cardNumber">Número de Tarjeta</label><br>
        <input type="number" style="width:170px" id="cardNumber" name="cardNumber" placeholder="Número de Tarjeta" required min=16 max=16 title="Solo números"><br>

        <label for="cardOwner">Titular de la Tarjeta</label><br>
        <input type="text" style="width:170px" id="cardOwner" name="cardOwner" placeholder="Nombre" required min=16 max=16 title="Solo números"><br>
        <input type="text" style="width:170px" id="cardOwner" name="cardOwner" placeholder="Apellido" required min=16 max=16 title="Solo números"><br>


        <label for="cinema_id">Película</label><br>
        <select style="width:170px" id="movie" name="movie">
        <?php 
            foreach ($listado as $movies)
            {
                ?>
            <option value=<?php echo $movies->getIdMovie(); ?>><?php echo $movies->getTitle(); ?></option>
                
                <?php
            }
        ?>
        </select><br><br>
        <label for="quantityTickets">Cantidad</label><br>
        <input type="number" style="width:170px" id="quantityTickets" name="quantityTickets" placeholder="Cantidad de Tickets" required min=1 max=6 title="Solo números (máximo 6 tickets por compra)"><br>
        <label for="date">Fecha</label><br>
        <!-- ver como limitar el rango de las fechas -->
        <input type="date" style="width:170px" id="date" name="date" required min="<?php $date ?>" max="<?php $mod_date ?>" title="La fecha de la función no puede ser mayor a una semana a partir de la fecha actual"><br>
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