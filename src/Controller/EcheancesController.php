<?php
// src/Controller/EcheancesController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcheancesController extends AbstractController
{
    #[Route('/echeances', name: 'app_echeances')]
public function index(): Response
{
return $this->render('echeances/index.html.twig');
}
}
?>