<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Entity\Matches;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Json;
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

    /**
     * @Route("/", name="api", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllAPI(ManagerRegistry $doctrine): JsonResponse{
        $array = [];
        $array['nextMatch'] = $this->getNextMatch($doctrine);
        $array['lastMatch'] = $this->getLastMatch($doctrine);
        $array['allTeam'] = $this->getAllTeam($doctrine);
        $array['api_allMatches'] = $this->getAllTeam($doctrine);
        return $this->json($array);
    }

    /**
     * @Route("/allTeam", name="api_allTeam", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */

    public function getAllTeam(ManagerRegistry $doctrine):JsonResponse{
        $array=$doctrine->getRepository(Equipes::class)->findAll();
        return $this->json($array);
    }

    /**
     * @Route("/allMatches", name="api_allMatches", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */


    public function getAllMatches(ManagerRegistry $doctrine):JsonResponse{
        $array=$doctrine->getRepository(Matches::class)->findAll();
        return $this->json($array);
    }

}
