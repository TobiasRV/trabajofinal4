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
    <form action="<?php echo FRONT_ROOT ?>Purchase/continuePurchase2" method="POST">
        <!-- <input type="hidden" id="id" name="id" value=""> -->

        <script>
                function myFunction() {
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



        <label for="quantityTickets">Funciones</label><br>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar por cine..">
        <table id="myTable">
            <tr class="header">
                <th style="width:60%;">Cine</th>
                <th style="width:40%;">Función</th>
            </tr>
        <?php 
            foreach ($listado as $shows)
            {
                if($shows->getId_movie()==$_SESSION["purchaseSession"]->getMovieId() && $shows->getStatus()==true){ //agregar filtrar por date 
                ?>
            <tr>
                <td><?php echo $shows->getId_cinema(); ?></td>
                <td><?php echo $shows->getDate() . $shows->getTime(); ?></td>
            </tr>
            <?php
                }
            }//crear funcion que controle que haya disponibilidad en caso de que no haya que cambie el status a false
        ?>
        </table>
        <label for="discount">Descuento</label><br>
        <input id="discount" name="discount" type="number" value="<?php //valor del descuento si es que esta habilitado para la compra ?>" readonly><br>
        <input id="emailUser" name="emailUser" type="hidden" required value="<?php echo $_SESSION["loggedUser"]->getEmail(); ?>">
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