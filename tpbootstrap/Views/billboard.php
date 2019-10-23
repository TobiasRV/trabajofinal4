<?php namespace Views;

include_once(VIEWS_PATH . "header.php");
include_once(VIEWS_PATH . "nav.php");
use Controllers\MovieController as MovieController;

$api = new MovieController();

$movies = $api->getNowPlaying();

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div class="container fluid p-0">
    <div class="row mt-3">
        <?php foreach($movies as $value){?>
            <div class="col-12-md-3 mt-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img" src=<?php echo $value->getPosterPath();?> alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $value->getTitle();?></h5>
                        <p class="card-text"><?php echo $value->getOverview(); ?></p>
                        <a href="#" class="btn btn-primary">Ver Ficha</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


