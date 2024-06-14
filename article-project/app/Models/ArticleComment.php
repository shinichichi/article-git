<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'foreign_key_id',
        'table_type',
        'markdown_text',
        'created_at',
        'update_date_time',
        'is_delete',
    ];
}
