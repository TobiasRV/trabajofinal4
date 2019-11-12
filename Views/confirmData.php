<body class="home">

<?php



if ($userControl->checkSession() != false) {
    if ($_SESSION["loggedUser"]->getPermissions() == 2) {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); 
    }
}
?>


    <html>
        <br><h5>DATOS DE LA COMPRA</h5>
    <table class="table table-striped">
        <tbody>
                <tr>
                    <th scope="row">Fecha</th>
                    <td><?php echo $_SESSION["purchase"]->getPurchaseDate(); ?></td>
                </tr>
                <tr>
                    <th scope="row">Tickets</th>
                    <td><?php echo $_SESSION["purchase"]->getQuantityTickets(); ?></td>
                </tr>
                <tr>
                    <th scope="row">Película</th>
                    <td><?php 
                            foreach($listMovies as $lm)
                            {
                                if($lm->getIdMovie() == $_SESSION["idMovieSearch"])
                                {
                                    echo $lm->getMovieTitle($_SESSION["idMovieSearch"]);
                                }
                            }
                        ?></td>
                </tr>
                <tr>
                    <th scope="row">Cine</th>
                    <td><?php echo "No se como ponerlo :c"; ?></td>
                </tr>
                <tr>
                    <th scope="row">Función</th>
                    <td><?php echo $listadoShows->getShowData($_SESSION["purchase"]->getIdShow()); ?></td>
                </tr>
                <tr>
                    <th scope="row">Compañía de la Tarjeta</th>
                    <td><?php echo $_SESSION["creditCard"]->getCompany(); ?></td>
                </tr>
                <tr>
                    <th scope="row">Número de la Tarjeta</th>
                    <td><?php echo $_SESSION["creditCard"]->getNumber(); ?></td>
                </tr>
                <tr>
                    <th scope="row">Descuento</th>
                    <td><?php echo $_SESSION["purchase"]->getDiscount(); ?></td>
                </tr>
                <tr>
                    <th scope="row">Total de la Compra</th>
                    <td><?php echo $_SESSION["purchase"]->getTotal(); ?></td>
                </tr>
        </tbody>
    </table>

    <br>
    <br>
                <form action="<?php echo FRONT_ROOT ?>Purchase/checkButton">
                <input type="submit" value="confirmPurchase" />CONFIRMAR
                </form>
                <form action="<?php echo FRONT_ROOT ?>Purchase/checkButton">
                <input type="submit" value="cancelPurchase" />CANCELAR
                </form>

</html>

<?php 

include_once(VIEWS_PATH . "footer.php"); 

