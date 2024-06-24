<?php

namespace App\Interface;

interface TMDBRepositoryInterface
{
    public function create(array $movieData);
    public function findById($tmdbId);
}
