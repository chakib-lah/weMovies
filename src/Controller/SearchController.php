<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TmdbService;

class SearchController extends AbstractController
{
    private $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    /**
     * @Route("/search", name="movie_search", methods={"GET"})
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('query');

        if (!$query) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Call your service to search for movies based on the query
        $movies = $this->tmdbService->searchMovies($query);

        // Return a JSON response with the movies
        return new JsonResponse($movies);
    }
}
