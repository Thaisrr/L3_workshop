<?php

namespace App\Controller;

use App\Entity\Article;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class HomeController extends AbstractController {

    /**
     * @Route("/home", name="home")
     * @param Environment $twig
     * @return
     */
    public function index(Environment $twig, Security $security) {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'users' => $users
        ]);
    }
}