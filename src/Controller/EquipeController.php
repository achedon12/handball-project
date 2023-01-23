<?php

namespace App\Controller;

use App\Entity\Equipes;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/equipe/show/{id}', name: 'app_equipe_show')]
    public function show(int $id, ManagerRegistry $doctrine): Response
    {
        $equipe = $doctrine->getRepository(Equipes::class)->find($id);
        if(!$equipe) {
            return $this->render('equipe/error.html.twig', [
                'id' => $id,
            ]);
        }
        return $this->render('equipe/show.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/equipe/edit/{id}', name: 'app_equipe_edit')]
    public function edit(int $id, ManagerRegistry $doctrine): Response
    {
        $equipe = $doctrine->getRepository(Equipes::class)->find($id);
        if(!$equipe) {
            return $this->render('equipe/error.html.twig', [
                'id' => $id,
            ]);
        }
        return $this->render('equipe/edit.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/equipe/delete/{id}', name: 'app_equipe_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        $equipe = $doctrine->getRepository(Equipes::class)->find($id);
        if(!$equipe) {
            return $this->render('equipe/error.html.twig', [
                'id' => $id,
            ]);
        }
        return $this->render('equipe/delete.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/equipe/create', name: 'app_equipe_add')]
    public function add(): Response
    {
        return $this->render('equipe/create.html.twig', [
        ]);
    }
}
