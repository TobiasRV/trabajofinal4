<body class="home">
    <div class="container fluid p-0">
        <div class="row mt-3">

            <form class="form-inline" action="<?php echo FRONT_ROOT ?>Movie/showMovies" method="post">
                <div class="form-group mr-3">
                    <label for="genre">Cine:</label>
                    <select class="form-control" name="selectMovieTheater">
                        <option value="">--Sin Filtro--</option>
                        <option value="allMovieTheaters">Todos los cines</option>
                        <?php foreach ($movieTheatherList as $movieTheather) { ?>
                            <option value=<?php echo $movieTheather->getId(); ?>><?php echo $movieTheather->getName(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-3">
                    <label for="selectDate">Fecha:</label>
                    <input type="date" name="selectDate" id="selectDate" value="">
                </div>

                <div class="form-group mr-3">
                    <label for="genre">Genero:</label>
                    <select class="form-control" name="selectGenre">
                        <option value="">Sin Genero</option>
                        <?php foreach ($genres as $genre) { ?>
                            <option value=<?php echo $genre->getId(); ?>><?php echo $genre->getName(); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button class="btn btn-seondary" type="submit">Buscar</button>
            </form>
        </div>
        <div class="row mt-3" id="show-billboard">
            <?php foreach ($movies as $value) { ?>

                <div class="col-md-3 col-12 mt-3">
                    <!-- MOVIES -->
                    <div class="card">
                        <img class="card-img" src=<?php echo $value->getPosterPath(); ?> alt="Card image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $value->getTitle(); ?></h5>
                            <p class="card-text"><?php
                                                        foreach ($value->getIdGenre() as $genero) {
                                                            foreach ($genres as $gen) {
                                                                if ($gen->getId() == $genero) {
                                                                    echo $gen->getName() . "<br> ";
                                                                }
                                                            }
                                                        }
                                                        ?></p>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#movieDetails<?php echo $value->getIdMovie(); ?>">Ver Ficha</button>
                        </div>
                    </div>

                    <!-- MODALS -->
                    <div class="modal fade" id="movieDetails<?php echo $value->getIdMovie(); ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h1 class="modal-title"><?php echo $value->getTitle(); ?></h1>
                                    <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="container fluid">
                                        <div class="row">
                                            <img class="card-img" src=<?php echo $value->getBackdropPath(); ?> alt="Card image">
                                        </div>
                                        <div class="row">
                                            <h4>Titulo Original: <?php echo $value->getOriginalTitle(); ?></h4>
                                            <p class="text-justify">Sinopsis: <?php echo $value->getOverview(); ?>
                                                <p class="font-weight-light">Fecha de Estreno: <?php echo $value->getReleaseDate(); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer-left">
                                    <h2>Funciones:</h2>
                                    <?php $ShowsOfMovie = array();
                                        $ShowsOfMovie = $showController->getShowsOfMovie($value->getIdMovie());
                                        if (!empty($ShowsOfMovie)) { ?>
                                        <table class="table table-condensed table-bordered table-light">
                                            <thead>

                                                <th>Cines</th>
                                                <th>Sala</th>
                                                <th>Fecha</th>
                                                <th>Horario</th>
                                            </thead>
                                            <?php foreach ($ShowsOfMovie as $show) {
                                                        $cinema = $cinemaController->getCinemaById($show->getIdCinema());
                                                        $movieTheather =  $movieTheaterController->getMovieTheaterById($cinema->getIdMovieTheater());
                                                        ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $movieTheather->getName(); ?></td>
                                                        <td><?php echo $cinema->getName(); ?></td>
                                                        <td><?php echo $show->getDate(); ?></td>
                                                        <td><?php echo $show->getTime(); ?></td>
                                                    </tr>
                                                </tbody>

                                        <?php }
                                            } ?>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

    <?php include_once(VIEWS_PATH . "footer.php"); ?>