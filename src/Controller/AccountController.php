<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $post = new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('url_photo')->getData();
            $imageName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('post_directory'),
                $imageName
            );
            $post->setUrlPhoto($imageName);
            $post->setAuthor($this->getUser());
            $post->setTitle($form->get('title')->getData());
            $post->setContent($form->get('content')->getData());
            $post->setDate(date("Y-m-d/H:i:s"));
            $doctrine->getManager()->persist($post);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/index.html.twig', [
            "user" => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}
