<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $table = 'game_session';
    protected $guarded = ['id'];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
