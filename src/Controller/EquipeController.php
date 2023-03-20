<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Form\CreateEquipeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function index(ManagerRegistry $doctrine): Response
    {

        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/equipe/create', name: 'app_equipe_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }
        $equipe = new Equipes();
        $form = $this->createForm(CreateEquipeType::class, $equipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipe = $form->getData();
            $image = $form->get('url_photo')->getData();
            $imageName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('image_directory'),
                $imageName
            );
            $equipe->setUrlPhoto($imageName);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('app_equipe', ["user" => $this->getUser()]);
        }
        return $this->render('equipe/create.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/equipe/edit/{id}', name: 'app_equipe_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $dotrine): Response
    {
        if (!$this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }
        $equipeManager = $dotrine->getRepository(Equipes::class);
        $equipe = $equipeManager->find($id);

        $form = $this->createFormBuilder()
            ->add('libelle', null, ["data" => $equipe->getLibelle()])
            ->add('entraineur', null, ["data" => $equipe->getEntraineur()])
            ->add('creneaux', null, ["data" => $equipe->getCreneaux()])
            ->add('url_photo', null, ["data" => $equipe->getUrlPhoto()])
            ->add('url_result_calendrier', null, ["data" => $equipe->getUrlResultCalendrier()])
            ->add('commentaire', null, ["data" => $equipe->getCommentaire()])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipe->setLibelle($form->get('libelle')->getData());
            $equipe->setEntraineur($form->get('entraineur')->getData());
            $equipe->setCreneaux($form->get('creneaux')->getData());
            $equipe->setUrlPhoto($form->get('url_photo')->getData());
            $equipe->setUrlResultCalendrier($form->get('url_result_calendrier')->getData());
            $equipe->setCommentaire($form->get('commentaire')->getData());
            $entityManager = $dotrine->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('app_equipe', ["user" => $this->getUser()]);
        }
        return $this->render('equipe/edit.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/equipe/delete/{id}', name: 'app_equipe_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }
        $equipeManager = $doctrine->getRepository(Equipes::class);
        $equipe = $equipeManager->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($equipe);
        $entityManager->flush();
        return $this->redirectToRoute('app_equipe', ["user" => $this->getUser()]);
    }
}
