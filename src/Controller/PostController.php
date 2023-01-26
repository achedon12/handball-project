<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/post/{id}', name: 'app_post_show')]
    public function show(int $id): Response
    {
        return $this->render('post/show.html.twig', [
            'controller_name' => 'PostController',
            'id' => $id
        ]);
    }

    #[Route('/post/edit/{id}', name: 'app_post_edit')]
    public function edit(int $id): Response
    {
        return $this->render('post/edit.html.twig', [
            'controller_name' => 'PostController',
            'id' => $id
        ]);
    }

    #[Route('/post/delete/{id}', name: 'app_post_delete')]
    public function delete(int $id): Response
    {
        return $this->render('post/delete.html.twig', [
            'controller_name' => 'PostController',
            'id' => $id
        ]);
    }
}
