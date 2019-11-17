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
                <td><?php echo "**** **** **** " . substr( $cc->getNumber(), -4 ); ?></td>
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
            
        <?php 
            } 
        ?>

    </table>
    <tr colspan="4">
        <div class="addCreditCard" align="center">
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#addCreditCard">Agregar Tarjeta</button>
        </div>
    </tr>

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

    <!-- MODAL -->
<div class="modal fade" id="addCreditCard">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo "Agregar Tarjeta "; ?></h4>
                    <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container fluid">
                        <div class="row">

                            <form action="<?php echo FRONT_ROOT ?>CreditCard/addCreditCard" method="post">
                                <div class="form-group">
                                    <label for="company">
                                        <h5>Compañía</h5>
                                    </label>
                                    <select id="company" name="company">
                                    <option value="Visa">Visa</option>
                                    <option value="Master">Master</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="number">
                                        <h5>Número de Tarjeta</h5>
                                    </label>
                                    <input type="number" style="width:170px" id="cardNumber" name="cardNumber" min="15" max="16" placeholder="Número de Tarjeta"  required  title="Solo números"><br>
                                </div>
                                <div class="form-group">
                                    <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Agregar</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    


    <?php require_once(VIEWS_PATH . "footer.php"); ?>