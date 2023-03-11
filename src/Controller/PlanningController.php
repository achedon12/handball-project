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
        $matches = $managerRegistry->getRepository(Matches::class)->findAll();
        $data = [];
        $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
        $times = ["8h00", "9h00", "10h00", "11h00", "12h00", "13h00", "14h00", "15h00", "16h00", "17h00", "18h00","19h00", "20h00"];
        foreach ($matches as $match) {
            $date = $match->getDateHeure();
            $jour = $this->convertToFrench($date->format("l"));

            $time = $date->format("G") . "h" . $date->format("i");
            $data[$jour][$time][] = $match;
        }
        return $this->render('planning/index.html.twig', [
            "user" => $this->getUser(),
            "matches" => $matches,
            "data" => $data,
            "jours" => $jours,
            "times" => $times
        ]);
    }

    private function convertToFrench(string $day): string
    {
        $days = [
            "Monday" => "Lundi",
            "Tuesday" => "Mardi",
            "Wednesday" => "Mercredi",
            "Thursday" => "Jeudi",
            "Friday" => "Vendredi",
            "Saturday" => "Samedi",
            "Sunday" => "Dimanche"
        ];
        return $days[$day];
    }

    private function convertToTime(int $time): string
    {
        $times = [
            "8h00" => "8h00",
            "9h00" => "9h00",
            "10h00" => "10h00",
            "11h00" => "11h00",
            "12h00" => "12h00",
            "13h00" => "13h00",
            "14h00" => "14h00",
            "15h00" => "15h00",
            "16h00" => "16h00",
            "17h00" => "17h00",
            "18h00" => "18h00",
            "19h00" => "19h00",
            "20h00" => "20h00"
        ];
        return $times[$time];
    }
}
