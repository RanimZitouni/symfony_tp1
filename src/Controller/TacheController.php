<?php

namespace App\Controller;

use App\Entity\Tache;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TacheController extends AbstractController
{
    #[Route('/taches', name: 'app_tache_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $taches = $entityManager->getRepository(Tache::class)->findBy([], ['dateCreation' => 'ASC']);
        return $this->render('tache/index.html.twig', [
            'taches' => $taches,
        ]);
    }

    #[Route('/taches/ajouter', name: 'app_tache_ajouter')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        $tache = new Tache();
        $tache->setTitre('Nouvelle tâche');
        $tache->setDescription('Description de la tâche');
        $tache->setTerminee(false);
        $tache->setDateCreation(new \DateTime());

        $entityManager->persist($tache);
        $entityManager->flush();

        return $this->redirectToRoute('app_tache_index');
    }

    #[Route('/taches/{id}', name: 'app_tache_show')]
    public function show(Tache $tache): Response
    {
        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
        ]);
    }
}
