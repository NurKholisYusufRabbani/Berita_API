<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject  // Implementasi JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Implementasi yang wajib untuk JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Mengembalikan ID dari user
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function savedArticles()
    {
        return $this->hasMany(SavedArticle::class);
    }
}
