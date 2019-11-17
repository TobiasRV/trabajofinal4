<body class="home">

<?php 

//Paso 1 de la compra de tickets

date_default_timezone_set('America/Argentina/Buenos_Aires');
$date= date('d/m/Y');
$mod_date = strtotime($date."+ 6 days");

include_once(VIEWS_PATH . "header.php"); 


if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>
<body>

  <div class="container" align="center">
    <h2 class="mb-4">Comprar Tickets</h2>
    <h4 class="mb-4">Paso 1 de 3</h4>
    <form action="<?php echo FRONT_ROOT ?>Purchase/continuePurchase1" method="POST">
        <!-- <input type="hidden" id="id" name="id" value=""> -->
        <label for="cinema_id">Película</label><br>
        
        <select style="width:170px" id="movie" name="movie" class="form-control">
        <?php 
            foreach ($listado as $movies)
            {
                ?>
            <option value=<?php echo $movies->getIdMovie(); ?>><?php echo $movies->getTitle(); ?></option>
                
                <?php
            }
        ?>
        </select><br><br>
        
        <br><button name="submit" type="submit" class="btn btn-success">Continuar</button>
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