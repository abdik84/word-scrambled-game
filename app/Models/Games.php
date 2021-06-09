<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;

    public function details() {
        return $this->hasMany('App\Models\GamesDetail', 'games_id');
    }
}
