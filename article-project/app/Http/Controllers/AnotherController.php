<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AnotherController extends Controller
{
    /**
     * ユーザーの記事一覧新しい順に10個表示 
     */
    public function index()
    {
        // おすすめ記事5個取得
        $favorites = Article::where('is_delete', null)->with('user')->orderBy('updated_at',  'desc')->get();
        // サムネイルがある場合サムネイル保管パスをつける
        for ($i = 0; $i < 5; $i++) {
            if ($favorites[$i]->thumbnail !== null && $favorites[$i]->imagedata === null) {
                $favorites[$i]->thumbnail = ('image/' . $favorites[$i]->thumbnail);
            }
        }
        // アップデート日の年月日のみ取得
        foreach ($favorites as $favorite) {
            $dates[] = Carbon::parse($favorite->updated_at)->format('Y-m-d');
        }
        // 新しい記事順に一覧表示  5件
        $articles = Article::where('is_delete', null)
        ->with('user')
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();
        $count = 5;
        // テスト用サムネイル画像があるストレージからcount数取得
        for ($i = 0; $i < $count; $i++) {
            if ($articles[$i]->thumbnail != null) {
                $articles[$i]->thumbnail = ('image/' . $articles[$i]->thumbnail);
            }
        }
        // テスト用アイコン画像がある場合ストレージからcount数取得
        for ($i = 0; $i < $count; $i++) {
            if ($articles[$i]->icon != null) {
                $articles[$i]->icon = ('image/' . $articles[$i]->icon);
            }
        }
        session()->flash('flash_message', '最新記事一覧');
        return view('article.index')->with([
            "dates" => $dates,
            "favorites" => $favorites,
            "articles" => $articles,
            "count" => $count,
        ]);
    }

    /**
     * ユーザーの個別記事表示(GET)
     */
    public function articleshow($id)
    {
        $article = Article::where('id', $id)->first();
        // マークダウンテキストをHTMLにコンバート
        $article['markdown_text'] = Str::markdown($article['markdown_text']);

        if ($article['thumbnail'] !== null && $article['imagedata'] !== null) {
            $path = pathinfo($article['thumbnail']);
            // 拡張子
            if ($path['extension'] === 'svg') {
                $article['extension'] = 'svg+xml';
            } else {
                $article['extension'] = $path['extension'];
            }
        }

        return view('article.show', compact('article'));
    }
    //　マイページ表示
    public function mypage()
    {

        $articles = DB::table('articles')->where('user_id', Auth::user()->id)->get();
        $count = $articles->count();

        // テスト用サムネイル画像があるストレージからcount数取得
        for ($i = 0; $i < $count; $i++) {
            if ($articles[$i]->thumbnail != null) {
                $articles[$i]->thumbnail = ('image/' . $articles[$i]->thumbnail);
            }
        }

        return view('mypage.show', [
            'articles' => $articles,
            'count' => $count,
            // 'article_comments' => null,
            // 'article_goods' => null,
        ]);
    }
}
