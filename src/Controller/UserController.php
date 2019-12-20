<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Entity\User;
use PhpParser\Node\Stmt\Break_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/profile")
 */
class UserController extends AbstractController

{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/{id}/{edit}", name="user-profile")
     */
    public function seeProfile(int $id, Security $security, Request $request, bool $edit = false) {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = new User();
        $user = $repo->find($id);
        $isMine = (  $security->getUser() == $user)? true : false;
        $articles = $user->getArticles();
        $friends = $user->getFriends();
        $isFriend = false;

        foreach ($friends as $f) {
            if ($f == $security->getUser()) {
                $isFriend = true;
                break;
            }
        }

        foreach ($articles as $art) {
            $art->isLiked = false;
            foreach ($art->getUsersWhoLikeIt() as $u) {
                $art->isLiked = ($u === $security->getUser())? true : false;
            }
        }

        $form = $this->createFormBuilder($user)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider',  'attr' => array( 'class' => 'btn btn-outline-info')])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $article = $form.getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $edit = false;
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user, 'isMine' => $isMine, 'isFriend' => $isFriend, 'articles' => $articles, 'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/add-friend/{id}", name="add-friend")
     */
    public function addFriend(int $id, Security $security) {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = new User();
        $user = $repo->find($id);

        $current = $security->getUser();
        $user->addFriend($current);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($current);
        $entityManager->flush();


        return $this->redirect($this->generateUrl('profile', array('id' => $id)));
    }
}
