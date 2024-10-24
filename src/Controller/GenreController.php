<?php

namespace App\Controller;

use App\Service\TmdbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GenreController extends AbstractController
{
    private $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    //#[Route('/genre', name: 'app_genre')]
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        // Fetch all genres
        $genres = $this->tmdbService->getGenres();

        // Fetch the best movie for the first genre or any other logic to determine the best movie
        $bestMovie = $this->tmdbService->getBestMovie();

        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
            'bestMovie' => $bestMovie,
        ]);
    }
    /*public function index(): Response
    {
        return $this->render('genre/index.html.twig', [
            'controller_name' => 'GenreController',
        ]);
    }*/

    #[Route('/genre/{id}', name:'movies_by_genre')]
    public function moviesByGenre(int $id): Response
    {
        // Fetch the genre by its ID (you might have to create a method in TMDBService to fetch a specific genre)
        $genres = $this->tmdbService->getGenres();
        $selectedGenre = null;

        // Find the selected genre
        foreach ($genres as $genre) {
            if ($genre['id'] === $id) {
                $selectedGenre = $genre;
                break;
            }
        }

        // If the genre isn't found, return a 404 response
        if (!$selectedGenre) {
            throw $this->createNotFoundException('The genre does not exist.');
        }

        // Fetch the movies for the selected genre
        $movies = $this->tmdbService->getMoviesByGenre($id);

        // Render the template and pass both the `genre` and `movies` variables
        return $this->render('genre/movies.html.twig', [
            'genre' => $selectedGenre,
            'movies' => $movies,
        ]);
    }
}
