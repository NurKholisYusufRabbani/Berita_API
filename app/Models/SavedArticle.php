<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedArticle extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'url', 'summary', 'section'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function discussion() {
        return $this->hasOne(Discussion::class);
    }
}
