<?php namespace Views;

use Controllers\UserController as UserController;
use Controllers\MovieController as MovieController;

$api = new MovieController();

$movies = $api->get3Upcoming();

$control = new UserController();

if($control->checkSession())
{
    include_once(VIEWS_PATH . "header.php");
    include_once(VIEWS_PATH . "navAdmin.php");
    include_once(VIEWS_PATH . "upcomingslider.php");
}
else
{
    include_once(VIEWS_PATH . "login.php");
}


?>