<?php

require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");

?>

<body class="home">
    <div class="container">
        <form action="<?php echo FRONT_ROOT ?>Show/createShow" method="post">
            <h1>Crear Funcion</h1>
            <div class="form-group">
                <label for="movieTheaterName">Cine</label>
                <input class="form-control" type="text" id="movieTheaterName" name="movieTheaterName" value="<?php echo $movieTheaterName; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="cinemaName">Sala</label>
                <input class="form-control" type="text" id="cinemaName" name="cinemaName" value="<?php echo $cinemaName; ?>" disabled>
                <input class="form-control" type="text" id="idCinema" name="idCinema" value="<?php echo $idCinema; ?>" hidden>
            </div>
            <div class="form-group">
                <label for="date">Fecha</label><br>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="date" id="date" name="date" value="<?php echo $date; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="time">Horario</label><br>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="text" id="time" name="time" value="<?php echo $time; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="idMovie">Película</label>
                <!-- TABLA CARTELERA -->
                <table class="table table-hover table-condensed table-bordered table-dark">
                    <tr>
                        <td>Selección</td>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Generos</td>
                    </tr>
                    <?php foreach ($freeMovies as $movie) { ?>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label><input type="radio" name="idMovie" id="idMovie" value="<?php echo $movie->getIdMovie(); ?>" onchange="activarBoton()"></label>
                                </div>
                            </td>
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
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col col-lg-2">
                        <a class="btn btn-danger btn-block" href="<?php echo FRONT_ROOT; ?>/MovieTheater/ListCinemas" role="button">Cancelar</a>
                    </div>
                    <input type="hidden" name="seats" id="seats" value =<?php echo  $seats; ?>>
                    <div class="col col-lg-4">
                        <button name="submit" type="submit" id="summit" class="btn btn-primary btn-success btn-block" disabled="disabled">Confirmar</button>
                    </div>
                </div>
            </div>
        </form>
        <br><br><br>
    </div>

    <script>
        $("input:radio").change(function() {
            $("#summit").prop("disabled", false);
        });
    </script>



    <?php require_once(VIEWS_PATH . "footer.php"); ?>