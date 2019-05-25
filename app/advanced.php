<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class advanced extends Model
{
    protected $fillable = [
        'user_id', 'facebook', 'twitter', 'linkedin', 'video',
    ];
}
