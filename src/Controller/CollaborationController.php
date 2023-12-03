<?php

// src/Controller/CollaborationController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollaborationController extends AbstractController
{
    #[Route('/collaboration', name: 'collaboration')]
    public function index(): Response
    {
        // Récupère les données réelles depuis ta base de données ou tout autre endroit
        $submissionChannels = [
            ['name' => 'Canal Rendu 1', 'submissionTitle' => 'Rendu 1', 'description' => 'Discussion sur le rendu 1'],
            ['name' => 'Canal Rendu 2', 'submissionTitle' => 'Rendu 2', 'description' => 'Discussion sur le rendu 2'],
            // ... d'autres canaux de rendu
        ];

        $evaluationChannels = [
            ['name' => 'Canal Évaluation 1', 'evaluationTitle' => 'Évaluation 1', 'description' => 'Discussion sur l\'évaluation 1'],
            ['name' => 'Canal Évaluation 2', 'evaluationTitle' => 'Évaluation 2', 'description' => 'Discussion sur l\'évaluation 2'],
            // ... d'autres canaux d'évaluation
        ];

        return $this->render('collaboration/index.html.twig', [
            'submissionChannels' => $submissionChannels,
            'evaluationChannels' => $evaluationChannels,
        ]);
    }
}

?>