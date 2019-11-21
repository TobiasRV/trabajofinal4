<?php


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


        <!-- TABLA -->

        <h2>Cargar cartelera</h2>
        <caption>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><span class="fas fa-plus"></span> Seleccionar</button>
        </caption>
        <br>
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

        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col col-lg-2">
                    <form action="<?php echo FRONT_ROOT; ?>MovieTheater/backToViewOne" method="post">
                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                        <button name="summit" type="summit" class="btn btn-danger btn-block">Cancelar</button>
                    </form>
                </div>
                <div class="col col-lg-4">
                    <form action="<?php echo FRONT_ROOT; ?>MovieTheater/viewCreateMovieTheaterThree" method="post">
                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
                        <button name="summit" type="summit" class="btn btn-primary btn-success btn-block">Continuar</button>
                    </form>
                </div>
            </div>
            <br><br><br>
        </div>

    </div>

    <!-- Modal ADD -->

    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seleccionar peliculas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo FRONT_ROOT ?>MovieTheater/viewAddBillBoard" method="post">
                        <input id="movieTheaterName" name="movieTheaterName" type="hidden" value="<?php echo $movieTheater->getName(); ?>">
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
                                <?php foreach ($nowPlaying as $val) {  ?>
                                    <tr>
                                        <th scope="col"><input type="checkbox" name="moviechecked[]" value="<?php echo $val->getIdMovie(); ?>" /></th>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button name="summit" type="summit" class="btn btn-primary btn-success btn-block">Cargar</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <?php include_once(VIEWS_PATH . "footer.php"); ?>