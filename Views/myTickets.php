<html>
<body class="home">

<?php 

include_once(VIEWS_PATH . "header.php"); 


if ($userControl->checkSession() != false) 
{
    if ($_SESSION["loggedUser"]->getPermissions() == 2) 
    {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); 
    }
}
?>


        <br><h5>MIS TICKETS</h5>
    <table class="table table-striped">
        <tbody>
                <tr>
                    <th scope="row">ID Compra</th>

                    <th scope="row">Fecha de Compra</th>
                
                    <th scope="row">Ticket N°</th>
                </tr>
                <?php 
                if($listadoCC != null)
                {
                    foreach($listadoCC as $cc)
                    {
                        if($cc->getIdUser() == $_SESSION["loggedUser"]->getId())
                        {
                            if($listadoP != null)
                            {
                                foreach($listadoP as $p)
                                {
                                    if($p->getIdCreditCard() == $cc->getId())
                                    {
                                        if($listadoT != null)
                                        {
                                            foreach($listadoT as $t)
                                            {
                                                if($p->getIdPurchase() == $t->getIdPurchase())
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $p->getIdPurchase(); ?></td>
                                                        <td><?php echo $p->getPurchaseDate(); ?></td>
                                                        <td><?php echo $t->getIdTicket(); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                ?>
        </tbody>
    </table>

    <?php 
        include_once(VIEWS_PATH . "footer.php"); 
    ?>

</html>