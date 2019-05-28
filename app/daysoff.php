<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class daysoff extends Model
{
    protected $fillable = [
        'user_id', 'day', 'month',
    ];
}
