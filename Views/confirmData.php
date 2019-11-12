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
                    <td><?php echo $nameMovie; ?></td>
                </tr>
                <tr>
                    <th scope="row">Cine</th>
                    <td><?php echo $_SESSION["nameMovieTheater"]; ?></td>
                </tr>
                <tr>
                    <th scope="row">Función</th>
                    <td><?php echo $showData; ?></td>
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
                    <td><?php if($_SESSION["purchase"]->getDiscount()==null)
                    {
                        echo "-";
                    }
                    else
                    {
                        echo "25%";
                    } 
                    ?></td>
                </tr>
                <tr>
                    <th scope="row">Total de la Compra</th>
                    <td><?php echo "$" . $_SESSION["purchase"]->getTotal(); ?></td>
                </tr>
        </tbody>
    </table>

    <br>
    <br>
    <div class="buttons" align="center">
                <form action="<?php echo FRONT_ROOT ?>Purchase/checkButton" method="POST">
                <input type="submit" name="confirmPurchase" id="button" value="CONFIRMAR"/>
                </form>
                <form action="<?php echo FRONT_ROOT ?>Purchase/checkButton" method="POST">
                <input type="submit" name="cancelPurchase" id="button" value="CANCELAR"/>
                </form>
    </div>
</html>

<?php 

include_once(VIEWS_PATH . "footer.php"); 

