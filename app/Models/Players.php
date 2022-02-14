<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $table = 'players';
    protected $guarded = ['id'];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
