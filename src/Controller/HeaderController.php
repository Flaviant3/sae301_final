<?php

// src/Controller/HeaderController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeaderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $user = $request->getSession()->get('user', []);

        if (empty($user) || !array_key_exists('email', $user)) {
        }


        return $this->render('_header.html.twig', [
        ]);
    }
}

?>