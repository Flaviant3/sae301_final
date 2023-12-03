<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    public function rechercheAction(Request $request)
    {
        $term = $request->query->get('term');
        $date = $request->query->get('date');

        return $this->render('recherche/index.html.twig', [
            'term' => $term,
            'date' => $date,
        ]);
    }
}
