<?php


require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");
        ?>


<body class="home">
    <div class="container">
        <h1>Dar de alta Cine</h1>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input class="form-control" type="text" id="name" name="name" value="<?php echo $movieTheater->getName(); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="address">Dirección</label>
            <input class="form-control" type="text" id="address" name="address" value="<?php echo $movieTheater->getAddress(); ?>" disabled>
        </div>


        <!-- TABLA CARTELERA -->

        <h2>Cartelera</h2>
        <br>
        <table class="table table-hover table-condensed table-bordered table-dark">
            <tr>
                <td>ID</td>
                <td>Nombre</td>
                <td>Generos</td>
            </tr>

            <?php foreach ($movieTheaterBillBoard as $movie) { ?>
                <tr>
                    <td><?php echo $movie->getIdMovie(); ?></td>
                    <td><?php echo $movie->getTitle(); ?></td>
                    <td><?php foreach ($movie->getIdGenre() as $genre) {
                                foreach ($arrayGeneros as $gen) {
                                    if ($gen->getId() == $genre) {
                                        echo $gen->getName() . "<br>";
                                    }
                                }
                            } ?></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <h2>Salas</h2>
        <br>

        <!-- TABLA SALAS -->
        <table class="table table-hover table-condensed table-bordered table-dark">
            <tr>
                <td>Nombre de la sala</td>
                <td>Nº Asientos</td>
                <td>Precio</td>
            </tr>
            <?php foreach ($cinemaList as $cinema) { ?>
                <tr>
                    <td><?php echo $cinema->getName(); ?></td>
                    <td><?php echo $cinema->countSeats(); ?></td>
                    <td><?php echo $cinema->getTicketPrice(); ?></td>
                </tr>
            <?php } ?>
        </table>




        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col col-lg-2">
                    <form action="<?php echo FRONT_ROOT; ?>MovieTheater/backToViewOne" method="post">
                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                        <button name="summit" type="summit" class="btn btn-danger btn-block">Cancelar</button>
                    </form>
                </div>
                <div class="col col-lg-4">
                    <form action="<?php echo FRONT_ROOT; ?>MovieTheater/listCinemas" method="post">
                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                        <button name="summit" type="summit" class="btn btn-primary btn-success btn-block">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
        <br><br><br>
    </div>

    <!-- Modal ADD -->
    <?php foreach ($cinemaList as $cinema) { ?>
        <div class="modal fade" id="modalAdd<?php echo $cinema->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Show a la sala: <?php echo $cinema->getName(); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo FRONT_ROOT ?>MovieTheater/viewAddCinema" method="post">
                            <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                            <div class="form-group">
                                <label for="cinemaName">Nombre</label>
                                <input class="form-control" type="text" id="cinemaName" name="cinemaName" placeholder="Nombre de la Sala" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                            </div>
                            <div class="form-group">
                                <label for="seats">Nº de Asientos</label>
                                <input id="seats" name="seats" placeholder="Cantidad de Asientos" type="number" required="required" class="form-control" min=1 max=100 title="Solo números entre 1 y 100">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button name="summit" type="summit" class="btn btn-primary btn-success btn-block">Cargar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    <?php } ?>
    <?php include_once(VIEWS_PATH . "footer.php"); ?>