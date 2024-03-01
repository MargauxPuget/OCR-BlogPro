<?php

namespace MPuget\blog\controllers;

// classe mère de tous nos contrôleurs
class CoreController
{

    // la méthode show est commune entre tous nos contrôleurs !
    // méthode show : pour afficher nos templates
    // protected pour qu'elle soit accessible dans les classes enfants (MainController, ErrorController et CatalogController)
    protected function show($viewName, $viewData = [])
    {
        // on doit utiliser une variable globale pour $routeur, sinon on n'y a pas accès :'(
        // on en a besoin pour utiliser $router->generate() sur nos views
        // (en tout cas, pour l'instant, on ne sait pas faire mieux !) 
        global $router;

        // on récupère l'URL depuis la racine (/) de notre serveur web
        // pour charger nos assets (css, js) grâce à une URL absolue !
        $absoluteURL = dirname($_SERVER['SCRIPT_NAME']);

        // on va charger nos vues (header + viewName + footer)
        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/commons/header.twig';
        require_once __DIR__ . '/../views/' . $viewName . '.twig';
        require_once __DIR__ . '/../views/commons/footer.twig';
    }
}