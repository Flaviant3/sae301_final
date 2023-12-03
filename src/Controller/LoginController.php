<?php
// src/Controller/LoginController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\LoginFormType; // Remplacez par le nom réel de votre formulaire

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // Créez une instance de votre formulaire
        $form = $this->createForm(LoginFormType::class);

        // Exemple de récupération de paramètre de requête
        $parametre = $request->query->get('parametre');

        // Obtention des erreurs de connexion (le cas échéant)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Logique de traitement après la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $formData = $form->getData();

            // Ajoutez votre logique de traitement ici...

            // Définissez la variable userData pour le template
            $userData = [
                'nom' => 'Nom de l\'utilisateur', // Remplacez par les données réelles
                'prenom' => 'Prénom de l\'utilisateur', // Remplacez par les données réelles
                // Ajoutez d'autres données si nécessaire
            ];

            return $this->render('login/index.html.twig', [
                'userData' => $userData,
                'form' => $form->createView(), // Ajout de la variable $form ici
                'last_username' => $lastUsername,
                'error' => $error,
                'parametre' => $parametre, // Ajout du paramètre récupéré
            ]);
        }

        // ... (votre logique existante)

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'parametre' => $parametre, // Ajout du paramètre récupéré
            'userData' => null, // Assurez-vous de définir userData ici ou de le laisser vide selon votre besoin
        ]);
    }
}
