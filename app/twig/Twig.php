<?php


namespace MPuget\blog\twig;

class Twig
{
    private $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('templates');
        $this->twig = new \Twig\Environment($this->loader, [
            'debug' => true,
        ]);
        //$this->twig->addGlobal('session', unserialize($_SESSION['user']));
        $this->twig->addGlobal('ASSET_PATH', "./app/assets");

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        //$this->twig->addExtension(new \App\Libs\twigFiltersExtensions());

    }
    public function getTwig()
    {
        return $this->twig;
    }
}