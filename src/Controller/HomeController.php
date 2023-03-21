<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();

        $array = [];
        $page = 0;
        for($i = 0; $i < count($posts); $i++) {
            if($i % 4 == 0 && $i != 0) $page++;
            $array[$page][] = $posts[$i]->toArray();
        }
        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'posts' => $array,
            "page" => $page,
        ]);
    }
}
