<body class="home">

<?php include_once(VIEWS_PATH . "header.php"); ?>

<body>

    <?php
    include_once(VIEWS_PATH . "navAdmin.php");

    use DAO\CinemaRepository as CinemaRepository;
    use Controllers\MovieController as MovieController;

    $repo = new CinemaRepository();

    $movieController = new MovieController();
    $nowPlaying = $movieController->getNowPlaying();
    $arrayGeneros = $movieController->getGenres();

    $listado = $repo->getAll();
    ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Asientos</th>
                <th scope="col">Cartelera</th>
                <th scope="col">Precio</th>
                <th scope="col">Estado</th>
                <th scope="col">Modificar</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($listado as $cine) { ?>
                <tr>
                    <th scope="row"><?php echo $cine->getId(); ?></th>
                    <td><?php echo $cine->getName(); ?></td>
                    <td><?php echo $cine->getAddress(); ?></td>
                    <td><?php echo $cine->getSeatsNumer(); ?></td>
                    <td><?php
                            $arrayPelicula = $cine->getBillBoard();
                            $i = 1;
                            foreach ($arrayPelicula as $pelicula) {
                                echo $i . ") " . $pelicula->getTitle() . "<br>";
                                $i++;
                            }
                            ?>
                    </td>
                    <td><?php echo "$" . $cine->getTicketPrice(); ?></td>
                    <td><?php
                            if ($cine->getStatus()) {
                                ?>
                            <p class="text-success">Activo</p>
                        <?php } else {
                                ?><p class="text-danger">Inactivo</p>
                        <?php }
                            ?>
                    </td>
                    <td> <a href="#cinemaModify<?php echo $cine->getId(); ?>" class="btn btn-info" data-toggle="modal">Modificar</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    foreach ($listado as $cine) { ?>

        <!-- MODAL -->
        <div class="modal fade" id="cinemaModify<?php echo $cine->getId(); ?>">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- HEADER DE LA VENTANA -->
                    <div class="modal-header">
                        <h2 class="modal-title"><?php echo "Modificar Cine: " . $cine->getName(); ?></h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- CONTENIDO DE LA VENTANA -->
                    <div class="modal-body">

                        <form action="<?php echo FRONT_ROOT ?>Cinema/modifyCinema" method="post">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input class="form-control" type="text" id="id" name="id" value="<?php echo $cine->getId(); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="Nombre del Cine" value="<?php echo $cine->getName(); ?>" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                            </div>


                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input class="form-control" type="text" id="address" name="address" placeholder="Direccion del Cine" value="<?php echo $cine->getAddress(); ?>" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                            </div>


                            <div class="form-group">
                                <label for="seats">Nº Asientos</label>
                                <input id="seats" name="seats" placeholder="Cantidad de Asientos" type="number" required="required" value="<?php echo count($cine->getSeats()); ?>" class="form-control" min=1 max=50 title="Solo números entre 1 y 50">
                            </div>


                            <div class="form-group">
                                <label for="price">Precio</label>
                                <input id="price" name="price" placeholder="Valor de la Entrada" type="number" required="required" value="<?php echo $cine->getTicketPrice(); ?>" class="form-control" min=1 max=3000 title="Solo números entre 1 y 3000">
                            </div>

                            <div class="form-group">
                                <label for="status">Estado</label><br>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" data-width="100" <?php if ($cine->getStatus() == true) echo "checked"; ?>>
                            </div>

                            <div class="form-group">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Generos</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $arrayPeliculas = $cine->getBillBoard();
                                            foreach ($nowPlaying as $val) {  ?>
                                            <tr>
                                                <?php
                                                        $validacion = false;

                                                        foreach ($arrayPeliculas as $pelicula) {
                                                            if ($val->getTitle() == $pelicula->getTitle()) {
                                                                $validacion = true;
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                <th scope="col"><input type="checkbox" name="moviechecked[]" value="<?php echo $val->getTitle(); ?>" <?php if ($validacion) echo "checked"; ?> /></th>

                                                <th scope="row"><?php echo $val->getIdMovie(); ?></th>
                                                <td><?php echo $val->getTitle(); ?></td>
                                                <td><?php
                                                            $generosPelicula = $val->getIdGenre();
                                                            foreach ($generosPelicula as $genero) {
                                                                foreach ($arrayGeneros as $gen) {
                                                                    if ($gen->getId() == $genero) {
                                                                        echo $gen->getName() . "<br>";
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                </td>
                                            </tr>
                                    </tbody>
                                <?php }  ?>
                                </table>
                            </div>
                    </div>

                    <!-- FOOTER DE LA VENTANA -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Guardar Cambios</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }





    include_once(VIEWS_PATH . "footer.php"); ?>