<?php

namespace App\Tests\Service;

use App\Service\TmdbService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TmdbServiceTest extends TestCase
{
    private $httpClient;
    private $tmdbService;

    protected function setUp(): void
    {
        // Mock the HttpClientInterface
        $this->httpClient = $this->createMock(HttpClientInterface::class);

        // Use the mocked HttpClient in the service
        $this->tmdbService = new TMDBService($this->httpClient, 'fake_api_key');
    }

    public function testGetGenres()
    {
        // Mock the response from the API
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn([
            'genres' => [
                ['id' => 28, 'name' => 'Action'],
                ['id' => 12, 'name' => 'Adventure'],
            ],
        ]);

        // Ensure the HttpClient returns the mocked response
        $this->httpClient
            ->method('request')
            ->willReturn($response);

        // Call the service method and check the result
        $genres = $this->tmdbService->getGenres();

        $this->assertCount(2, $genres);
        $this->assertEquals('Action', $genres[0]['name']);
        $this->assertEquals(28, $genres[0]['id']);
    }

    public function testGetMoviesByGenre()
    {
        // Mock the response from the API
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn([
            'results' => [
                ['id' => 123, 'title' => 'Sample Movie', 'poster_path' => '/sample.jpg', 'overview' => 'Sample Overview'],
            ],
        ]);

        // Ensure the HttpClient returns the mocked response
        $this->httpClient
            ->method('request')
            ->willReturn($response);

        // Call the service method and check the result
        $movies = $this->tmdbService->getMoviesByGenre(28);

        $this->assertCount(1, $movies);
        $this->assertEquals('Sample Movie', $movies[0]['title']);
        $this->assertEquals(123, $movies[0]['id']);
    }

    public function testGetMovieTrailer()
    {
        // Mock the response from the API
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn([
            'results' => [
                ['key' => 'abcd1234', 'site' => 'YouTube', 'type' => 'Trailer'],
            ],
        ]);

        // Ensure the HttpClient returns the mocked response
        $this->httpClient
            ->method('request')
            ->willReturn($response);

        // Call the service method and check the result
        $trailerUrl = $this->tmdbService->getMovieTrailer(123);

        $this->assertEquals('https://www.youtube.com/watch?v=abcd1234', $trailerUrl);
    }

    public function testGetMovieTrailerReturnsNullIfNoTrailer()
    {
        // Mock the response from the API (no trailers found)
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn([
            'results' => [],
        ]);

        // Ensure the HttpClient returns the mocked response
        $this->httpClient
            ->method('request')
            ->willReturn($response);

        // Call the service method and check the result
        $trailerUrl = $this->tmdbService->getMovieTrailer(123);

        // Assert that no trailer is returned
        $this->assertNull($trailerUrl);
    }
}
