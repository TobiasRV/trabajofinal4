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
        <label for="cinema_id">Seleccione una Tarjeta</label><br>
        <select style="width:170px" id="creditCard" name="creditCard" class="form-control">
        <?php
        if($listado != null){
        foreach($listado as $creditCard)
        {
            if($creditCard->getStatus()==true){
                ?>
                <option value="<?php echo $creditCard->getId(); ?>"><?php echo $creditCard->getCompany() . " - ********" . substr( $creditCard->getNumber(), -4 );  ?></option>
                
                <?php
            }
        }
        }
        ?>
        </select><br>
        
        <br><button type="button" data-toggle="modal" data-target="#addCreditCard" class="btn btn-outline-secondary">Agregar Tarjeta</button><br><br>

        <label for="quantityTickets">Cantidad</label><br>
        <input type="number" style="width:170px" id="quantityTickets" name="quantityTickets" placeholder="Cantidad de Tickets" required min=1 max=6 title="Solo números (máximo 6 tickets por compra)"><br>

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

<!-- MODAL -->
<div class="modal fade" id="addCreditCard">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo "Agregar Tarjeta "; ?></h4>
                    <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container fluid">
                        <div class="row">

                            <form action="<?php echo FRONT_ROOT ?>Purchase/addCreditCard" method="post">
                                <div class="form-group">
                                    <label for="company">
                                        <h5>Compañía</h5>
                                    </label>
                                    <select id="company" name="company">
                                    <option value="Visa">Visa</option>
                                    <option value="Master">Master</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="number">
                                        <h5>Número de Tarjeta</h5>
                                    </label>
                                    <input type="number" style="width:170px" id="cardNumber" name="cardNumber" placeholder="Número de Tarjeta" required  title="Solo números"><br>
                                </div>
                                <div class="form-group">
                                    <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Agregar</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    
