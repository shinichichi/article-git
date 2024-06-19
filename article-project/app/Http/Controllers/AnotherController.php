<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Illuminate\Support\Str;



class AnotherController extends Controller
{
    /**
     * ユーザーの記事一覧新しい順に10個表示 
     */
    public function index()
    {
        // おすすめ記事5個取得
        $this->article = new Article();
        $favorites = $this->article->getUserNameByIdFive();

        // サムネイルがある場合サムネイル保管パスをつける
        for ($i = 0; $i < 5; $i++) {
            if ($favorites[$i]->thumbnail != null) {
                $favorites[$i]->thumbnail = ('image/' . $favorites[$i]->thumbnail);
            }
        }
        // アップデート日の年月日のみ取得
        foreach ($favorites as $favorite) {
            $dates[] = Carbon::parse($favorite->updated_at)->format('Y-m-d');
        }

        // 一覧表示
        $this->article = new Article();
        $articles = $this->article->getUserNameById();

        // サムネイル画像があるストレージから取得
        for ($i = 0; $i < 10; $i++) {
            if ($articles[$i]->thumbnail != null) {
                $articles[$i]->thumbnail = ('image/' . $articles[$i]->thumbnail);
            }
        }
        // アイコン画像がある場合ストレージから取得
        for ($i = 0; $i < 10; $i++) {
            if ($articles[$i]->icon != null) {
                $articles[$i]->icon = ('image/' . $articles[$i]->icon);
            }
        }
        session()->flash('flash_message', '最新記事一覧');

        return view('article.index')->with([
            "dates" => $dates,
            "favorites" => $favorites,
            "articles" => $articles,
        ]);
    }

    /**
     * ユーザーの個別記事表示(GET)
     */
    public function articleshow($id)
    {
        // dd($id);
        // $value = session()->pull('article');
        $article = Article::where('id', $id)->first();
        // dd($article);
        // マークダウンテキストをHTMLにコンバート
        $article['markdown_text'] = Str::markdown($article['markdown_text']);

        return view('article.show', compact('article'));
    }
}
