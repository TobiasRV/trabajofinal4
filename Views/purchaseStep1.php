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

<div class="card">
<h2 class="card-header info-color white-text text-center py-4">
    <strong>Paso 1 de 3</strong>
</h2>
<div class="card-body px-lg-5">

    <form class="text-center" style="color: #757575;" action="<?php echo FRONT_ROOT ?>Purchase/continuePurchase1" method="POST">

        <div class="md-form mt-3">
        <label for="cinema_id" style="font-size:20px;">Películas</label><br>
        <select style="width:170px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" >
        <option value="" disabled selected>Elige una película...</option>
        <?php 
            if($listado != null){
            foreach ($listado as $movies)
            {
                ?>
            <option value=<?php echo $movies->getIdMovie(); ?> data-tokens="<?php echo $movies->getTitle(); ?>"><?php echo $movies->getTitle(); ?></option>
                
                <?php
            }
            }
        ?>
        </select><br><br>
        </div>

        
        <br><button style="width:100%" name="submit" type="submit" class="btn btn-lg btn-success">Continuar</button>
        <br><br><br><div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%"></div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
