<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginFormType;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Récupérer les données du fichier JSON
            $jsonData = file_get_contents('/var/www/sae301/data/inscription.json');
            $users = json_decode($jsonData, true);

            // Vérifier si la conversion JSON a réussi
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Erreur lors de la lecture du fichier JSON.');
            }

            // Vérifier si $users est bien un tableau avant de boucler
            if (!is_array($users)) {
                throw new \RuntimeException('Le fichier JSON ne contient pas un tableau.');
            }

            // Vérifier les données de l'utilisateur dans le tableau $users
            $authenticated = false;

            foreach ($users as $user) {
                if (is_array($user) && isset($user['email']) && isset($user['password'])) {
                    if ($user['email'] === $formData['email'] && $user['password'] === $formData['password']) {
                        // L'utilisateur est authentifié

                        // Stocker les informations de l'utilisateur dans la session Symfony
                        $request->getSession()->set('user', $user);

                        // Redirection vers la page après la connexion réussie
                        return $this->redirectToRoute('profil');
                    }
                } else {
                    // Gérer le cas où $user n'est pas un tableau avec les clés 'email' et 'password'
                }
            }

            // Si l'authentification échoue, afficher un message d'erreur spécifique
            if (!$authenticated) {
                $errorMessage = '';

                // Vérifier si l'email existe dans les utilisateurs
                $emailExists = false;
                foreach ($users as $user) {
                    if (is_array($user) && isset($user['email']) && $user['email'] === $formData['email']) {
                        $emailExists = true;
                        break;
                    }
                }

                if (!$emailExists) {
                    $errorMessage = 'Email non trouvé.';
                } else {
                    $errorMessage = 'Mot de passe incorrect.';
                }

                // Rendre à la vue le formulaire avec le message d'erreur
                return $this->render('login/index.html.twig', [
                    'form' => $form->createView(),
                    'error' => $errorMessage, // Transmettre l'erreur à la vue
                ]);
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
