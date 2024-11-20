<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // aiming to fetch all posts by country from user
    public function posts() {
        return $this->hasManyThrough('App\Models\Post', 'App\Models\User'); // can have another parameter that contains custom field name
    }
}
