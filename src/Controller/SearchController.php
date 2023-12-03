<?php

// src/Controller/SearchController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request): Response
    {
        
        // Récupère le terme de recherche depuis la requête
        $searchTerm = $request->query->get('term', '');

        // Si aucun terme de recherche n'est fourni, retourne tous les résultats par défaut
        if (empty($searchTerm)) {
            return $this->json($this->getAllResults());
        }

        // Sinon, effectue la recherche dans ta base de données ou autre source
        // et retourne les résultats au format JSON
        $results = $this->getSearchResults($searchTerm);

        return $this->json($results);
    }

    private function getSearchResults($searchTerm)
    {
        // TODO: Implémente la logique de recherche réelle
        // Ici, c'est un exemple statique
        $searchResults = $this->getAllResults();

        // Filtrer les résultats qui contiennent le terme de recherche
        $filteredResults = array_filter($searchResults, function ($result) use ($searchTerm) {
            return stripos($result, $searchTerm) !== false;
        });

        // Retourne les résultats filtrés
        return array_values($filteredResults);
    }

    private function getAllResults()
    {
        // Liste complète de résultats
        return [
            'WR301',
            'WR302',
            'WR303',
            'WR304',
            'WR305D',
            'WR306',
            'WR307',
            'WR308',
            'WR309D',
            'WR310',
            'WR311',
            'WR312',
            'WR313D',
            'WR314',
            'WR315',
            'WR316',
            'WR317',
            'WR318',
            'WR319D',
            'WS301D',
            'WS302D',
            'WS303D',
            'WS310',
            'WS3Bonif',
            'WS3Cordées',
        ];
    }
}