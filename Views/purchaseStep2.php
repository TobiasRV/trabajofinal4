<body class="home">


<?php 

//Paso 2 de la compra de tickets

include_once(VIEWS_PATH . "header.php"); 




if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>
        <body>

    <div class="container" align="center">
    <h2 class="mb-4">Comprar Tickets</h2>
    <h4 class="mb-4">Paso 2 de 3</h4>

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
    <form action="<?php echo FRONT_ROOT ?>Purchase/continuePurchase2" method="POST">
        <!-- <input type="hidden" id="id" name="id" value=""> -->


        <label for="quantityTickets">Funciones</label><br>
        <input type="text" id="myInput" onkeyup="filterSearch()" placeholder="Buscar por cine..">
        
        <table id="myTable">
            <tr class="header" >
                <th style="width:40%;">Cine</th>
                <th style="width:60%;">Función</th>
            </tr>
        <?php 
            foreach ($listado as $shows)
            {
                if($shows->getId_movie()==$_SESSION["idMovieSearch"] && $shows->getStatus()==true){ //agregar filtrar por date 
                ?>
            <tr>
                
                <td><?php foreach($movieTheaters as $mt)
                {
                    if($shows->getId_cinema() == $mt->getId())
                    {
                        echo $mt->getName(); 
                    }
                }?></td>
                <td><?php echo $shows->getDate() . " " . $shows->getTime(); ?></td>
                <td> <input type="radio" name="idShow" id = "idShow" value="<?php echo  $shows->getId(); ?>"><br></td>
                <td><input type="hidden" value="<?php $shows->getId_cinema(); ?>" name="idCinema"></td>


                
            </tr>
            <?php
                }
            }
        ?>
        </table>
        <br><button name="submit" type="submit">Continuar</button>
    </form>
  </div>
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