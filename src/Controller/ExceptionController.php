<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ExceptionController extends AbstractController
{

    #[Route('/{url}', name: 'catch_all', requirements: ['url' => '.+'])]
    public function catchAll(string $url): Response
    {
        return $this->render('exception/index.html.twig', [
            'url' => $url
        ]);
    }
}
