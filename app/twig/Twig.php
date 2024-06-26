<?php


namespace MPuget\blog\twig;

use MPuget\blog\Repository\UserRepository;

class Twig
{
    private $twig;
    private $loader;
    private $user;

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

        if (isset($_SESSION['userId'])) {

            $userRepo = new UserRepository();
            $this->user = $userRepo->find($_SESSION['userId']);

            $this->twig->addGlobal('userSession', $this->user);

        }

    }

    public function setUserSession($user)
    {
        $this->user = $user;

        return $this->user;
    }

    public function getTwig()
    {
        return $this->twig;
    }
}
