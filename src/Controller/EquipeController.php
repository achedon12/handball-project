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
    public function index(): Response
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }

    #[Route('/equipe/show', name: 'app_equipe_show')]
    public function show(): Response
    {
        return $this->render('equipe/show.html.twig', [
        ]);
    }

    #[Route('/equipe/edit', name: 'app_equipe_edit')]
    public function edit(): Response
    {
        return $this->render('equipe/edit.html.twig', [
        ]);
    }

    #[Route('/equipe/delete', name: 'app_equipe_delete')]
    public function delete(): Response
    {
        return $this->render('equipe/delete.html.twig', [
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
            $entityManager = $doctrine->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('app_equipe_show');
        }
        return $this->render('equipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
