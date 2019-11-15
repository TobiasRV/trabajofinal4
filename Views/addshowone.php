<?php

require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");

?>

<body class="home">
    <div class="container">
        <h1>Crear Funcion</h1>
        <div class="form-group">
            <label for="movieTheaterName">Cine</label>
            <input class="form-control" type="text" id="movieTheaterName" name="movieTheaterName" value="<?php echo $movieTheaterName; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="cinemaName">Sala</label>
            <input class="form-control" type="text" id="cinemaName" name="cinemaName" value="<?php echo $cinemaName; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="date">Fecha</label><br>
            <div class="row">
                <div class="col-6">
                    <input class="form-control" type="date" id="date" name="date" value="" disabled><br>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalAdd"><span class="fas fa-plus"></span> Seleccionar</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-6">
                <a class="btn btn-danger btn-block" href="<?php echo FRONT_ROOT; ?>/MovieTheater/ListCinemas" role="button">Cancelar</a>
            </div>
        </div>
    </div>

    <!-- Modal set DATE -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seleccionar Fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo FRONT_ROOT ?>Show/addShowTwo" method="post">
                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheaterName; ?>">
                        <input id="cinemaName" name="cinemaName" type="hidden" value="<?php echo $cinemaName; ?>">
                        <input class="form-control" type="date" id="date" name="date" value="" min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button name="summit" type="summit" class="btn btn-primary btn-success btn-block">Cargar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once(VIEWS_PATH . "footer.php"); ?>