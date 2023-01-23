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

    #[Route('/match/show', name: 'app_match_show')]
    public function show(): Response
    {
        return $this->render('match/show.html.twig', [
        ]);
    }

    #[Route('/match/edit', name: 'app_match_edit')]
    public function edit(): Response
    {
        return $this->render('match/edit.html.twig', [
        ]);
    }

    #[Route('/match/delete', name: 'app_match_delete')]
    public function delete(): Response
    {
        return $this->render('match/delete.html.twig', [
        ]);
    }

    #[Route('/match/create', name: 'app_match_create')]
    public function create(): Response
    {
        return $this->render('match/create.html.twig', [
        ]);
    }
}
