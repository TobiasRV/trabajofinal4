<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">


<?php
    include_once(VIEWS_PATH . "header.php");
    include_once(VIEWS_PATH . "navAdmin.php");
?>

<body class="home">

<br><br>
<form class="form-inline" action="<?php echo FRONT_ROOT ?>User/searchData" method="POST">
        <p>&nbsp</p><label for="movie">Cines:  </label><p>&nbsp</p>
        <select style="width:170px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" >
            <option value="" disabled selected>Filtrar por cine</option>
                <?php foreach ($listadoMT as $movieTheater) { ?>
                    <option value=<?php echo $movieTheater->getId(); ?> data-tokens="<?php echo $movieTheater->getName(); ?>"><?php echo $movieTheater->getName(); ?></option>
                <?php } ?>
        </select>
        <p>&nbsp</p><label for="movie">Película:  </label><p>&nbsp</p>
        <select style="width:170px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" >
            <option value="" disabled selected>Filtrar por película</option>
                <?php foreach ($listadoM as $movie) { ?>
                    <option value=<?php echo $movie->getIdMovie(); ?> data-tokens="<?php echo $movie->getTitle(); ?>"><?php echo $movie->getTitle(); ?></option>
                <?php } ?>
        </select>
        <p>&nbsp</p><label for="dateInit">Desde:  </label><p>&nbsp</p>
        <input class="form-control" id="dateInit" name="dateInit" placeholder="DD / MM / YYYY" type="text"/>
    <p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>

    <p>&nbsp</p><label for="dateFin">Hasta:  </label><p>&nbsp</p>
        <input class="form-control" id="dateFin" name="dateFin" placeholder="DD / MM / YYYY" type="text"/>
    <p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>
    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>

</form>

<br><br><br><br>
<div class="row w-100">
        <div class="col-md-3">
            <div class="card border-info mx-sm-1 p-3">
                <div class="card border-info shadow text-info p-3 my-card" ><span class="fas fa-ticket-alt" aria-hidden="true"></span></div>
                <div class="text-info text-center mt-3"><h4>Entradas Vendidas</h4></div>
                <div class="text-info text-center mt-2"><h1><?php echo $soldTickets ?></h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mx-sm-1 p-3">
                <div class="card border-warning shadow text-warning p-3 my-card"><span class="fas fa-store" aria-hidden="true"></span></div>
                <div class="text-warning text-center mt-3"><h4>Entradas Remanentes</h4></div>
                <div class="text-warning text-center mt-2"><h1><?php echo $toSoldTickets ?></h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mx-sm-1 p-3">
                <div class="card border-success shadow text-success p-3 my-card" ><span class="fas fa-hand-holding-usd" aria-hidden="true"></span></div>
                <div class="text-success text-center mt-3"><h4>Ganancias</h4></div>
                <div class="text-success text-center mt-2"><h1><?php echo "$ " . $earnings ?></h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger mx-sm-1 p-3">
                <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fas fa-users" aria-hidden="true"></span></div>
                <div class="text-danger text-center mt-3"><h4>Usuarios Registrados</h4></div>
                <div class="text-danger text-center mt-2"><h1><?php echo $registeredUsers ?></h1></div>
            </div>
        </div>
     </div>


<style type="text/css">
.my-card
{
    position:absolute;
    left:40%;
    top:-20px;
    border-radius:50%;
}
</style>

<?php 
    include_once(VIEWS_PATH . "footer.php");
?>