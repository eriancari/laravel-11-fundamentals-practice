<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function posts() {
        $this->morphedByMany('App\Models\Post', 'taggable');
    }
    
    public function videos() {
        $this->morphedByMany('App\Models\Video', 'taggable');
    }
}
