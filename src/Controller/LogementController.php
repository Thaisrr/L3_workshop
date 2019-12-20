<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Logement;
use App\Form\AddressFormType;
use App\Form\LogementFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LogementController extends AbstractController
{
    /**
     * @Route("/logement/{id}", name="logement")
     */
    public function index(int $id)
    {
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $logement = $repo->find($id);
        return $this->render('logement/index.html.twig', [
            'logement' => $logement,
        ]);
    }

    /**
     * @Route("/add-logement", name="add-logement")
     */
    public function createLogement(Request $request) {
        $log = new Logement();
        $form = $this->createForm(LogementFormType::class, $log);

        $form->add('valider', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => array( 'class' => 'btn btn-outline-info')
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $article = $form.getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($log);
            $entityManager->flush();

            return $this->redirectToRoute('add-address');
        }
        return $this->render('logement/logement-form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("profile/add-address/{id}", name="add-address")
     */
    public function addAdress(int $id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $log = $repo->find($id);
        $add = new Address();
        $add->setLogement($log);
        $form = $this->createForm(AddressFormType::class, $add);

        $form->add('valider', SubmitType::class, [
            'label' => 'Valider',
            'attr' => array('class' => 'btn btn-outline-info')
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $article = $form.getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('home');

        }
        return $this->render('logement/logement-form.html.twig', [
            'form' => $form->createView()
        ]);

    }


}
