<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Form\CreateEquipeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

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
            return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
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
    public function edit(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
        }
        $equipeManager = $doctrine->getRepository(Equipes::class);
        $equipe = $equipeManager->find($id);

        $form = $this->createFormBuilder()
            ->add('libelle', null, [
                "data" => $equipe->getLibelle(),
                "required" => false,
            ])
            ->add('entraineur', TextType::class, [
                "data" => $equipe->getEntraineur(),
                "required" => false,
            ])
            ->add('creneaux', TextType::class, [
                "data" => $equipe->getCreneaux(),
                "required" => false,
            ])
            ->add('url_photo', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Sélectionnez une image valide',
                    ])
                ],
            ])
            ->add('url_result_calendrier', TextType::class, [
                "data" => $equipe->getUrlResultCalendrier(),
                "required" => false,
            ])
            ->add('commentaire', TextareaType::class, [
                "data" => $equipe->getCommentaire(),
                "required" => false,
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipe->setLibelle($form->get('libelle')->getData());
            $equipe->setEntraineur($form->get('entraineur')->getData());
            $equipe->setCreneaux($form->get('creneaux')->getData());
            $equipe->setUrlPhoto($form->get('url_photo')->getData());
            $equipe->setUrlResultCalendrier($form->get('url_result_calendrier')->getData());
            $equipe->setCommentaire($form->get('commentaire')->getData());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('app_equipe', ["user" => $this->getUser()]);
        }
        return $this->render('equipe/edit.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
            "image" => $equipe->getUrlPhoto(),
        ]);
    }

    #[Route('/equipe/delete/{id}', name: 'app_equipe_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
        }
        $equipeManager = $doctrine->getRepository(Equipes::class);
        $equipe = $equipeManager->find($id);
        if (!$equipe) {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
        if (strlen($equipe->getUrlPhoto()) === 36) {
            unlink($this->getParameter('image_directory') . '/' . $equipe->getUrlPhoto());
        } else {
            unlink($this->getParameter('public_directory') . '/images/' . $equipe->getUrlPhoto());
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($equipe);
        $entityManager->flush();
        return $this->redirectToRoute('app_equipe', ["user" => $this->getUser()]);
    }
}
