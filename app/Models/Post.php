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
        'title',
        'content'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
