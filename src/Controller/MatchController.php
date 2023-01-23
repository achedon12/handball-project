<?php

namespace App\Controller;

use App\Entity\Matches;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match', name: 'app_match')]
    public function index(): Response
    {
        return $this->render('match/index.html.twig', [
            'controller_name' => 'MatchController',
        ]);
    }

    #[Route('/match/{id}', name: 'app_match_show')]
    public function show(int $id,ManagerRegistry $doctrine): Response
    {
        $match = $doctrine->getRepository(Matches::class)->find($id);
        if(!$match) {
            return $this->render('match/error.html.twig', [
                'id' => $id,
            ]);
        }
        return $this->render('match/show.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/match/edit/{id}', name: 'app_match_edit')]
    public function edit(int $id,ManagerRegistry $doctrine): Response
    {
        $match = $doctrine->getRepository(Matches::class)->find($id);
        if(!$match) {
            return $this->render('match/error.html.twig', [
                'id' => $id,
            ]);
        }
        return $this->render('match/edit.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/match/delete/{id}', name: 'app_match_delete')]
    public function delete(int $id,ManagerRegistry $doctrine): Response
    {
        $match = $doctrine->getRepository(Matches::class)->find($id);
        if(!$match) {
            return $this->render('match/error.html.twig', [
                'id' => $id,
            ]);
        }
        return $this->render('match/delete.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/match/create', name: 'app_match_create')]
    public function create(): Response
    {
        return $this->render('match/create.html.twig', [
        ]);
    }
}
