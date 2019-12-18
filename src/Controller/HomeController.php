<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController {

    /**
     * @Route("/home", name="home")
     * @param Environment $twig
     * @return
     */
    public function index(Environment $twig) {
        $content = $this->render('home/index.html.twig');
            return new Response($content);
    }
}