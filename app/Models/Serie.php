<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = ['tmdb_id', 'name', 'overview', 'first_air_date', 'poster_path'];
    use HasFactory;

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}
