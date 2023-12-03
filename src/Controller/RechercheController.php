<?php
// src/Controller/RechercheController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
#[Route('/recherche', name: 'app_recherche')]
public function index(Request $request): Response
{
        // Récupérer les données de l'utilisateur depuis la session
        $user = $request->getSession()->get('user', []);

        // Vérifier si l'utilisateur est connecté en vérifiant s'il a des données dans la session
        if (empty($user) || !isset($user['email'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('login');
        }

        $term = $request->query->get('term');
        $date = $request->query->get('date');


        return $this->render('recherche/index.html.twig', [
            'term' => $term,
            'date' => $date,
        ]);   
}}
?>