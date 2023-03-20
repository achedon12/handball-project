<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/about')]
class AboutController extends AbstractController
{
    #[Route('/', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/historique', name: 'app_about_history')]
    public function history(): Response
    {
        return $this->render('about/history.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/equipe', name: 'app_about_equipe')]
    public function equipe(): Response
    {
        return $this->render('about/equipe.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/infos', name: 'app_about_infos')]
    public function infos(): Response
    {
        return $this->render('about/infos.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
