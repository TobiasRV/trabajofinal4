<?php namespace Views;

use Controllers\MovieController as MovieController;

$api = new MovieController();

$movies = $api->get3Upcoming();

?>
<!-- 
<div class="container p-0"> 
   <div class="row">
    <div class="col">
    <h1>Proximamente</h1>
      <div id="Newest3movies" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              <li data-target="#Newest3movies" data-slide-to="0" class="active"></li>
              <li data-target="#Newest3movies" data-slide-to="1"></li>
              <li data-target="#Newest3movies" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            
              <div class="carousel-item active">
                  <img class="d-block w-100" src=<?php// echo $movies[0]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php //echo $movies[0]->getTitle();?></h5>
                      <p><?php //echo $movies[0]->getOverview();?></p>
                  </div>
              </div>
              <div class="carousel-item">
              <img class="d-block w-100" src=<?php //echo $movies[1]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php //echo $movies[1]->getTitle();?></h5>
                      <p><?php //echo $movies[1]->getOverview();?></p>
                  </div>
              </div>
              <div class="carousel-item">
              <img class="d-block w-100" src=<?php //echo $movies[2]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php //echo $movies[2]->getTitle();?></h5>
                      <p><?php //echo $movies[2]->getOverview();?></p>
                  </div>
              </div>
          </div>
          <a class="carousel-control-prev" href="#Newest3movies" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#Newest3movies" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
          </a>
      </div>


    </div>
  </div>
</div> -->

<div class="container p-0"> 
   <div class="row">
    <div class="col">
    <h1>Proximamente</h1>
      <div id="Newest3movies" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              <li data-target="#Newest3movies" data-slide-to="0" class="active"></li>
              <li data-target="#Newest3movies" data-slide-to="1"></li>
              <li data-target="#Newest3movies" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            
              <div class="carousel-item active">
                  <img class="d-block w-100" src=<?php echo $movies[0]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php echo $movies[0]->getTitle();?></h5>
                      <p><?php echo $movies[0]->getOverview();?></p>
                  </div>
              </div>
              <div class="carousel-item">
              <img class="d-block w-100" src=<?php echo $movies[1]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php echo $movies[1]->getTitle();?></h5>
                      <p><?php echo $movies[1]->getOverview();?></p>
                  </div>
              </div>
              <div class="carousel-item">
              <img class="d-block w-100" src=<?php echo $movies[2]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php echo $movies[2]->getTitle();?></h5>
                      <p><?php echo $movies[2]->getOverview();?></p>
                  </div>
              </div>
          </div>
          <a class="carousel-control-prev" href="#Newest3movies" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#Newest3movies" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
          </a>
      </div>
    </div>
  </div>
</div>

<?php include_once(VIEWS_PATH . "footer.php");