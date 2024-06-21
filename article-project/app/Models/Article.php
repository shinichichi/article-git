<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'user_id',
        'thumbnail',
        'imagedata',
        'article_type',
        'markdown_text',
        'public_type',
        'draft',
        'created_at',
        'updated_at',
        'is_delete',
    ];

    // 記事を10個取得
    public function getUserNameById() {
    return DB::table('articles')
            ->select(
            'users.user_name',
            'users.account_name',
            'users.icon',
            'articles.thumbnail',
            'articles.*', 'users.id as users.id', 'articles.id',
            'articles.*', 'users.created_at as users.created_at', 'articles.created_at',
            'articles.*', 'users.updated_at as users.updated_at', 'articles.updated_at',
            'articles.*', 'users.is_delete as users.is_delete', 'articles.is_delete',)
            ->join('users', 'articles.user_id', '=', 'users.id')
            ->latest('articles.updated_at')
        //     ->take(10)
            ->get();
    }

    // 記事を5個取得
    public function getUserNameByIdFive() {
        return DB::table('articles')
                ->select('users.user_name',
                'articles.thumbnail',
                'users.account_name',
                'articles.*', 'users.id as users.id', 'articles.id',
                'articles.*', 'users.created_at as users.created_at', 'articles.created_at',
                'articles.*', 'users.updated_at as users.updated_at', 'articles.updated_at',
                'articles.*', 'users.is_delete as users.is_delete', 'articles.is_delete',)
                ->join('users', 'articles.user_id', '=', 'users.id')
                ->latest('articles.updated_at')
                ->take(5)
                ->get();
        }


        // ◇リレーション

        // 記事画像
        public function articleImages()
        {
                return $this->hasMany('App\Models\ArticleImage');
        }
        public function user(){
                return $this->belongsTo('App\Models\User');
        }
}
