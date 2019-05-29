<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail extends Model
{
    protected $fillable = [
        'user_id', 'usertype', 'profile_address', 'country', 'state', 'city', 'street', 'resume', 'skill', 'schedule',
    ];
}
