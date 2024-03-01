<?php

require_once __DIR__ . '/vendor/autoload.php';

// require de nos Controllers
use MPuget\blog\Controllers\CoreController;
use MPuget\blog\Controllers\MainController;
use MPuget\blog\Controllers\ErrorController;

//* -----------------------------------------------------
//*                Routeur : AltoRouter
//* -----------------------------------------------------

// On commence par instancier un objet AltoRouter
$router = new AltoRouter();
// echo get_class($router);
// on donne à AltoRouter la partie de l'URL à ne pas prendre en compte pour faire la 
// comparaison entre l'URL demandée par le visiteur (exemple /categoy/1) et l'URL de notre route
$publicFolder = dirname($_SERVER['SCRIPT_NAME']);
$router->setBasePath($publicFolder);

// On va ensuite pouvoir mapper nos routes
$router->map(
    'GET',
    '', // l'URL de cette route
    // target :
    [
        'action' => 'home', // méthode à appeler
        'controller' => 'MPuget\blog\Controllers\MainController' // controller concerné
    ],
    'home' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('home');


$match = $router->match();

//* -----------------------------------------------------
//*                     Dispatcher
//* -----------------------------------------------------

// est-ce que notre route existe ? 
if($match) {
  // notre route existe, on va récupérer les données de la route 
  // que l'on a définit précédemment avec $router->map()

  // on récupère le controller
  $controllerName= $match['target']['controller'];

  //$match['target'] = 3ème paramètre défini dans les méthodes $router->map() ci-dessus

  // on récupère la méthode
  $method = $match['target']['action'];

  // on peut instancier notre controller
  $controller = new $controllerName();

  // on peut appeler la méthode de notre controller
  // on va envoyer les paramètres éventuels à notre méthode
  // ces paramètres étant ceux définis avec $router->map() ci dessus ! [i:id]
  $controller->$method($match['params']);
} else {
  // notre route n'existe pas, donc on renvoit sur une 404 !
  $controller = new ErrorController();
  $controller->error404();
}