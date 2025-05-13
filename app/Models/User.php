<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mendapatkan ID unik user untuk JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Mendapatkan klaim tambahan untuk JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relasi ke artikel yang disimpan
    public function savedArticles()
    {
        return $this->hasMany(SavedArticle::class);
    }

    // Relasi ke komentar yang ditulis user
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke balasan komentar
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
