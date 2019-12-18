<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController {

    public function index() {
        $content = "AirBnB Host - Social Network";
            return new Response($content);
    }
}