<body class="home">

<?php

use Controllers\UserController as UserController;

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
}


?>

