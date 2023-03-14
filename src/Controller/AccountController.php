<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content = $form->get('content')->getData();
            $image = $form->get('url_photo')->getData();
            $imageName = md5(uniqid()) . '.' . $image->guessExtension();
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
            'post' => $doctrine->getRepository(Post::class)->getLastPost($this->getUser())
        ]);
    }

    #[Route('/account/manage', name: 'app_account_manage')]
    public function manage(ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $users = $doctrine->getRepository(User::class)->findAll();

        return $this->render('account/manageAccount.html.twig', [
            "user" => $this->getUser(),
            'users' => $users
        ]);
    }

    #[Route('/account/manage/edit/{id}', name: 'app_account_manage_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $userManager = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);

        $form = $this->createFormBuilder()
            ->add('pseudo', null, [
                'data' => $user->getPseudo()
            ])
            ->add('email', null, [
                'data' => $user->getEmail()
            ])
            ->add("password", null, [
                "required" => false,
            ])
            ->add('roles', null, [
                'data' => $user->getRoles()[0]
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPseudo($form->get('pseudo')->getData());
            $user->setEmail($form->get('email')->getData());
            if($form->get('password')->getData() != null) {
                $hash = $passwordHasher->hashPassword($user, $form->get('password')->getData());
                $user->setPassword($hash);
            }
            $user->setRoles([$form->get('roles')->getData()]);
            $userManager->persist($user);
            $userManager->flush();

            return $this->redirectToRoute('app_account_manage');
        }


        return $this->render('account/manageAccountEdit.html.twig', [
            "user" => $this->getUser(),
            'userEdit' => $user,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/account/manage/delete/{id}', name: 'app_account_manage_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = $doctrine->getRepository(User::class)->find($id);
        $doctrine->getManager()->remove($user);
        $doctrine->getManager()->flush();

        return $this->render('account/manageAccount.html.twig', [
            "user" => $this->getUser(),
        ]);
    }
}
