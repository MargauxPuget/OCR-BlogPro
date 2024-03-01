<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;

class ErrorController
{
    protected $twig;

    public function error404()
    {
        var_dump('Errorcontroller :: error404');
        $this->twig = new Twig();

        $viewData = [
            'pageTitle' => 'OCR - Blog - 404 Error'
        ];

        echo $this->twig->getTwig()->render('404.twig', $viewData);
    }
}