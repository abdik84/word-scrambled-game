<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['username'];

    public function games() {
        return $this->hasMany('App\Models\Games', 'player_id');
    }
}
