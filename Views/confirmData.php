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

    <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>¡Atención!</strong> Corrobore que los datos sean correctos y confirme su compra.
    </div>
    <h2 class="card-header info-color white-text text-center py-4">
        <strong>DATOS DE LA COMPRA</strong>
    </h2>
    <table class="table table-striped table-dark">
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
                    <td><?php echo "**** **** **** " . substr($_SESSION["creditCard"]->getNumber(), -4); ?></td>
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
                <tr>
                    <td>
                        <form action="<?php echo FRONT_ROOT ?>Purchase/checkButton" method="POST">
                        <input type="submit" style="width:100%" class="btn btn-lg btn-danger" name="cancelPurchase" id="button" value="CANCELAR"/>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo FRONT_ROOT ?>Purchase/checkButton" method="POST">
                        <input type="submit" style="width:100%" class="btn btn-lg btn-success" name="confirmPurchase" id="button" value="CONFIRMAR"/>
                        </form>
                    </td>
                </tr>
        </tbody>
    </table>

</html>

<?php 

include_once(VIEWS_PATH . "footer.php"); 

