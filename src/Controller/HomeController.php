<?php

namespace App\Controller;

use App\Entity\Matches;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $matcheManager = $doctrine->getRepository(Matches::class);

        var_dump($matcheManager->getAllOpponents());
        if($this->getUser()) {
            return $this->render('home/index.html.twig', [
                'user' => $this->getUser(),
                'nextMatch' => $matcheManager->getNextMatch(),
            ]);
        }
        return $this->render('home/index.html.twig', [
            'nextMatch' => $matcheManager->getNextMatch(),
        ]);
    }
}
