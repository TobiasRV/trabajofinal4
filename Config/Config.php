<?php namespace Config;

define("ROOT",dirname(__DIR__) . "/");
define("VIEWS_PATH", ROOT . "Views/");

define("FRONT_ROOT", "http://localhost/Proyectos/trabajofinal4/"); // ACA HAY QUE CAMBIAR LA RUTA RELATIVA AL DIRECTORIO ROOT.

//define("FRONT_ROOT", "http://localhost/Proyectos/trabajofinal4/"); // ACA HAY QUE CAMBIAR LA RUTA RELATIVA AL DIRECTORIO ROOT.
define("FRONT_CSS", FRONT_ROOT . 'Views/css/');


//DATABASE

/* BACK */

define('DB_HOST', 'localhost');
define('DB_NAME', 'MoviePass');
define('DB_USER', ROOT);
define('DB_PASS', null);