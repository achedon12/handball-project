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
        $array['allMatches'] = $this->getAllTeam($doctrine);
        $array['allCategories'] = $this->getAllCategories($doctrine);
        $array['allGymnases'] = $this->getAllGymnases($doctrine);
        $array['OneTeam'] = $this->getTeamById($doctrine,10);
        return $this->json($array);
    }

    /**
     * @Route("/allTeam", name="api_allTeam", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllTeam(ManagerRegistry $doctrine): JsonResponse{
        $array=$doctrine->getRepository(Equipes::class)->findAll();
        return $this->json($array);
    }

    /**
     * @Route("/allMatches", name="api_allMatches", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllMatches(ManagerRegistry $doctrine): JsonResponse{

        $localTeam = $_GET['equipe_locale'];
        $gymnase = $_GET['gymnase'];
        $domicile_exterieur = $_GET['domicile_exterieur'];

        $criteria = [];
        if ($localTeam != 'all') {
            $criteria['equipe_locale'] = $localTeam;
        }
        if ($gymnase != 'all') {
            $criteria['gymnase'] = $gymnase;
        }
        if ($domicile_exterieur != 'all') {
            $criteria['domicile_exterieur'] = $domicile_exterieur;
        }

        $array = $doctrine->getRepository(Matches::class)->findBy($criteria);
        return $this->json($array);
    }

    /**
     * @Route("/allCategories", name="api_allCategories", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllCategories(ManagerRegistry $doctrine):JsonResponse{
        $array=$doctrine->getRepository(Matches::class)->getAllCategories();
        return $this->json($array);
    }

    /**
     * @Route("/allGymnases", name="api_allGymnases", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllGymnases(ManagerRegistry $doctrine):JsonResponse{
        $array=$doctrine->getRepository(Matches::class)->getAllGymnases();
        return $this->json($array);
    }


    /**
     * @Route("/OneTeam", name="api_OneTeam", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @param int $id
     * @return JsonResponse
     */

    public function getTeamById(ManagerRegistry $doctrine, int $id):JsonResponse{
        return $doctrine->getRepository(Equipes::class)->getTeamById($id);
    }

}
