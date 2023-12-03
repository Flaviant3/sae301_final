<?php
// src/Controller/BaseController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected function getEvaluations(): array
    {
        // Créez des évaluations directement ici (exemple)
        $evaluation1 = (object)[
            'id' => 1,
            'title' => 'TEST Eval1',
            'subject' => 'Mathématiques',
            'date' => new \DateTime('2023-11-26'),
            'completed' => true,
        ];

        $evaluation2 = (object)[
            'id' => 2,
            'title' => 'TEST Eval2',
            'subject' => 'Histoire',
            'date' => new \DateTime('2023-11-27'),
            'completed' => true,
        ];

        $evaluation3 = (object)[
            'id' => 3,
            'title' => 'TEST Eval3',
            'subject' => 'Mathématiques',
            'date' => new \DateTime('2023-11-28'),
            'completed' => true,
        ];

        // Rassemblez les évaluations dans un tableau
        return [$evaluation1, $evaluation2, $evaluation3];
    }
    protected function getRendus(): array
    {


        $rendu1 = (object)[
            'id' => 1,
            'title' => 'TEST Rendu1',
            'subject' => 'Mathématiques',
            'date' => new \DateTime('2023-11-26'),
            'completed' => true,
        ];

        $rendu2 = (object)[
            'id' => 2,
            'title' => 'TEST Rendu2',
            'subject' => 'Histoire',
            'date' => new \DateTime('2023-11-27'),
            'completed' => true,
        ];

        $rendu3 = (object)[
            'id' => 3,
            'title' => 'TEST Rendu3',
            'subject' => 'Mathématiques',
            'date' => new \DateTime('2023-11-28'),
            'completed' => true,
        ];

            // Rassemblez les rendus dans un tableau
            return [$rendu1, $rendu2, $rendu3];
    }
}
?>