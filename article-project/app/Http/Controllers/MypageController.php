<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use GrahamCampbell\Markdown\Facades\Markdown;

class MypageController extends Controller
{
    public function index(){
        $articles = Article::where('user_id', Auth::id())->get();
        $n = null;
        if(count($articles) <= 0){
            $n = 'nothing';
        }elseif(count($articles) === 1){
            // $articles[0]['markdown_text'] = Markdown::convert($articles[0]['markdown_text']);
            $n = $articles;
        }elseif(count($articles) > 0){
            foreach($articles as $article){
                // $article['markdown_text'] = Markdown::convert($article['markdown_text']);
                $n[] = $article;
            }
        }
        $articles = $n;
        return view('article.index', ['articles' => $articles]);
    }

    // public function show(Request $request)
    // {
    //     $articles = Article::where('user_id', Auth::id())->get();
    //     $n = null;
    //     if(count($articles) <= 0){
    //         $articles = 'なし';
    //     }elseif(count($articles) === 1){
    //         // $articles[0]['markdown_text'] = Markdown::convert($articles[0]['markdown_text']);
    //         $n = $articles;
    //     }elseif(count($articles) > 0){
    //         foreach($articles as $article){
    //             // $article['markdown_text'] = Markdown::convert($article['markdown_text']);
    //             $n[] = $article;
    //         }
    //     }
    //     $articles = $n;

    //     return view('mypage.show', [
    //         'user' => Auth::user(),
    //         'articles' => $articles,
    //         'article_comments' => null,
    //         'article_goods' => null,
    //     ]);
    // }

    public function commentIndex()
    {
        $articles_comments = ArticleComment::where('user_id',Auth::id())->get();
        if(count($articles_comments) <= 0){
            $articles_comments = 'なし';
        }

        return view('mypage.show', [
            'user' => Auth::user(),
            'articles' => null,
            'article_comments' => $articles_comments,
            'article_goods' => null,
        ]);
    }

    public function goodIndex()
    {
        $article_goods = ArticleGood::where('user_id', Auth::id())->get();
        if(count($article_goods) <= 0){
            $article_goods = 'なし';
        }

        return view('mypage.show',[
            'user' => Auth::user(),
            'articles' => null,
            'article_comments' => null,
            'article_goods' => $article_goods,
        ]);
    }
}
