<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function post() {
        return $this->hasOne('App\Models\Post'); // determines the user_id
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function roles() {
        /**
         * To customize table names and columns, follow the format below:
         * - 2nd param: custom table name;
         * - 3rd param: foreign key
         * 
         * return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_id', 'role_id');
         * 
         */
        
        return $this->belongsToMany('App\Models\Role')->withPivot('created_at', 'updated_at');
    }

    public function photos() {
        return $this->morphMany('App\Models\Photo', 'imageable');
    }

    public function address() {
        return $this->hasOne('App\Models\Address');
    }
}
