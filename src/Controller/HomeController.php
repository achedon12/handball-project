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
        if($this->getUser()) {
            return $this->render('home/index.html.twig', [
                'user' => $this->getUser(),
                'posts' => $posts
            ]);
        }
        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            "user" => $this->getUser(),
        ]);
    }
}
