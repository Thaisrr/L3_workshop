<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController {

    /**
     * @Route("/home", name="home")
     */
    public function index() {
        $content = "AirBnB Host - Social Network";
            return new Response($content);
    }
}