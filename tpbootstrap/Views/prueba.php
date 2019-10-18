<?php

use DAO\api as api;

$themoviedb = new api();

//$string = json_encode($themoviedb->getNowPlayingMovies());
echo $themoviedb->getNowPlayingMovies();
?>