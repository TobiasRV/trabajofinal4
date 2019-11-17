<?php
    require_once(VIEWS_PATH . "header.php");
    require_once(VIEWS_PATH . "navClient.php");
?>

<body class="home">
    <h1>MIS TARJETAS</h1>

    <table class="table table-hover table-condensed table-bordered table-dark">
        <tr>
            <td>Compañía</td>
            <td>Número</td>
            <td>Estado</td>
        </tr>

        <?php foreach ($listadoCC as $cc) { ?>
            <tr>
                <td><?php echo $cc->getCompany(); ?></td>
                <td><?php echo $cc->getNumber(); ?></td>
                <td><?php 
                if($cc->getStatus()==true)
                {
                    ?>
                        <p style="color:green;">Activo</p>
                    <?php
                }
                else
                {
                    ?>
                        <p style="color:red;">Inactivo</p>
                    <?php
                } ?></td>
                <td width="20%" align="center">
                    <form id="changeStatus" action="<?php FRONT_ROOT ?>changeStatus" method="POST">
                    <input type="hidden" name="idCreditCard" id="idCreditCard" value="<?php echo $cc->getId() ?>">
                    <input class="btn btn-outline-secondary" type="submit" name="changeStatus" id="changeStatus" value="Cambiar Estado" onclick="return confirm('¿Está seguro que desea cambiar el estado de su tarjeta?');">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <script>
     $(function(){
    $('a#<?php echo FRONT_ROOT?>User/logOut').click(function(){
        if(confirm('¿Está seguro que desea cerrar sesión?')) {
            return true;
        }

        return false;
        });
    });
    </script>
    
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


    <?php require_once(VIEWS_PATH . "footer.php"); ?>