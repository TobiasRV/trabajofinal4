<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<body class="home">

    <div align="center">
        <br>
        <h1>Estadísticas</h1>
    </div>

    <table class="table table-hover table-condensed table-bordered table-dark">

        <thead>

            <th> </th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>Acción</th>
        </thead>

        <tbody>

            <tr>
                <form class="form-inline" action="<?php echo FRONT_ROOT ?>User/searchByDates" method="POST">
                    <th scope="row">Entre fechas</th>
                    <td>
                        <input type="date" class="form-control" id="dateInit" name="dateInit" placeholder="DD / MM / YYYY" required />
                    </td>
                    <td>
                        <input type="date" class="form-control" id="dateFin" name="dateFin" placeholder="DD / MM / YYYY" required />
                    </td>
                    <td>
                        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                    </td>
                </form>
            </tr>
            <tr>
                <form class="form-inline" action="<?php echo FRONT_ROOT ?>User/searchByMovieTheater" method="POST">
                    <th scope="row">Cine</th>
                    <td colspan="2">
                        <select style="width:800px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" required>
                            <option value="" disabled selected>Filtrar por cine</option>
                            <?php foreach ($listadoMT as $movieTheater) { ?>
                                <option value=<?php echo $movieTheater->getId(); ?> data-tokens="<?php echo $movieTheater->getName(); ?>"><?php echo $movieTheater->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                    </td>
                </form>
            </tr>
            <tr>
                <form class="form-inline" action="<?php echo FRONT_ROOT ?>User/searchByMovie" method="POST">
                    <th scope="row">Película</th>
                    <td colspan="2">
                        <select style="width:800px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" required>
                            <option value="" disabled selected>Filtrar por película</option>
                            <?php foreach ($listadoM as $movie) { ?>
                                <option value=<?php echo $movie->getIdMovie(); ?> data-tokens="<?php echo $movie->getTitle(); ?>"><?php echo $movie->getTitle(); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                    </td>
                </form>
            </tr>

        </tbody>

    </table>

    <form action="<?php echo FRONT_ROOT ?>User/consultData" method="POST">
        <button type="submit" class="btn btn-info btn-block">Restaurar valores iniciales</button>
    </form>

    <br><br>
    <div class="row w-100">
        <div class="col-md-3">
            <div class="card border-info mx-sm-1 p-3">
                <div class="card border-info shadow text-info p-3 my-card"><span class="fas fa-ticket-alt" aria-hidden="true"></span></div>
                <div class="text-info text-center mt-3">
                    <h4>Entradas Vendidas</h4>
                </div>
                <div class="text-info text-center mt-2">
                    <h1><?php echo $soldTickets ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mx-sm-1 p-3">
                <div class="card border-warning shadow text-warning p-3 my-card"><span class="fas fa-store" aria-hidden="true"></span></div>
                <div class="text-warning text-center mt-3">
                    <h4>Entradas Remanentes</h4>
                </div>
                <div class="text-warning text-center mt-2">
                    <h1><?php echo $toSoldTickets ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mx-sm-1 p-3">
                <div class="card border-success shadow text-success p-3 my-card"><span class="fas fa-hand-holding-usd" aria-hidden="true"></span></div>
                <div class="text-success text-center mt-3">
                    <h4>Ganancias</h4>
                </div>
                <div class="text-success text-center mt-2">
                    <h1><?php echo "$ " . $earnings ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger mx-sm-1 p-3">
                <div class="card border-danger shadow text-danger p-3 my-card"><span class="fas fa-users" aria-hidden="true"></span></div>
                <div class="text-danger text-center mt-3">
                    <h4>Usuarios Registrados</h4>
                </div>
                <div class="text-danger text-center mt-2">
                    <h1><?php echo $registeredUsers ?></h1>
                </div>
            </div>
        </div>
    </div>


    <style type="text/css">
        .my-card {
            position: absolute;
            left: 40%;
            top: -20px;
            border-radius: 50%;
        }
    </style>

    <?php
    include_once(VIEWS_PATH . "footer.php");
    ?>