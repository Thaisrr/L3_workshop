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
    public function index(Environment $twig, Security $security, string $param = "") {

        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        $events = [];
        $plans = [];
        $posts = [];

        foreach($articles as $art)  {
            switch ($art->getSubject()->getName()) {
                case 'Evénements' :
                    array_push($events, $art);
                    break;
                case 'Bons Plans' :
                    array_push($plans, $art);
                    break;
                case 'Articles':
                    array_push($posts, $art);
            }
        }


        switch ($param) {
            case "event":
                $articles = $events;
                break;
            case "plan":
                $articles = $plans;
                break;
            case "article":
                  $articles = $posts;
                break;
            default:
                $articles = $repo->findAll();
        }  

        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        $repoLog = $this->getDoctrine()->getRepository(Logement::class);
        $logements = $repoLog->findAll();

        return $this->render('home/index.html.twig', [
            'users' => $users,
            'articles' => $articles,
        ]);
    }
}