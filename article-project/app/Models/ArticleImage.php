<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory;


    // ◇リレーション

    // 記事
    public function articles()
    {
        return $this->belongsTo('App\Models\Article');
    }
}
