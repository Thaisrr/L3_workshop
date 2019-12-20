<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Logement;
use App\Entity\User;
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
    public function index(Environment $twig) {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        $repoLog = $this->getDoctrine()->getRepository(Logement::class);
        $logements = $repoLog->findAll();

        return $this->render('home/index.html.twig', [
            'users' => $users
        ]);
    }
}