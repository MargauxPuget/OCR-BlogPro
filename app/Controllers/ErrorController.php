<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Controllers\CoreController;

class ErrorController extends CoreController
{
    // une page = une méthode
    public function error404()
    {
        var_dump('Errorcontroller :: error404');
        $viewData = [
            'pageTitle' => 'Oshop - 404 Error'
        ];

        // on délègue l'affichage de nos vues à la méthode show()
        $this->show('404', $viewData);
    }
}
