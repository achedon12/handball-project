<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Entity\Matches;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function getAllAPI(ManagerRegistry $doctrine): JsonResponse
    {
        $array = [];
        $array['nextMatch'] = $this->getNextMatch($doctrine);
        $array['lastMatch'] = $this->getLastMatch($doctrine);
        $array['allTeam'] = $this->getAllTeam($doctrine);
        $array['allMatches'] = $this->getAllTeam($doctrine);
        $array['allCategories'] = $this->getAllCategories($doctrine);
        $array['allGymnases'] = $this->getAllGymnases($doctrine);
        $array['allUsers'] = $this->getAllUser($doctrine);
        return $this->json($array);
    }

    /**
     * @Route("/allTeam", name="api_allTeam", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllTeam(ManagerRegistry $doctrine): JsonResponse
    {
        $array = $doctrine->getRepository(Equipes::class)->findAll();
        return $this->json($array);
    }

    /**
     * @Route("/allMatches", name="api_allMatches", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllMatches(ManagerRegistry $doctrine): JsonResponse
    {

        $localTeam = $_GET['equipe_locale'] ?? 'all';
        $gymnase = $_GET['gymnase'] ?? 'all';
        $domicile_exterieur = $_GET['domicile_exterieur'] ?? 'all';

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

        $date = new DateTime('now');
        $array = array_filter($array, function ($a) use ($date) {
            return $a->getDateHeure() >= $date;
        });

        usort($array, function ($a, $b) {
            return $a->getDateHeure() <=> $b->getDateHeure();
        });


        return $this->json($array);
    }

    /**
     * @Route("/allCategories", name="api_allCategories", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllCategories(ManagerRegistry $doctrine): JsonResponse
    {
        $array = $doctrine->getRepository(Matches::class)->getAllCategories();
        return $this->json($array);
    }

    /**
     * @Route("/allGymnases", name="api_allGymnases", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllGymnases(ManagerRegistry $doctrine): JsonResponse
    {
        $array = $doctrine->getRepository(Matches::class)->getAllGymnases();
        return $this->json($array);
    }

    /**
     * @Route("/allUsers", name="api_allUsers", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getAllUser(ManagerRegistry $doctrine): JsonResponse
    {
        $array = $doctrine->getRepository(User::class)->findAll();
        return $this->json($array);
    }
}
