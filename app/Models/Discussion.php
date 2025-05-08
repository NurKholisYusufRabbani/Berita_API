<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saved_article_id',
        'title',
        'content',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke SavedArticle
    public function savedArticle()
    {
        return $this->belongsTo(SavedArticle::class);
    }
}
