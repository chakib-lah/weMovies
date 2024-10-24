<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TmdbService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getGenres(): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list', [
            'query' => ['api_key' => $this->apiKey]
        ]);

        return $response->toArray()['genres'];
    }

    public function getMoviesByGenre(int $genreId): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/discover/movie', [
            'query' => [
                'api_key' => $this->apiKey,
                'with_genres' => $genreId,
            ],
        ]);

        $movies = $response->toArray()['results'];

        // Fetch the trailer for each movie
        foreach ($movies as &$movie) {
            $movie['trailerUrl'] = $this->getMovieTrailer($movie['id']);
        }

        return $movies;
    }

    public function getBestMovie(): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/top_rated', [
            'query' => ['api_key' => $this->apiKey],
        ]);

        $movies = $response->toArray()['results'];
        $bestMovie = $movies[0]; // For example, use the first top-rated movie

        // Fetch the trailer URL for the best movie
        $bestMovie['trailerUrl'] = $this->getMovieTrailer($bestMovie['id']);

        return $bestMovie;
    }


    public function getMovieDetails(int $movieId): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/'.$movieId, [
            'query' => ['api_key' => $this->apiKey]
        ]);

        return $response->toArray();
    }

    public function getMovieTrailer(int $movieId): ?string
    {
        $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/{$movieId}/videos", [
            'query' => ['api_key' => $this->apiKey],
        ]);

        $videos = $response->toArray()['results'];

        foreach ($videos as $video) {
            // The most common source is YouTube, so look for that type
            if (isset($video['site'], $video['type']) && $video['site'] === 'YouTube' && $video['type'] === 'Trailer') {
                // Return the YouTube URL
                return 'https://www.youtube.com/watch?v=' . $video['key'];
            }
        }

        // If no trailer is found, return null
        return null;
    }

    public function searchMovies(string $query): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/search/movie', [
            'query' => [
                'api_key' => $this->apiKey,
                'query' => $query,
            ],
        ]);
        
        return $response->toArray()['results'];
    }

}
