<link rel="stylesheet" href="<?php echo VIEWS_PATH ?>css/shoppingCart.css">
<body class="home">


<?php 

//Paso 2 de la compra de tickets

//include_once(VIEWS_PATH . "header.php"); 




if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>
    
        

<body>

  <div class="card">
    <h2 class="card-header info-color white-text text-center py-4">
        <strong>Paso 2 de 3</strong>
    </h2>
    <div class="card-body px-lg-5">
        <form class="text-center" style="color: #757575;" action="<?php echo FRONT_ROOT ?>Purchase/continuePurchase2" method="POST">

            <div class="md-form mt-3">
            <label for="quantityTickets" style="font-size:20px;">Funciones</label><br>
        <input type="text" id="myInput" class="form-control" onkeyup="filterSearch()" placeholder="Buscar por cine..">
        
        <table id="myTable" class="table table-striped table-dark">
            <tr class="header" >
                <th style="width:60%;">Cine</th>
                <th style="width:40%;">Función</th>
                <th>Seleccionar</th>
            </tr>
        <?php 
            if($listado != false){
                ?>
            <tr>    
                
                <td><?php
                foreach($listado as $show)
                {

                foreach($movieTheaters as $mt)
                {

                    foreach($listadoCinemas as $cinemas)
                    {
    
                        if($cinemas->getIdMovieTheater() == $mt->getId())
                        {
    
                            if($show->getIdCinema() == $cinemas->getId())
                            {
                                echo $mt->getName(); 
                            }
                        }
                    }
                }?></td>
                <td><?php echo $show->getDate() . " " . $show->getTime(); ?></td>
                <td><input type="radio" name="idShow" id = "idShow" value="<?php echo  $show->getId(); ?>" required><br></td>          
            </tr>
            <?php
            }
        }
            
        
        else{
            ?>
            <script LANGUAGE='JavaScript'>
                window.alert('No hay funciones disponibles para esta pelicula, intente eligiendo otra.')
                window.location.href='<?php echo FRONT_ROOT ?>Purchase/purchaseStep1';
            </script>
            
            <?php
        }
        ?>
        </table>
        <br><button style="width:100%" name="submit" type="submit" class="btn btn-lg btn-success">Continuar</button>
        <br><br><br><div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%"></div>
        </div>
        </form>
    </div>
    </div>

</body>


  <?php include_once(VIEWS_PATH . "footer.php"); ?>
    
    <?php } else {
        if ($_SESSION["loggedUser"]->getPermissions() == 2) {
            include_once(VIEWS_PATH . "index.php");
        }
    }
} else {
            include_once(VIEWS_PATH . "index.php");
}

?>

<script>
        function filterSearch() {
                // Declare variables
                var input, filter, table, tr, td, i;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    }
                }
                }
    </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />