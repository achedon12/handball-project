<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Form\CreateEquipeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function index(ManagerRegistry $doctrine): Response
    {

        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/equipe/create', name: 'app_equipe_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $equipe = new Equipes();
        $form = $this->createForm(CreateEquipeType::class, $equipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $equipe = $form->getData();
            $image = $form->get('url_photo')->getData();
            $imageName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('image_directory'),
                $imageName
            );
            $equipe->setUrlPhoto($imageName);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('app_equipe_show', ['id' => $equipe->getId()]);
        }
        return $this->render('equipe/create.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
        ]);
    }
}
