<body class="home">
    <h1>Listado de Cines</h1>

    <table class="table table-hover table-condensed table-bordered table-dark">
        <tr>
            <td>Nombre</td>
            <td>Direccion</td>
            <td>Cartelera</td>
            <td>Salas</td>
            <td>Estado</td>
            <td>Modificar</td>
        </tr>

        <?php foreach ($movieTheaterList as $movieTheater) { ?>
            <tr>
                <td><?php echo $movieTheater->getName(); ?></td>
                <td><?php echo $movieTheater->getAddress(); ?></td>

                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCartelera<?php echo $movieTheater->getId(); ?>">Cartelera</button>
                </td>

                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSalas<?php echo $movieTheater->getId(); ?>">Salas</button>
                </td>

                <td><?php
                        if ($movieTheater->getStatus() == 1) {
                            ?>
                        <p class="text-success">Activo</p>
                    <?php } else {
                            ?><p class="text-danger">Inactivo</p>
                    <?php }
                        ?>
                </td>

                <td>
                    <button type="button" class="btn btn-warning fas fa-edit" data-toggle="modal" data-target="#modalModificar<?php echo $movieTheater->getId(); ?>"></button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- MODAL MODIFICAR -->
    <?php foreach ($movieTheaterList as $movieTheater) { ?>
        <div class="modal fade" id="modalModificar<?php echo $movieTheater->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>¡Atención!</strong> Si da de baja un cine o si quita una pelicula de cartelera y este tiene funciones, las mismas se mantendrán.
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modificar Cine: <?php echo $movieTheater->getName(); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo FRONT_ROOT ?>MovieTheater/modifyMovieTheaterFromList" method="post">
                            <input id="id" name="id" type="hidden" value="<?php echo $movieTheater->getId(); ?>">

                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input class="form-control" value="<?php echo $movieTheater->getName(); ?>" type="text" id="name" name="name" placeholder="Nombre del Cine" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                            </div>
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input class="form-control" value="<?php echo $movieTheater->getAddress(); ?>" type="text" id="address" name="address" placeholder="Direccion del Cine" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                            </div>
                            <div class="form-group">
                                <label for="status">Estado</label><br>
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" name="status" value="1" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" data-width="100" <?php if ($movieTheater->getStatus() == true) echo "checked"; ?>>
                            </div>
                            <div class="form-group">
                                <label>Cartelera</label><br>
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th scope="col">Estado</th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Generos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($nowPlaying as $val) {  ?>
                                            <tr>
                                                <?php $moviesOnBoard = $movieTheater->getBillBoard();
                                                        $validation = false;

                                                        foreach ($moviesOnBoard as $idMovie) {
                                                            if ($val->getIdMovie() == $idMovie) {
                                                                $validation = true;
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                <th scope="col">
                                                    <input type="checkbox" name="billBoard[]" value="<?php echo $val->getIdMovie(); ?>" <?php if ($validation) echo "checked"; ?> data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" data-width="100">
                                                </th>

                                                <th scope="row"><?php echo $val->getIdMovie(); ?></th>
                                                <td><?php echo $val->getTitle(); ?></td>
                                                <td><?php
                                                            $generosPelicula = $val->getIdGenre();

                                                            foreach ($generosPelicula as $genero) {
                                                                foreach ($arrayGeneros as $gen) {
                                                                    if ($gen->getId() == $genero) {
                                                                        echo $gen->getName() . " ";
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                </td>
                                            </tr>
                                    </tbody>
                                <?php }  ?>
                                </table>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button name="summit" type="summit" class="btn btn-primary btn-success btn-block">Cargar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

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

                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h2><?php echo $cinema->getName(); ?></h2>
                                        <table class="table table-hover table-condensed table-bordered">
                                            <tr>
                                                <td>Nº Asientos</td>
                                                <td>Precio</td>
                                                <td>Estado</td>
                                                <td>Modificar</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $cinema->countSeats(); ?></td>
                                                <td><?php echo "$" . $cinema->getTicketPrice(); ?></td>
                                                <td><?php if ($cinema->getStatus() == 1) { ?>
                                                        <p class="text-success">Activo</p>
                                                    <?php } else { ?>
                                                        <p class="text-danger">Inactivo</p>
                                                    <?php } ?></td>
                                                <td>
                                                    <form action="<?php echo FRONT_ROOT; ?>Cinema/viewModifyCinema" method="post">
                                                        <input id="idCinema" name="idCinema" type="hidden" value="<?php echo $cinema->getId(); ?>">
                                                        <button name="summit" type="summit" class="btn btn-warning"><span class="fas fa-edit"></span></button>
                                                    </form>
                                                </td>
                                            </tr>


                                        </table>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h2>Funciones </h2>
                                                </div>
                                                <div class="col-3">
                                                    <form action="<?php echo FRONT_ROOT; ?>Show/addShowOne" method="post">
                                                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                                                        <input id="cinemaName" name="cinemaName" type="hidden" value="<?php echo $cinema->getName(); ?>">
                                                        <button name="summit" type="summit" class="btn btn-primary"><span class="fas fa-plus"></span> Cargar Función</button>
                                                    </form>
                                                </div>
                                                <div class="col-3"></div>
                                            </div>
                                            <br>
                                            <table class="table table-hover table-condensed table-bordered">
                                                <tr>
                                                    <td>Fecha</td>
                                                    <td>Hora</td>
                                                    <td>Pelicula</td>
                                                    <td>Borrar</td>
                                                </tr>
                                                <?php $showList = $this->showController->getShowListByCinemaByDate($cinema->getId());
                                                        foreach ($showList as $show) { ?>
                                                    <tr>
                                                        <td><?php echo $show->getDate(); ?></td>
                                                        <td><?php echo $show->getTime(); ?></td>
                                                        <td><?php foreach ($movieTheaterBillBoard as $movie) {
                                                                            if ($movie->getIdMovie() == $show->getIdMovie())
                                                                                echo $movie->getTitle();
                                                                        } ?></td>
                                                        <td>
                                                            <form action="<?php echo FRONT_ROOT; ?>Show/deleteShowByIdAndView" method="post">
                                                                <input id="id" name="id" type="hidden" value="<?php echo $show->getId(); ?>">
                                                                <button name="summit" type="summit" class="btn btn-danger fas fa-trash-alt"></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>

                        <!-- ACA TERMINA body -->
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


    <?php require_once(VIEWS_PATH . "footer.php"); ?>