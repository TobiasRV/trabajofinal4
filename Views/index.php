<body class="home">

<?php

use Controllers\UserController as UserController;
use DAO\MovieTheaterRepository as dao;

$userControl = new UserController();

if($userControl->checkSession()!=false)
{
  if($_SESSION["loggedUser"]->getPermissions()==1)
  {
    include_once(VIEWS_PATH . "header.php");
    include_once(VIEWS_PATH . "navAdmin.php");
    include_once(VIEWS_PATH . "upcomingslider.php");
  }
  else
  {
      if($_SESSION["loggedUser"]->getPermissions()==2)
      {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php");
        include_once(VIEWS_PATH . "upcomingslider.php");
      }
  }
}
else
{

    include_once(VIEWS_PATH . "header.php");
    include_once(VIEWS_PATH . "nav.php");
    include_once(VIEWS_PATH . "upcomingslider.php");


  // $dao = new dao();
  // $mtlist = $dao->getBillBoards(1);
  // var_dump($mtlist);

 }




 //getMts
//  object(Models\MovieTheater) (6) { 
//    ["id":"Models\MovieTheater":private]=> string(1) "1" 
//    ["status":"Models\MovieTheater":private]=> string(1) "1" 
//    ["name":"Models\MovieTheater":private]=> string(6) "JUAAAn" 
//    ["address":"Models\MovieTheater":private]=> string(11) "calle falsa" 
//    ["billBoard":"Models\MovieTheater":private]=> array(0) { } 
//    ["cinemas":"Models\MovieTheater":private]=> array(0) { } }

?>

