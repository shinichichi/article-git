<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleEditHistory extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null;
    protected $fillable = [
        'user_id',
        'article_id',
        'diff_text',
        'comment',
        'created_at',
    ];
}
