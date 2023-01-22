<?php

namespace App\Controller;

use App\Entity\Matches;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/api")
 */
class ApiController extends AbstractController
{

    /**
     * @Route("/nextmatch", name="api_nextmatch", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getNextMatch(ManagerRegistry $doctrine): JsonResponse
    {
        $nextMatch = $doctrine->getRepository(Matches::class)->getNextMatch();
        return $this->json($nextMatch);
    }

    /**
     * @Route("/lastmatch", name="api_lastmatch", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getLastMatch(ManagerRegistry $doctrine): JsonResponse
    {
        $lastMatch = $doctrine->getRepository(Matches::class)->getLastMatch();
        return $this->json($lastMatch);
    }
}
