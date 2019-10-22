<?php namespace Views;

use Controllers\movieController as movieController;

$api = new movieController();

$movies = $api->getNowPlaying();

?>
<div class="container fluid p-0">
    <div class="row mt-3">
        <?php foreach($movies as $value){?>
            <div class="col-12-md-3 mt-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img" src=<?php echo $value->getPosterPath();?> alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $value->getTitle();?></h5>
                        <p class="card-text"><?php echo $value->getOverview();?></p>
                        <a href="#" class="btn btn-primary">Ver Ficha</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


