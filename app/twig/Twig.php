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
        $this->twig->addGlobal('ASSET_PATH', "./public/assets");

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        //$this->twig->addExtension(new \App\Libs\twigFiltersExtensions());

        session_start();
        var_dump($_SESSION);
        // TODO benoit : c'est quoi le mieux ?
        $this->twig->addGlobal('SESSION', $_SESSION);
        $this->twig->addGlobal('session', $_SESSION['user']);

    }
    public function getTwig()
    {
        return $this->twig;
    }
}
