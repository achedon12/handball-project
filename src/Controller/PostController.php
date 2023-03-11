<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class PostController extends AbstractController
{
    #[Route('/post/{id}', name: 'app_post_show')]
    public function show(int $id, ManagerRegistry $doctrine): Response
    {
        $post = $doctrine->getRepository(Post::class)->find($id);
        if (!$post) {
            return $this->render('post/error.html.twig');
        }
        return $this->render('post/show.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/post/edit/{id}', name: 'app_post_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $post = $managerRegistry->getRepository(Post::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('title', null, [
                "label" => "Titre du post",
                "required" => false,
                "data" => $post->getTitle()
            ])
            ->add('content', TextareaType::class, [
                "label" => "Contenu du post",
                "required" => false,
                "data" => $post->getContent()
            ])
            ->add('url_photo', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get("url_photo")->getData() !== null) {
                $lastImage = $post->getUrlPhoto();
                unlink($this->getParameter('post_directory') . "/" . $lastImage);

                $image = $form->get('url_photo')->getData();
                $imageName = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('post_directory'),
                    $imageName
                );
                $post->setUrlPhoto($imageName);
            }
            if ($form->get("title")->getData() !== null) {
                $post->setTitle(($form->get("title")->getData()));
            }
            if ($form->get("content")->getData() !== null) {
                $post->setContent($form->get("content")->getData());
            }
            $manager = $managerRegistry->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('app_post_pseudo', ['pseudo' => $this->getUser()->getPseudo()]);
        }
        return $this->render('post/edit.html.twig', [
            'controller_name' => 'PostController',
            'id' => $id,
            "user" => $this->getUser(),
            "post" => $post,
            "form" => $form->createView()
        ]);
    }

    #[Route('/post/delete/{id}', name: 'app_post_delete')]
    public function delete(int $id, ManagerRegistry $managerRegistry): Response
    {
        $post = $managerRegistry->getRepository(Post::class)->find($id);
        if (!$post) {
            return $this->render('post/error.html.twig');
        }
        unlink($this->getParameter('post_directory') . "/" . $post->getUrlPhoto());
        $manager = $managerRegistry->getManager();
        $manager->remove($post);
        $manager->flush();
        return $this->redirectToRoute('app_account');
    }

    #[Route('/post/pseudo/{pseudo}', name: 'app_post_pseudo')]
    public function post(string $pseudo, ManagerRegistry $managerRegistry): Response
    {
        $postManager = $managerRegistry->getRepository(Post::class);
        $posts = $postManager->findBy(["author" => $pseudo]);

        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts,
            "user" => $this->getUser(),
        ]);
    }
}
