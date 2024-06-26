<?php

namespace App\Interface;

interface TMDBRepositoryInterface
{
    public function create(array $data);
    public function insert(array $data);
    public function findByTmdbId($tmdbId);
}
