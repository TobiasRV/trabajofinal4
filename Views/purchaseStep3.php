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
        <input type="text" style="width:170px" id="cardOwnerFirstame" name="cardOwner" placeholder="Nombre" required pattern="[A-Za-z]" title="Solo letras"><br>
        <input type="text" style="width:170px" id="cardOwnerLastname" name="cardOwner" placeholder="Apellido" required pattern="[A-Za-z]" title="Solo letras"><br>

        <label for="dniOwner">DNI del Titular</label><br>
        <input type="number" style="width:170px" id="dniOwner" name="dniOwner" placeholder="DNI del Titular" required  max=8 title="Solo números"><br>

        <label for="cardExpire">Fecha de Vencimiento</label><br>
        <input type="month" style="width:170px" id="cardExpire" name="cardExpire" placeholder="Fecha de Vencimiento" required><br>

        <label for="cardCode">Código de Seguridad</label><br>
        <input type="number" style="width:170px" id="cardCode" name="cardCode" placeholder="Código de Seguridad" required min=3 max=3 title="Solo números"><br>

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