<?php namespace Views;

use Controllers\movieController as movieController;

$api = new movieController();

$movies = $api->getNewest3();

?>

<div class="container-fluid p-0">
  <div class="row">
    <div class="col">
      <h1 style = "text-align:center" >Featured movies</h1>
    </div>
  </div>
  <div class="row">
    <div class="col">

      <div id="Newest3movies" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              <li data-target="#Newest3movies" data-slide-to="0" class="active"></li>
              <li data-target="#Newest3movies" data-slide-to="1"></li>
              <li data-target="#Newest3movies" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            
              <!-- <div class="carousel-item active">
                  <img class="d-block w-100" src=<?php// echo $movies[0]->getBackdropPath();?> alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5><?php// echo $movies[0]->getTitle();?></h5>
                      <p>The whole caption will only show up if the screen is at least medium size.</p>
                  </div>
              </div> -->
              <div class="carousel-item active">
                  <img class="d-block w-100" src="https://placeimg.com/1080/500/arch" alt="Second slide">
              </div>
              <div class="carousel-item">
                  <img class="d-block w-100" src="https://placeimg.com/1080/500/nature" alt="Third slide">
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


<!-- <div class="container-fluid p-0">
  <div class="row">
    <div class="col">
      <h1 style = "text-align:center" >Upcoming movies</h1>
    </div>
  </div>
  <div class="row">
    <div class="col">

      <div id="Newest3movies" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              <li data-target="#Newest3movies" data-slide-to="0" class="active"></li>
              <li data-target="#Newest3movies" data-slide-to="1"></li>
              <li data-target="#Newest3movies" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            
              <div class="carousel-item active">
                  <img class="d-block w-100" src="https://placeimg.com/1080/500/animals" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>My Caption Title (1st Image)</h5>
                      <p>The whole caption will only show up if the screen is at least medium size.</p>
                  </div>
              </div>
              <div class="carousel-item">
                  <img class="d-block w-100" src="https://placeimg.com/1080/500/arch" alt="Second slide">
              </div>
              <div class="carousel-item">
                  <img class="d-block w-100" src="https://placeimg.com/1080/500/nature" alt="Third slide">
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