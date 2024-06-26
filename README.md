# TMDB API Integration Application

## Overview

This Laravel application integrates with The Movie Database (TMDB) API to import movies and TV series data into a local database. It uses a repository pattern for database interactions and separates business logic into services for clean architecture. The application provides two main endpoints for importing data from TMDB based on the number of pages specified in the request.

## Features

- **Series Import**: Import TV series along with their seasons from TMDB.
- **Episodes Import**: Import episodes for each season of a TV series from TMDB.
- **Movies Import**: Import movies from TMDB.
- **Repository Pattern**: Utilizes the repository pattern for database operations, providing a clean abstraction layer.
- **Service Layer**: Contains business logic separated from the controller logic, making the application easier to maintain.
- **Service Provider**: Binds interfaces to repositories, ensuring loose coupling and high cohesion.

## Getting Started

### Prerequisites

- PHP 8.1.2
- Composer
- Laravel
- A TMDB API key

### Installation

1. Clone the repository to your local machine.
2. Navigate to the project directory and install dependencies with Composer:
    ```sh
    composer install
    ```
3. Copy `.env.example` to `.env` and configure your application settings, including your TMDB API key:
    ```plaintext
    APP_URL=http://localhost
    TMDB_API_KEY=your_api_key_here
    ```
4. Generate an application key:
    ```sh
    php artisan key:generate
    ```
5. Serve the application:
    ```sh
    php artisan serve
    ```
    The application will be available at `http://localhost:8000`.

## Usage

### Import TV Series

- **Endpoint**: `http://localhost:8000/api/series/import?totalPages=1`
- **Method**: GET
- **Description**: Imports TV series along with their seasons based on the number of pages specified.

### Import Movies

- **Endpoint**: `http://localhost:8000/api/movies/import?type=movie&totalPages=25`
- **Method**: GET
- **Description**: Imports movies based on the number of pages specified.

#### Import Episodes for a TV Series

- **Endpoint**: `http://localhost:8000/api/series/{serie_id}/import-episodes?serie_id=121`
- **Method**: GET
- **Description**: Imports episodes for a specific season of a TV series.

## Structure

The application follows a standard Laravel folder structure:

- `app/Services`: Contains service classes responsible for implementing business logic and calling repositories.
- `app/Repositories`: Contains repository classes responsible for database interactions using Eloquent.
- `app/Http/Controllers`: Contains controller classes that handle API endpoints.
- `database/migrations`: Contains migration files for defining database tables and structures.
- `routes`: Contains route files that define API endpoints.

## Database Schema

### Example Schema

#### movies:

- id
- tmdb_id
- title
- overview
- release_date
- poster_path
- created_at
- updated_at

#### series:

- id
- tmdb_id
- name
- overview
- first_air_date
- poster_path
- created_at
- updated_at

#### seasons:

- id
- series_id
- tmdb_id
- season_number
- overview
- poster_path
- created_at
- updated_at

#### episodes:

- id
- season_id
- tmdb_id
- episode_number
- name
- overview
- air_date
- created_at
- updated_at


## TMDB API Key Configuration

1. Go to TMDB Developer Portal and register or log in.
2. Generate an API key in your profile settings.
3. Copy the generated API key.
4. Add the API key to your `.env` file:
    ```plaintext
    TMDB_API_KEY=your_api_key_here
    ```

## API Requests Examples

### Import TV Series

- **Endpoint**: `http://localhost:8000/api/series/import?totalPages=1`
- **Method**: GET
- **Parameters**: `totalPages` (optional, default: 1)
- **Description**: Imports TV series along with their seasons based on the specified number of pages.

### Import Movies

- **Endpoint**: `http://localhost:8000/api/movies/import?totalPages=25`
- **Method**: GET
- **Parameters**: `totalPages`
- **Description**: Imports movies based on the specified number of pages.

### Import Episodes for a TV Series

- **Endpoint**: `http://localhost:8000/api/series/{serie_id}/import-episodes?serie_id=121`
- **Method**: GET
- **Parameters**: `serie_id`
- **Description**: Imports episodes for a specific tv-serie based on the id of a TV series.

### Code example for Importing Episodes for a TV Series

The `importEpisodesForSeries` method in the `EpisodeService` class demonstrates the process of importing episodes for a specific TV series. Here's a breakdown of its logic:

1. **Fetching Seasons**: It starts by fetching all seasons associated with the given series ID using the `SeasonRepository`.

    ```php
    $seasons = $this->seasonRepository->findBySerieId($serieId);
    ```

2. **Retrieving TMDB ID**: For the TMDB API calls, it retrieves the TMDB ID of the series from the first season's data.

    ```php
    $tmdbId = $this->seasonRepository->getSerieId($seasons[0]->id);
    ```

3. **Iterating Over Seasons**: For each season, it fetches the episodes from the TMDB API.

    ```php
    $episodes = $this->tmdbService->getSeasonData($tmdbId, $season->season_number);
    ```

4. **Inserting Episodes**: Upon finding episodes, it populates an array in preparation for database insertion, ensuring no duplicates by verifying the non-existence of each episode.
    ```php
    if ($existingEpisode === null) {
        // Prepare episode data for insertion
    }
    ```

5. **Bulk Insertion**: After preparing the data for all episodes in a season, it performs a bulk insertion to the database.

    ```php
    $this->episodeRepository->insert($episodesData);
    ```

This method efficiently handles the import of episodes by leveraging the TMDB API, ensuring data integrity through duplicate checks, and optimizing database interactions with bulk insertions.


