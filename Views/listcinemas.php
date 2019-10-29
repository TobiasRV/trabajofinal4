<?php include_once(VIEWS_PATH . "header.php"); ?>

<body>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
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
                            ?></td>
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
                    <td>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cinemaModify<?php echo $cine->getId(); ?>">Modificar</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php include_once(VIEWS_PATH . "footer.php"); ?>



    <!-- MODAL -->
    <div class="modal fade" id="cinemaModify<?php echo $cine->getId(); ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo "Modificar Cine: " . $cine->getName(); ?></h4>
                    <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container fluid">
                        <div class="row">

                            <form action="<?php echo FRONT_ROOT ?>Cinema/modifyCinema" method="post">
                                <div class="form-group">
                                    <label for="id">
                                        <h5>ID</h5>
                                    </label>
                                    <input class="form-control" type="text" id="id" name="id" value="<?php echo $cine->getId(); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">
                                        <h5>Nombre</h5>
                                    </label>
                                    <input class="form-control" type="text" id="name" name="name" placeholder="Nombre del Cine" value="<?php echo $cine->getName(); ?>" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                                </div>
                                <div class="form-group">
                                    <label for="address">
                                        <h5>Dirección</h5>
                                    </label>
                                    <input class="form-control" type="text" id="address" name="address" placeholder="Direccion del Cine" value="<?php echo $cine->getAddress(); ?>" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
                                </div>
                                <div class="form-group">
                                    <label for="seats">
                                        <h5>Nº Asientos</h5>
                                    </label>
                                    <input id="seats" name="seats" placeholder="Cantidad de Asientos" type="number" required="required" value="<?php echo count($cine->getSeats()); ?>" class="form-control" min=1 max=50 title="Solo números entre 1 y 50">
                                </div>
                                <div class="form-group">
                                    <label for="price">
                                        <h5>Precio</h5>
                                    </label>
                                    <input id="price" name="price" placeholder="Valor de la Entrada" type="number" required="required" value="<?php echo $cine->getTicketPrice(); ?>" class="form-control" min=1 max=3000 title="Solo números entre 1 y 3000">
                                </div>
                                <div class="form-group">
                                    <label for="status">
                                        <h5>Estado</h5>
                                    </label><br>
                                    <input type="checkbox" name="status" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" data-width="100" <?php if ($cine->getStatus() == true) echo "checked"; ?>>
                                </div>
                                <br>
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
                                <div class="form-group">
                                    <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Modificar</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>