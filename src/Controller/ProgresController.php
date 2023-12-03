<?php
// ProgresController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgresController extends AbstractController
{
    #[Route('/progres', name: 'app_progres')]
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
        return $this->render('progres/index.html.twig', [
            'user' => $user,
            // Autres variables que tu veux passer à la vue Twig
        ]);
    }
    
    public function index(Request $request): Response
    {
        // Récupérer les rendus depuis le localStorage s'il y en a
        $rendus = json_decode($request->cookies->get('rendus'), true) ?? [];

        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $travail = $request->request->get('travail');
            $matiere = $request->request->get('matiereRendu');
            $date = $request->request->get('dateRendu');

            // Ajouter un nouveau rendu à la liste
            $rendu = [
                'travail' => $travail,
                'matiere' => $matiere,
                'date' => $date,
            ];

            $rendus[] = $rendu;

            // Stocker les rendus mis à jour dans le localStorage
            $cookie = Cookie::create('rendus', json_encode($rendus))
                ->withExpires(time() + 3600) // Exemple d'expiration dans 1 heure
                ->withPath('/'); // Spécifie le chemin du cookie

            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->sendHeaders(); // Envoie les en-têtes pour définir le cookie

            return $this->redirectToRoute('app_progres');
        }

        return $this->render('progres/index.html.twig', [
            'rendus' => $rendus,
        ]);
    }
}
