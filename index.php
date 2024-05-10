<?php

require_once __DIR__ . '/vendor/autoload.php';

// require de nos Controllers
use MPuget\blog\Controllers\MainController;
use MPuget\blog\Controllers\PostController;
use MPuget\blog\Controllers\CommentController;
use MPuget\blog\Controllers\UserController;
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

$router->map(
'POST',
'', // l'URL de cette route
// target :
[
	'action' => 'home', // méthode à appeler
	'controller' => 'MPuget\blog\Controllers\MainController' // controller concerné
],
'homePost' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('homePost');

$router->map(
'POST',
'homeContact', // l'URL de cette route
// target :
[
	'action' => 'contactForm', // méthode à appeler
	'controller' => 'MPuget\blog\Controllers\MainController' // controller concerné
],
'contactForm' // le nom qu'on donne à notre route (pour $router->generate())
);



//*--------------------------
//*   User
//*--------------------------

$router->map(
'GET',
'user/[i:userId]', // l'URL de cette route
// target :
[
	'action' => 'userHome', // méthode à appeler
	'controller' => 'MPuget\blog\Controllers\UserController' // controller concerné
],
'userHome' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('userHome');

$router->map(
'POST',
'addUser', // l'URL de cette route
// target :
[
	'action' => 'addUser', // méthode à appeler
	'controller' => 'MPuget\blog\Controllers\UserController' // controller concerné
],
'addUser' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('addUser');


$router->map(
'POST',
'loginUser', // l'URL de cette route
// target :
[
	'action' => 'loginUser', // méthode à appeler
	'controller' => 'MPuget\blog\Controllers\UserController' // controller concerné
],
'loginUser' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('loginUser');


$router->map(
	'GET',
	'logoutUser', // l'URL de cette route
	// target :
	[
		'action' => 'logoutUser', // méthode à appeler
		'controller' => 'MPuget\blog\Controllers\UserController' // controller concerné
	],
	'logoutUser' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('logoutUser');

$router->map(
	'GET',
	'user/[i:userId]/form',
	[
		'action' 	=> 'formUser',
		'controller' => 'MPuget\blog\Controllers\UserController'
	],
	'formUser'
);
$router->generate('formUser');

$router->map(
	'POST',
	'user/[i:userId]/update',
	[
		'action' 	=> 'updateUser',
		'controller' => 'MPuget\blog\Controllers\UserController'
	],
	'updateUser'
);
$router->generate('updateUser');


//* --------------------------
//*   Post
//* --------------------------

$router->map(
	'GET',
	'posts/[i:page]',
	// target :
	[
		'action' => 'home',
		'controller' => 'MPuget\blog\Controllers\PostController'
	],
	'postHome'
	);
$router->generate('postHome');

$router->map(
	'GET',
	'posts',
	// target :
	[
		'action' => 'home',
		'controller' => 'MPuget\blog\Controllers\PostController'
	],
	'postHomeSimple'
	);
$router->generate('postHomeSimple');


$router->map(
	'GET',
	'post/[i:postId]',
	// target :
	[
		'action' => 'singlePost',
		'controller' => 'MPuget\blog\Controllers\PostController'
	],
	'singlePost'
	);
$router->generate('singlePost');




//*--------------------------
//*   Comment
//*--------------------------


$router->map(
	'POST',
	'comment/[i:commentId]/update',
	// target :
	[
		'action' => 'updateComment',
		'controller' => 'MPuget\blog\Controllers\CommentController'
	],
	'refusedComment'
);
$router->generate('refusedComment');

$router->map(
	'POST',
	'post/[i:postId]/addComment',
	// target :
	[
		'action' => 'addComment',
		'controller' => 'MPuget\blog\Controllers\PostController'
	],
	'addComment'
);
$router->generate('addComment');

$router->map(
	'GET',
	'post/[i:postId]/deleteComment/[i:commentId]',
	// target :
	[
		'action' => 'deleteComment',
		'controller' => 'MPuget\blog\Controllers\PostController'
	],
	'deleteComment'
);
$router->generate('deleteComment');




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