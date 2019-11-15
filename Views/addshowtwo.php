<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");

?>

<body class="home">
    <div class="container">
        <form action="<?php echo FRONT_ROOT ?>Show/addShowThree" method="post">
            <h1>Crear Funcion</h1>
            <div class="form-group">
                <label for="movieTheaterName">Cine</label>
                <input class="form-control" type="text" id="movieTheaterName" name="movieTheaterName" value="<?php echo $movieTheaterName; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="cinemaName">Sala</label>
                <input class="form-control" type="text" id="cinemaName" name="cinemaName" value="<?php echo $cinemaName; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="date">Fecha</label><br>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="date" id="date" name="date" value="<?php echo $date; ?>" readonly>
                    </div>
                </div>
            </div>
            <label for="time">Horario</label><br>
            <div class="row">
                <div class="col-6">
                    <select class="form-control" name="time" onchange="activarBoton()" id="time">
                        <option>Seleccionar Horario</option>
                        <optgroup label="Horarios disponibles">
                            <?php foreach ($timeList as $time) { ?>
                                <option value="<?php echo $time ?>"><?php echo $time ?></option>
                            <?php } ?>
                    </select>
                    </optgroup>
                </div>
                <div class="col-3">
                    <button name="summit" type="summit" id="summit" class="btn btn-primary btn-primary btn-block" disabled><span class="fas fa-plus"></span> Seleccionar</button>
                </div>
            </div>
        </form><br><br>
        <div class="row justify-content-md-center">
            <div class="col col-lg-6">
                <a class="btn btn-danger btn-block" href="<?php echo FRONT_ROOT; ?>/MovieTheater/ListCinemas" role="button">Cancelar</a>
            </div>
        </div>
    </div>


    <script>
        function activarBoton() {

            var lista = document.getElementById("time");
            var boton = document.getElementById("summit");
            if (lista.selectedIndex != 0)
                boton.disabled = false;
            else {
                boton.disabled = true;
            }
        }
    </script>

    <?php require_once(VIEWS_PATH . "footer.php"); ?>