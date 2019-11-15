<?php

require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");

?>
<form action="<?php echo FRONT_ROOT; ?>Show/addShow" method="post">
    <div class="container">
        <h1>Crear Función</h1>
        <div class="form-group">
            <label for="name">Cine</label>
            <input class="form-control" type="text" id="movieTheaterName" name="movieTheaterName" value="<?php if ($movieTheaterName != null) echo $movieTheaterName; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="address">Sala</label>
            <input class="form-control" type="text" id="cinemaName" name="cinemaName" value="<?php if ($cinemaName != null) echo $cinemaName; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="date">Fecha</label>
            <input class="form-control" type="date" id="date" name="date" value="" min="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="time">
                <option value="nowPlaying">En Cartelera</option>
            </select>
        </div>
        <div class="form-group">
            <label for="movieName">Pelicula</label>
            <input class="form-control" type="text" id="movieName" name="movieName" value="<?php if ($movieName != null) echo $movieName; ?>" disabled>
        </div>

        <button type="submit">Boton</button>


    </div>
</form>