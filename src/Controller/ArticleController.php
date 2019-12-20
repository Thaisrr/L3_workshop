<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Entity\Subject;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Form\CommentaryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class ArticleController extends AbstractController
{

    /**
     * @Route("article/{param}", name="article")
     */
    public function index(string $param = "")
    {
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



        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("article/{id}", name="see-article")
     */
    public function seeArticle(int $id, Security $security, Request $request) {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        $usr = $security->getUser();
        $commentary = new Commentary();
        $commentary->setAuthor($usr)->setArticle($article);
        $isLiked = ($article->getUsersWhoLikeIt() == $usr) ? true : false;

        $form = $this->createForm(CommentaryFormType::class, $commentary);
        $form->add('ajouter', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => array( 'class' => 'btn btn-outline-info')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $article = $form.getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentary);
            $entityManager->flush();

            return $this->redirectToRoute('article');
        }

        return $this->render('article/see-article.html.twig', [
            'art' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("profile/friends-articles", name="friends-articles")
     */
    public function getFriendsArticles(Security $security) {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $usr = $security->getUser();
        $articles = [];

        foreach ($usr->getFriends() as $f) {
            foreach ($f->getArticles() as $a ) {
                array_push($articles, $a);
            }
        }

        foreach ($articles as $art) {
            $art->isLiked = false;
            foreach ($art->getUsersWhoLikeIt() as $u) {
                $art->isLiked = ($u === $usr)? true : false;
            }
        }

        return $this->render('article/friends-articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("profile/create-article", name="create-article")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createArticle(Request $request, Security $security) {
        $usr = $security->getUser();
        $article = new Article();
        $article->setAuthor($usr);
        $article->setLikes(0);
        $form = $this->createForm(ArticleFormType::class, $article);

        $form->add('ajouter', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => array( 'class' => 'btn btn-outline-info')
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
           // $article = $form.getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article');
        }


        return $this->render('article/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("profile/like/{id}", name="like")
     */
    public function likeArticle (int $id, Security $security)  {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = new Article();
        $article = $repo->find($id);
        $article->setLikes($article->getLikes() + 1);
        $usr = $security->getUser();
        $article->addUsersWhoLikeIt($usr);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('article');

    }

}
