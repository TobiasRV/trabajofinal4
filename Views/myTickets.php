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
        if(is_array($listadoCC))
        { 
            foreach($listadoCC as $cc)
            {
                if($cc->getIdUser() == $_SESSION["loggedUser"]->getId())
                {
                    if($listadoP != null)
                    {
                        if(is_array($listadoP))
                        {
                            foreach($listadoP as $p)
                            {
                                if($p->getIdCreditCard() == $cc->getId())
                                {
                                    if($listadoT != null)
                                    {
                                        if(is_array($listadoT))
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
                                        else //fin is_array($listadoT)
                                        {
                                            if($p->getIdPurchase() == $listadoT->getIdPurchase())
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $p->getIdPurchase(); ?></td>
                                                    <td><?php echo $p->getPurchaseDate(); ?></td>
                                                    <td><?php echo $listadoT->getIdTicket(); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else //fin if(is_array($listadoP))
                        {
                            if($listadoP->getIdCreditCard() == $cc->getId())
                            {
                                if($listadoT != null)
                                {
                                    if(is_array($listadoT))
                                    {
                                        foreach($listadoT as $t)
                                        {
                                            if($listadoP->getIdPurchase() == $t->getIdPurchase())
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $listadoP->getIdPurchase(); ?></td>
                                                    <td><?php echo $listadoP->getPurchaseDate(); ?></td>
                                                    <td><?php echo $t->getIdTicket(); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    else //fin is_array($listadoT)
                                    {
                                        if($listadoP->getIdPurchase() == $listadoT->getIdPurchase())
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $listadoP->getIdPurchase(); ?></td>
                                                <td><?php echo $listadoP->getPurchaseDate(); ?></td>
                                                <td><?php echo $listadoT->getIdTicket(); ?></td>
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
        } //fin if(is_array($listadoCC))
        else
        {
            if($listadoCC->getIdUser() == $_SESSION["loggedUser"]->getId())
            {
                if($listadoP != null)
                {
                    if(is_array($listadoP))
                    {
                        foreach($listadoP as $p)
                        {
                            if($p->getIdCreditCard() == $listadoCC->getId())
                            {
                                if($listadoT != null)
                                {
                                    if(is_array($listadoT))
                                    {
                                        foreach($listadoT as $t)
                                        {
                                            if($listadoP->getIdPurchase() == $t->getIdPurchase())
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $listadoP->getIdPurchase(); ?></td>
                                                    <td><?php echo $listadoP->getPurchaseDate(); ?></td>
                                                    <td><?php echo $t->getIdTicket(); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    else //fin is_array($listadoT)
                                    {
                                        if($listadoP->getIdPurchase() == $listadoT->getIdPurchase())
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $listadoP->getIdPurchase(); ?></td>
                                                <td><?php echo $listadoP->getPurchaseDate(); ?></td>
                                                <td><?php echo $listadoT->getIdTicket(); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                    else //fin if(is_array($listadoP))
                    {
                        if($listadoP->getIdCreditCard() == $listadoCC->getId())
                        {
                            if($listadoT != null)
                            {
                                if(is_array($listadoT))
                                {
                                    foreach($listadoT as $t)
                                    {
                                        if($listadoP->getIdPurchase() == $t->getIdPurchase())
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $listadoP->getIdPurchase(); ?></td>
                                                <td><?php echo $listadoP->getPurchaseDate(); ?></td>
                                                <td><?php echo $t->getIdTicket(); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                else //fin is_array($listadoT)
                                {
                                    if($listadoP->getIdPurchase() == $listadoT->getIdPurchase())
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $listadoP->getIdPurchase(); ?></td>
                                            <td><?php echo $listadoP->getPurchaseDate(); ?></td>
                                            <td><?php echo $listadoT->getIdTicket(); ?></td>
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

                ?>
        </tbody>
    </table>

    <?php 
        include_once(VIEWS_PATH . "footer.php"); 
    ?>

</html>