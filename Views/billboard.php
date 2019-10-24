<?php namespace Views;

include_once(VIEWS_PATH . "header.php");
include_once(VIEWS_PATH . "nav.php");

use Controllers\MovieController as MovieController;

$api = new MovieController();

$movie = array();
$genres = $api->getGenres();
if(isset($_POST["movies"])){
    $movies = $_POST["movies"];
}
else{
    $movies = $api->getNowPlaying();
}

?>
<div class="container fluid p-0">
    <div class="row mt-3">
        
        <form class="form-inline" action="<?php echo FRONT_ROOT?>/Movie/searchMovie" method="post">
            <div class="form-group mr-3">
                <label for="selectTime">Fecha:</label>
                <select class="form-control" name="selectTime">
                    <option value="nowPlaying">En Cartelera</option>
                    <option value="upcoming">Proximamente</option>
                </select>
            </div>
            <div class="form-group mr-3">
                <label for="genre">Genero:</label>
                <select class="form-control" name="genre">
                    <option value="null">Sin Genero</option>
                    <?php foreach($genres as $genre){ ?>
                        <option value=<?php echo $genre->getId();?>><?php echo $genre->getName();?></option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn btn-seondary" type="submit">Buscar</button>
        </form>
    </div>
    <div class="row mt-3" id="show-billboard">
        <?php foreach($movies as $value){?>
            <div class="col-md-3 col-12 mt-3">

                <!-- MOVIES -->
                <div class="card">
                    <img class="card-img" src=<?php echo $value->getPosterPath();?> alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $value->getTitle();?></h5>
                        <p class="card-text"><?php echo $value->getOverview(); ?></p>
                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#movieDetails<?php echo $value->getTitle();?>">Ver Ficha</button>
                    </div>
                </div>

                <!-- MODALS -->
                <div class="modal fade" id="movieDetails<?php echo $value->getTitle();?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <h4 class="modal-title"><?php echo $value->getTitle();?></h4>
                                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="container fluid">
                                    <div class="row">
                                        <img class="card-img" src=<?php echo $value->getBackdropPath();?> alt="Card image">
                                    </div>
                                    <div class="row">
                                        <p>Titulo Original: <?php echo $value->getOriginalTitle();?></p>
                                        <p>Sinopsis: <?php echo $value->getOverview();?></p>
                                        <p>Fecha de Estreno: <?php echo $value->getReleaseDate(); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
</div>

<?php include_once(VIEWS_PATH . "footer.php");?>

