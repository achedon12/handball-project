<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Entity\Matches;
use App\Form\CreateMatchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match', name: 'app_match')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $matches = $doctrine->getRepository(Matches::class)->findAll();
        return $this->render('match/index.html.twig', [
            'controller_name' => 'MatchController',
            'matches' => $matches,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/match/show/{id}', name: 'app_match_show')]
    public function show(int $id,ManagerRegistry $doctrine): Response
    {
        $match = $doctrine->getRepository(Equipes::class)->find($id);
        if($match) {
            return $this->render('match/show.html.twig', [
                'match' => $match,
                "user" => $this->getUser(),
            ]);
        }
        return $this->redirectToRoute('app_match');
    }

    #[Route('/match/create', name: 'app_match_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $match = new Matches();
        $form = $this->createForm(CreateMatchType::class, $match);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $match = $form->getData();
            $doctrine->getManager()->persist($match);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_match_show', [
                'id' => $match->getId(),
                "user" => $this->getUser(),
                ]);
        }
        return $this->render('match/create.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
            ]);
    }
}
