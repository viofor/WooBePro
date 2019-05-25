<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    protected $fillable = [
        'user_id', 'reviewer_id', 'stars', 'review', 'review_response',
    ];
}
