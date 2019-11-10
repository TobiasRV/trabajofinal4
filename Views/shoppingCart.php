<body class="home">

<?php 

include_once(VIEWS_PATH . "header.php"); 

use Controllers\UserController as UserController;
use DAO\MovieRepository as MovieRepository;
use DAO\ShowRepository as ShowRepository;

$showRepo = new ShowRepository();
$listado = $showRepo->getAll();

if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); ?>
        <body>

    <div class="container" align="center">
    <h2 class="mb-4">Carrito</h2>
    <form action="<?php echo FRONT_ROOT ?>Ticket/cartPurchase" method="post">
        <!-- <input type="hidden" id="id" name="id" value=""> -->
        <!-- <label for="cinema_id">Método de Pago</label><br>
        <select style="width:170px">
        <option value="Visa">Tarjeta de Crédito Visa</option>
        <option value="Master">Tarjeta de Crédito Master</option>
        </select><br> -->


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
        <?php 
            foreach ($listado as $shows)
            {
                if($shows->getId_movie()==$idMovie){
                ?>
            <tr class="header">
                <th style="width:60%;"><?php echo $shows->getId_cinema(); ?></th>
                <th style="width:40%;"><?php echo $shows->getDate() . $shows->getTime(); ?></th>
            </tr>
            <?php
                }
            }
        ?>
        </table>
        <label for="discount">Descuento</label><br>
        <input id="discount" name="discount" type="number" value="<?php //valor del descuento si es que esta habilitado para la compra ?>" readonly><br>
        <input id="emailUser" name="emailUser" type="hidden" required value="<?php echo $_SESSION["loggedUser"]->getEmail(); ?>">
        <br><button name="submit" type="submit">Comprar</button>
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