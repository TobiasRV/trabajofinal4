<?php

namespace Views;

use DAO\CinemaRepository as CinemaRepository;
use Controllers\MovieController as movieController;

include_once(VIEWS_PATH . "header.php");
include_once(VIEWS_PATH . "nav.php");

$repo = new CinemaRepository();

$movieController = new movieController();
$nowPlaying = $movieController->getNowPlaying();

$listado = $repo->getAll();
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Dirección</th>
            <th scope="col">Asientos</th>
            <th scope="col">Cartelera</th>
            <th scope="col">Precio</th>
            <th scope="col">Eliminar</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listado as $cine) { ?>
            <tr>
                <th scope="row"><?php echo $cine->getName(); ?></th>
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
                <td>
                <a href="<?php echo FRONT_ROOT ?>/Cinema/deleteCinema/<?php echo $cine->getName(); ?>" class="btn btn-danger" role="button">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>