<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; // Ajoutez cette ligne
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EtablissementRepository;
// Assurez-vous d'importer également Etablissement et EtablissementType si vous les utilisez
use App\Entity\Etablissement;
use App\Form\EtablissementType;
use Doctrine\ORM\EntityManagerInterface; // Ajoutez cette ligne



class EtablissementController extends AbstractController
{

    #[Route('/etablissement/new', name: 'etablissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etablissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_etablissement_index');
        }

        return $this->render('etablissement/new.html.twig', [
            'etablissementForm' => $form->createView(),
        ]);
    }

    #[Route('/etablissement/cartographieCommune/{idCommune}', name: 'etablissement_cartographie_commune')]
    public function cartographieCommune(EtablissementRepository $etablissementRepository, $idCommune): Response
    {
        $etablissements = $etablissementRepository->findBy(['commune' => $idCommune]);

        return $this->render('etablissement/cartographie_commune.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }


    #[Route('/', name: 'app_etablissement_index', methods: ['GET'])]
    public function index(EtablissementRepository $etablissementRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1)); // S'assurer que $page est au moins 1
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $etablissements = $etablissementRepository->findBy([], null, $limit, $offset);
        $hasMore = count($etablissementRepository->findBy([], null, $limit, $offset + $limit)) > 0;

        return $this->render('etablissement/new.html.twig', [
            'etablissements' => $etablissements,
            'currentPage' => $page,
            'hasMore' => $hasMore,
        ]);
    }


    #[Route('/map', name: 'app_etablissement_map', methods: ['GET'])]
    public function gitmap(EtablissementRepository $etablissementRepository): Response
    {
        return $this->render('etablissement/map.html.twig', [
            'etablissements' => $etablissementRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_etablissement_show', methods: ['GET'])]
    public function show(Etablissement $etablissement): Response
    {
        return $this->render('etablissement/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etablissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Utilisez directement l'EntityManager pour sauvegarder les modifications
            $entityManager->flush(); // Pas besoin de persister ici car l'entité est déjà gérée

            return $this->redirectToRoute('app_etablissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etablissement/edit.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etablissement_delete', methods: ['POST'])]
    public function delete(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etablissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etablissement_index');
    }

    #[Route('/etablissements/departement/{code_departement}', name: 'app_etablissements_departement')]
    public function showByDepartement(string $code_departement, EtablissementRepository $etablissementRepository): Response
    {
        $etablissements = $etablissementRepository->findByDepartement($code_departement);

        return $this->render('etablissement/list.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/etablissements/academie/{code_academie}', name: 'app_etablissements_academie')]
    public function showByAcademie(string $code_academie, EtablissementRepository $etablissementRepository): Response
    {
        $etablissements = $etablissementRepository->findByAcademie($code_academie);

        return $this->render('etablissement/list.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/etablissements/region/{code_region}', name: 'app_etablissements_region')]
    public function showByRegion(string $code_region, EtablissementRepository $etablissementRepository): Response
    {
        $etablissements = $etablissementRepository->findByRegion($code_region);

        return $this->render('etablissement/list.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/etablissements/commune/{code_commune}', name: 'app_etablissements_commune')]
    public function showByCommune(string $code_commune, EtablissementRepository $etablissementRepository): Response
    {
        $etablissements = $etablissementRepository->findByCommune($code_commune);

        return $this->render('etablissement/list.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }


    #[Route('/etablissements/ministere/{code_ministere}', name: 'app_etablissements_ministere')]
    public function showByMinistere(string $code_ministere, EtablissementRepository $etablissementRepository): Response
    {
        $etablissements = $etablissementRepository->findByMinistere($code_ministere);

        return $this->render('etablissement/list.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
}