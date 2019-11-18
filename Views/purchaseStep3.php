<body class="home">

<?php 

include_once(VIEWS_PATH . "header.php"); 


if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); 
    ?>


<body>

<div class="card">
  <h2 class="card-header info-color white-text text-center py-4">
      <strong>Paso 3 de 3</strong>
  </h2>
  <div class="card-body px-lg-5">

      <form class="text-center" style="color: #757575;" action="<?php echo FRONT_ROOT ?>Purchase/confirmPurchase" method="POST">

        <div class="md-form mt-3">
        <label for="quantityTickets" style="font-size:20px;">Seleccione una Tarjeta</label><br>
        <select style="width:170px" id="creditCard" name="creditCard" class="form-control selectpicker" data-live-search="true">
        <option value="" disabled selected>Elige una tarjeta...</option>
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
        </div>

        <br><button name="submit" type="submit" class="btn btn-primary btn-primary btn-block" data-toggle="modal" data-target="#addCreditCard">Agregar Tarjeta</button><br>
    
        <div class="md-form mt-3">
        <label for="creditCardNumber" style="font-size:20px;">Número de Tarjeta (Chequeo de Seguridad)</label><br>
        <input type="number" class="form-control" style="width:1300px" id="creditCardNumber" name="creditCardNumber" placeholder="Número de la Tarjeta" required title="Por una cuestión de seguridad se requiere ingresar el número de la tarjeta"><br>
        </div>
            
        <div class="md-form mt-3">
        <label for="quantityTickets" style="font-size:20px;">Cantidad de Tickets</label><br>
        <input type="number" class="form-control" style="width:1300px" id="quantityTickets" name="quantityTickets" placeholder="Cantidad de Tickets" required min=1 max=6 title="Solo números (máximo 6 tickets por compra)"><br>
        </div>

        <br><button style="width:100%" name="submit" type="submit" class="btn btn-lg btn-success">Comprar</button>
  
        <br><br><br><div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>
      </form>
  </div>
  </div>

  <script>
    $(function() {
    $('.selectpicker').selectpicker();
    });
  </script>

</body>





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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

