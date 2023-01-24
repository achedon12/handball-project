<?php

namespace App\Controller;

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
    public function index(): Response
    {
        return $this->render('match/index.html.twig', [
            'controller_name' => 'MatchController',
        ]);
    }

    #[Route('/match/show/{id}', name: 'app_match_show')]
    public function show(int $id,ManagerRegistry $doctrine): Response
    {
        $match = $doctrine->getRepository(Matches::class)->find($id);
        if($match) {
            return $this->render('match/show.html.twig', [
                'match' => $match,
            ]);
        }
        return $this->redirectToRoute('app_match');
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
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $match = new Matches();
        $form = $this->createForm(CreateMatchType::class, $match);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $match = $form->getData();
            $doctrine->getManager()->persist($match);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_match_show', ['id' => $match->getId()]);
        }
        return $this->render('match/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
