<?php
// MesEvalController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;

class MesEvalController extends AbstractController
{
    #[Route('/meseval', name: 'app_meseval')]
    public function inde(Request $request): Response
    {
        // Récupérer les données de l'utilisateur depuis la session
        $user = $request->getSession()->get('user', []);

        // Vérifier si l'utilisateur est connecté en vérifiant s'il a des données dans la session
        if (empty($user) || !isset($user['email'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('login');
        }

        // Si l'utilisateur est connecté, il peut accéder à /meseval
        // Ajoute ici d'autres actions que tu veux effectuer pour cet utilisateur connecté
        // ...

        // Retourne une réponse appropriée lorsque l'utilisateur est connecté
        return $this->render('meseval/index.html.twig', [
            'user' => $user,
            // Autres variables que tu veux passer à la vue Twig
        ]);
    }

    public function index(Request $request): Response
    {
        // Récupérer les évaluations depuis le localStorage s'il y en a
        $evaluations = json_decode($request->cookies->get('evaluations'), true) ?? [];

        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $matiere = $request->request->get('matiere');
            $date = $request->request->get('date');

            // Ajouter une nouvelle évaluation à la liste
            $evaluation = [
                'matiere' => $matiere,
                'date' => $date,
            ];

            $evaluations[] = $evaluation;

            // Stocker les évaluations mises à jour dans le localStorage
            $cookie = Cookie::create('evaluations', json_encode($evaluations))
                ->withExpires(time() + 3600) // Exemple d'expiration dans 1 heure
                ->withPath('/'); // Spécifie le chemin du cookie

            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->sendHeaders(); // Envoie les en-têtes pour définir le cookie

            return $this->redirectToRoute('app_meseval');
        }

        return $this->render('meseval/index.html.twig', [
            'evaluations' => $evaluations,
        ]);
    }
}
