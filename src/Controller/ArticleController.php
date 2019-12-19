<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleFormType;
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
     * @Route("/article", name="article")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();


        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/create-article", name="create-article")
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

}
