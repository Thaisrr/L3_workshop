<?php

namespace App\Controller;

use App\Entity\User;
use PhpParser\Node\Stmt\Break_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/user/{id}", name="user-profile")
     */
    public function seeProfile(int $id, Security $security) {
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

        return $this->render('user/profile.html.twig', [
            'user' => $user, 'isMine' => $isMine, 'isFriend' => $isFriend
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
        $current->addFriend($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($current);
        $entityManager->flush();


        return $this->redirectToRoute('article');
    }
}
