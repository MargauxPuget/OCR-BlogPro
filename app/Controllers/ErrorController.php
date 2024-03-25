<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;

class ErrorController
{
    protected $twig;

    public function error404()
    {
        $this->twig = new Twig();

        $viewData = [
        ];

        echo $this->twig->getTwig()->render('404.twig', $viewData);
    }
}
