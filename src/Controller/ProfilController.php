<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Security\Core\Security;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(Request $request): Response
    {
        // Récupérer les données de l'utilisateur depuis la session
        $user = $request->getSession()->get('user', []);

        // Vérifier si l'utilisateur est connecté en vérifiant s'il a des données dans la session
        if (empty($user) || !isset($user['email'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('login');
        }

        // Récupérer les informations de l'utilisateur depuis la session
        $email = $user['email'];
        $prenom = $user['prenom'] ?? null;
        $nom = $user['nom'] ?? null;
        $image = $user['image'] ?? null; // Lien de l'image par défaut

        return $this->render('profil/index.html.twig', [
            'email' => $email,
            'prenom' => $prenom,
            'nom' => $nom,
            'user' => [
                'image' => $image,
            ],
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request): Response
    {
        // Supprimer les données de session de l'utilisateur
        $request->getSession()->clear();

        // Rediriger vers la page de connexion après déconnexion
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/update-profile", name="update_profile")
     */
    public function updateEmail(Request $request): Response
    {
        // Récupérer l'utilisateur connecté depuis la session
        $user = $request->getSession()->get('user', []);

        // Récupérer le nouvel e-mail depuis le formulaire
        $newEmail = $request->request->get('new_email');

        // Chemin vers le fichier JSON où vous stockez les données des utilisateurs
        $filePath = '/var/www/sae301/data/inscription.json'; // Mettez à jour le chemin selon votre configuration

        // Récupération des données existantes du fichier JSON
        $existingData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $existingData = json_decode($jsonContent, true);
        }

        // Recherche et mise à jour de l'e-mail dans les données existantes
        foreach ($existingData as &$userData) {
            if ($userData['email'] === $user['email']) {
                $userData['email'] = $newEmail; // Mettez à jour l'e-mail avec le nouveau
                break;
            }
        }

        // Écriture des données mises à jour dans le fichier JSON
        file_put_contents($filePath, json_encode($existingData));

        // Mettre à jour les données de session après modification du fichier JSON
        $user['email'] = $newEmail; // Mettez à jour d'autres données si nécessaire
        $request->getSession()->set('user', $user);

        // Ajout d'un flash message pour le mot de passe mis à jour
        $this->addFlash('success', 'L\'email a été modifié avec succès !');


        // Redirection vers la page de profil après la mise à jour
        return $this->redirectToRoute('profil');
}
    /**
     * @Route("/update-photo", name="update_photo")
     */
    public function updatePhoto(Request $request): Response
    {
        $user = $request->getSession()->get('user', []);

        $uploadedFile = $request->files->get('profile_picture');
        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/profile_pictures';
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

            try {
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );

                // Mettez à jour le chemin de l'image dans les données de l'utilisateur avec un chemin relatif accessible depuis le navigateur
                $user['image'] = '/uploads/profile_pictures/' . $newFilename; // Chemin relatif pour l'affichage dans le navigateur

                // Mettre à jour les données dans le fichier JSON
                $filePath = '/var/www/sae301/data/inscription.json'; // Chemin vers le fichier JSON
                $existingData = json_decode(file_get_contents($filePath), true);

                foreach ($existingData as &$userData) {
                    if ($userData['email'] === $user['email']) {
                        $userData['image'] = $user['image'];
                        break;
                    }
                }

                file_put_contents($filePath, json_encode($existingData));

                // Mise à jour des données de session de l'utilisateur
                $request->getSession()->set('user', $user);
            } catch (FileException $e) {
                // Gestion des erreurs liées au déplacement du fichier
            }
        }

        return $this->redirectToRoute('profil');
    }

    /**
     * @Route("/update-MDP", name="update_MDP")
     */
    public function updateMDP(Request $request): Response
    {
        // Récupérer l'utilisateur connecté depuis la session
        $user = $request->getSession()->get('user', []);

        // Récupérer le nouvel e-mail depuis le formulaire
        $newMDP = $request->request->get('new_mdp');

        // Chemin vers le fichier JSON où vous stockez les données des utilisateurs
        $filePath = '/var/www/sae301/data/inscription.json'; // Mettez à jour le chemin selon votre configuration

        // Récupération des données existantes du fichier JSON
        $existingData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $existingData = json_decode($jsonContent, true);
        }

        // Recherche et mise à jour de l'e-mail dans les données existantes
        foreach ($existingData as &$userData) {
            if ($userData['password'] === $user['password']) {
                $userData['password'] = $newMDP; // Mettez à jour l'e-mail avec le nouveau
                break;
            }
        }

        // Écriture des données mises à jour dans le fichier JSON
        file_put_contents($filePath, json_encode($existingData));

        // Mettre à jour les données de session après modification du fichier JSON
        $user['password'] = $newMDP; // Mettez à jour d'autres données si nécessaire
        $request->getSession()->set('user', $user);

        // Ajout d'un flash message pour le mot de passe mis à jour
        $this->addFlash('success', 'Le mot de passe a été modifié avec succès !');

        // Redirection vers la page de profil après la mise à jour
        return $this->redirectToRoute('profil');

}
}