WeMovies

WeMovies is a movie search application built using Symfony and API Platform. The application allows users to search for movies, browse by genre, and view details such as titles, descriptions, and trailers. The app utilizes The Movie Database (TMDB) API to fetch movie data and provides a clean, responsive user interface with autocomplete functionality for the search bar.

Features

Search Movies: Search for movies by title with autocomplete suggestions.
Filter by Genre: Browse movies by selecting a genre from the sidebar.
Display Movie Details: View movie titles, descriptions, and trailers.
Responsive Design: Works on both mobile and desktop devices.
Autocomplete: Real-time search suggestions as the user types.
Technologies Used

Symfony 5.4: PHP framework for building the backend.
API Platform: Used to create API endpoints.
PHP 8+
jQuery: For dynamic interactivity and AJAX-based movie search.
Bootstrap 5: For responsive design and UI components.
Webpack Encore: Asset management and bundling.
TMDB API: External API used to fetch movie and genre data.
Prerequisites

PHP 8.x or higher
Composer
Node.js with npm or yarn
Symfony CLI (optional but recommended)
TMDB API Key (sign up at https://www.themoviedb.org/)
Installation

Clone the repository
bash
Copy code
git clone https://github.com/yourusername/we-cine.git
cd we-cine
Install PHP dependencies
bash
Copy code
composer install
Install JavaScript dependencies
bash
Copy code
npm install
Set up environment variables
Copy .env to .env.local and add your TMDB API key:

bash
Copy code
cp .env .env.local
Then edit .env.local to include your API key:

env
Copy code
TMDB_API_KEY=your_tmdb_api_key_here
Build frontend assets
Use Webpack Encore to build your assets:

bash
Copy code
npm run dev
Run the Symfony server
bash
Copy code
symfony serve
Access the application
Open your browser and go to:

bash
Copy code
http://localhost:8000
