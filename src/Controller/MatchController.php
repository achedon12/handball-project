<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Entity\Matches;
use App\Form\CreateMatchType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match', name: 'app_match')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $matches = $doctrine->getRepository(Matches::class)->findAll();

        return $this->render('match/index.html.twig', [
            'controller_name' => 'MatchController',
            'matches' => $matches,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/match/show/{id}', name: 'app_match_show')]
    public function show(int $id, ManagerRegistry $doctrine): Response
    {
        $match = $doctrine->getRepository(Equipes::class)->find($id);
        if ($match) {
            return $this->render('match/show.html.twig', [
                'match' => $match,
                "user" => $this->getUser(),
            ]);
        }
        return $this->redirectToRoute('app_match');
    }

    #[Route('/match/create', name: 'app_match_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createFormBuilder()
            ->add('equipe_locale', EntityType::class, [
                'class' => Equipes::class,
                'choice_label' => 'libelle',
            ])
            ->add('domicile_exterieur', ChoiceType::class, [
                    'choices' => [
                        'Extérieur' => 0,
                        'Domicile' => 1
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('equipe_adverse')
            ->add('hote', TextType::class, [
                'label' => 'Hôte',
            ])
            ->add('date_heure', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('num_semaine', IntegerType::class,
                [
                    'attr' => [
                        'min' => 1,
                        'max' => 52,
                    ],
                    'label' => 'Numéro de la semaine',
                    'invalid_message' => 'Le numéro de la semaine doit être compris entre 1 et 52',

                ])
            ->add('num_journee', IntegerType::class,[
                'attr' => [
                    'min' => 1,
                    'max' => 52,
                ],
                'label' => 'Numéro de la journée',
                'invalid_message' => 'Le numéro de la journée doit être compris entre 1 et 52',
            ])
            ->add('gymnase', TextType::class,[
                'label' => 'Gymnase'
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $match = new Matches();
            $match->setHote($form->get('hote')->getData());
            $match->setEquipeLocale($form->get('equipe_locale')->getData()->getLibelle());
            $match->setEquipeAdverse($form->get('equipe_adverse')->getData());
            $match->setDomicileExterieur($form->get('domicile_exterieur')->getData());
            $match->setDateHeure(new DateTime($form->get('date_heure')->getData()->format('Y-m-d H:i:s')));
            $match->setNumSemaine($form->get('num_semaine')->getData());
            $match->setNumJournee($form->get('num_journee')->getData());
            $match->setGymnase($form->get('gymnase')->getData());
            $doctrine->getManager()->persist($match);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_match_show', [
                'id' => $match->getId(),
                "user" => $this->getUser(),
            ]);
        }
        /*$form = $this->createForm(CreateMatchType::class, $match);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            dd($form,$match);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $match->setHote($form->get('hote')->getData());
            $match->setEquipeLocale($form->get('equipe_locale')->getData()->getLibelle());
            $match->setEquipeAdverse($form->get('equipe_adverse')->getData());
            $match->setDomicileExterieur($form->get('domicile_exterieur')->getData());
            $match->setDateHeure(new DateTime($form->get('date_heure')->getData()));
            $match->setNumSemaine($form->get('num_semaine')->getData());
            $match->setNumJournee($form->get('num_journee')->getData());
            $match->setGymnase($form->get('gymnase')->getData());
            $doctrine->getManager()->persist($match);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_match_show', [
                'id' => $match->getId(),
                "user" => $this->getUser(),
            ]);
        }*/
        return $this->render('match/create.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/match/delete/{id}', name: 'app_match_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        $matchManager = $doctrine->getRepository(Matches::class);
        $match = $matchManager->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($match);
        $entityManager->flush();
        return $this->redirectToRoute('app_match', ["user" => $this->getUser()]);
    }

    #[Route('/match/edit/{id}', name: 'app_match_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $matchManager = $doctrine->getRepository(Matches::class);
        $match = $matchManager->find($id);
        $form = $this->createFormBuilder()
            ->add('equipe_locale', null, [
                'data' => $match->getEquipeLocale()
            ])
            ->add('domicile_exterieur', ChoiceType::class, [
                'choices' => [
                    'Extérieur' => 0,
                    'Domicile' => 1
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('equipe_adverse', null, [
                'data' => $match->getEquipeAdverse(),
            ])
            ->add('hote', null, [
                'data' => $match->getHote(),
            ])
            ->add('date_heure', null, [
                'data' => $match->getDateHeure()->format('Y-m-d H:i:s'),
            ])
            ->add('num_semaine', null, [
                'data' => $match->getNumSemaine(),
            ])
            ->add('num_journee', null, [
                'data' => $match->getNumJournee(),
            ])
            ->add('gymnase', null, [
                'data' => $match->getGymnase(),
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $match->setEquipeLocale($form->get('equipe_locale')->getData());
            $match->setDomicileExterieur($form->get('domicile_exterieur')->getData());
            $match->setEquipeAdverse($form->get('equipe_adverse')->getData());
            $match->setHote($form->get('hote')->getData());
            $match->setDateHeure(DateTime::createFromFormat("Y-m-d H:i:s", $form->get('date_heure')->getData()));
            $match->setNumSemaine($form->get('num_semaine')->getData());
            $match->setNumJournee($form->get('num_journee')->getData());
            $match->setGymnase($form->get('gymnase')->getData());
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_match', [
                'id' => $match->getId(),
                "user" => $this->getUser(),
            ]);
        }
        return $this->render('match/edit.html.twig', [
            'form' => $form->createView(),
            "user" => $this->getUser(),
        ]);
    }
}
