<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");

?>

<body class="home">
    <h1>Listado de Cines</h1>

    <table class="table table-hover table-condensed table-bordered table-dark">
        <tr>
            <td>Nombre</td>
            <td>Direccion</td>
            <td>Cartelera</td>
            <td>Salas</td>
            <td>Modificar</td>
        </tr>

        <?php foreach ($movieTheaterList as $movieTheater) { ?>
            <tr>
                <td><?php echo $movieTheater->getName(); ?></td>
                <td><?php echo $movieTheater->getAddress(); ?></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCartelera<?php echo $movieTheater->getId(); ?>">Cartelera</button>
                </td>
                <td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSalas<?php echo $movieTheater->getId(); ?>">Salas</button>
                </td>
                <td>MODIFICAR</td>
            </tr>
        <?php } ?>
    </table>

    <!-- MODAL CARTELERA -->

    <?php foreach ($movieTheaterList as $movieTheater) { ?>
        <div class="modal fade" id="modalCartelera<?php echo $movieTheater->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cartelera del Cine: <?php echo $movieTheater->getName(); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed table-bordered">
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td>Generos</td>
                            </tr>

                            <?php $movieTheaterBillBoard = $this->movieController->getMovieListByIdList($movieTheater->getBillBoard());
                                foreach ($movieTheaterBillBoard as $movie) { ?>
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
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

    <!-- MODAL SALAS -->

    <?php foreach ($movieTheaterList as $movieTheater) { ?>
        <div class="modal fade" id="modalSalas<?php echo $movieTheater->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Salas del Cine: <?php echo $movieTheater->getName(); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php $cinemaList = $this->cinemaController->getCinemaList($movieTheater->getId());
                            $movieTheaterBillBoard = $this->movieController->getMovieListByIdList($movieTheater->getBillBoard());
                            foreach ($cinemaList as $cinema) { ?>
                            <h3><?php echo $cinema->getName() . " | Asientos: " . $cinema->countSeats(); ?></h3>
                            <form action="<?php echo FRONT_ROOT; ?>Show/addShowOne" method="post">
                                <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                                <input id="cinemaName" name="cinemaName" type="hidden" value="<?php echo $cinema->getName(); ?>">
                                <button name="summit" type="summit" class="btn btn-primary"><span class="fas fa-plus"></span> Cargar Función</button>
                            </form>
                            <br>
                            <table class="table table-hover table-condensed table-bordered">
                                <tr>
                                    <td>Fecha</td>
                                    <td>Hora</td>
                                    <td>Pelicula</td>
                                    <td>Borrar</td>
                                </tr>
                                <?php $showList = $this->showController->getShowListByCinema($cinema->getId());
                                        foreach ($showList as $show) { ?>
                                    <tr>
                                        <td><?php echo $show->getDate(); ?></td>
                                        <td><?php echo $show->getTime(); ?></td>
                                        <td><?php foreach ($movieTheaterBillBoard as $movie) {
                                                            if ($movie->getIdMovie() == $show->getIdMovie())
                                                                echo $movie->getTitle();
                                                        } ?></td>
                                        <td>BOTON</td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>


    <?php require_once(VIEWS_PATH . "footer.php"); ?>