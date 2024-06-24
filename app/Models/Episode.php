<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'season_id', 'episode_number', 'name', 'overview', 'air_date'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}