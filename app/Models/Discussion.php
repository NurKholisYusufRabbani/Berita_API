<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model
{
    use HasFactory;
    
    protected $fillable = ['article_token', 'title'];

    public function savedArticle() {
        return $this->belongsTo(SavedArticle::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
