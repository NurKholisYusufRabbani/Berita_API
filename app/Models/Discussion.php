<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = ['article_token', 'title'];


    // Relasi ke SavedArticle (foreign key: saved_article_id)
    public function savedArticle()
    {
        return $this->belongsTo(SavedArticle::class);
    }

    // Relasi ke komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke user (jika diskusi disimpan oleh user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
