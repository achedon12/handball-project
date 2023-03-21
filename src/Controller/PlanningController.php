<?php

namespace App\Controller;

use App\Entity\Matches;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        return $this->render('planning/index.html.twig', [
            "user" => $this->getUser(),
        ]);
    }
}
