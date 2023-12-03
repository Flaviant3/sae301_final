<?php

// src/Controller/RegistrationController.php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Chemin vers le fichier JSON où vous souhaitez stocker les données
            $filePath = '/var/www/sae301/data/inscription.json';

            // Récupération des données existantes du fichier JSON
            $existingData = [];
            if (file_exists($filePath)) {
                $existingData = json_decode(file_get_contents($filePath), true);
            }

            // Ajout du nouvel utilisateur aux données existantes avec la photo par défaut
            $newUserData = [
                'email' => $formData['email'],
                'password' => $formData['password'],
                'nom' => $formData['nom'],
                'prenom' => $formData['prenom'],
                'image' => '/uploads/profile_pictures/photo1.png', // Chemin de la photo par défaut
            ];
            $existingData[] = $newUserData;

            // Écriture des données dans le fichier JSON
            file_put_contents($filePath, json_encode($existingData));

            // Redirection vers la page de connexion (route 'login')
            return $this->redirectToRoute('login');
        }

        return $this->render('inscription/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
