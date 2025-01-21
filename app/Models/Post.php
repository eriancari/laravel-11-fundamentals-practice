<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    // $fillable - to allow mass assignment on a create method
    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function photos() {
        return $this->morphMany('App\Models\Photo', 'imageable');
    }

    public function tags() {
        return $this->morphToMany('App\Models\Tag', 'taggable'); // polymorphic many to many
    }
}
