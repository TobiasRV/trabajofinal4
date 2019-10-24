<?php

namespace Views;

use DAO\CinemaRepository as CinemaRepository;
use Controllers\MovieController as MovieController;

include_once(VIEWS_PATH . "header.php");
include_once(VIEWS_PATH . "nav.php");

$repo = new CinemaRepository();

$movieController = new MovieController();
$nowPlaying = $movieController->getNowPlaying();

$listado = $repo->getAll();
?>

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

<?php include_once(VIEWS_PATH . "footer.php");?>