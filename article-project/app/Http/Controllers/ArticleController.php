<?php

namespace App\Http\Controllers;

use App\Models\ArticleEditHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Jfcherng\Diff\Renderer\Html\Unified;

class ArticleController extends Controller
{

    // public function index(){
    //     $articles = Article::get();
    //     $n = null;
    //     if(count($articles) <= 0){
    //         $n = 'nothing';
    //     }elseif(count($articles) === 1){
    //         $n = $articles;
    //     }elseif(count($articles) > 0){
    //         foreach($articles as $article){
    //             $n[] = $article;
    //         }
    //     }
    //     $articles = $n;
    //     return view('article.index', ['articles' => $articles]);
    // }


    // 記事作成画面遷移
    public function create(){
        return view('article.create');
    }
    
    // 記事作成確認画面
    public function createPostedPreference(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required',
            'article_type' => 'required',
            'markdown_text'=> 'required',
            'public_type' => 'required',
            'draft' => 'required',
            // 'created_at' => 'required',
            // 'updated_at' => 'required',
            // 'is_delete' => 'required',
        ]);

        $article = $validated;
        // マークダウンテキストをHTMLにコンバート
        $article['markdown_text'] = Str::markdown($article['markdown_text']);

        // 投稿するデータをセッションに登録
        $request->session()->put([
            'article' =>[
                'title' => $request->title,
                'markdown_text' => $request->markdown_text,
                'article_type' => $request->article_type,
                'public_type' => $request->public_type,
                'draft' => $request->draft,
            ]
        ]);

        return view('article.create_posted_preference',['article' => $article]);
    }

    // 新規記事投稿処理
    public function store(Request $request) {
        $article = session()->get('article');
        // 記事編集データ作成
        $diff = '';
        $differOptions = [
            'context' => 3,
        ];
        $rendererOptions =  [
            'detailLevel' => 'line',
        ];
        $rendererName = 'Unified';
        $result = DiffHelper::calculate($diff, $article['markdown_text'], $rendererName, $differOptions, $rendererOptions);
        $renderer = RendererFactory::make('SideBySide', $rendererOptions);
        // $htmlDiff = $renderer->render($result, $differOptions);

        // 記事データ作成登録
        $article['user_id'] = auth()->id();
        $article['created_at'] = date('Y-m-d H:i:s');
        $article = Article::create($article);

        // 記事編集データ登録
        $articleHistory = [
            'article_id' => $article->id,
            'diff_text' => $result,
            'comment' => $request->comment,
            'crated_at' => $article['created_at'],
        ];
        ArticleEditHistory::create($articleHistory);
        session()->forget('article'); // 記事入力セッション削除
        return redirect('/index');
    }

    // public function show(Request $request)
    // {
    //     $value = session()->pull('article');
    //     $article = Article::where('id', $request->id)->first();
    //     // dd($article);
    //     // $article['markdown_text'] = Markdown::convert($article->markdown_text);
    //     // dd($article['markdown_text']);

    //     // dd($article);
    //     return view('article.show',compact('article'));
    // }


    // 記事編集画面遷移
    public function edit(Request $request)
    {
        $article = Article::where('id',$request->id)->first();
        return view('article.edit',['article' => $article]);
    }

    // 記事編集画面
    public function editPostedPreference(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'article_type' => 'required',
            'markdown_text'=> 'required',
            'public_type' => 'required',
            'draft' => 'required',
            // 'created_at' => 'required',
            // 'updated_at' => 'required',
            // 'is_delete' => 'required',
        ]);
        $article = $validated;
        // マークダウンテキストをHTMLにコンバート
        $article['markdown_text'] = Str::markdown($article['markdown_text']);

        $request->session()->put([
            'article' =>[
                'id' => $request->id,
                'title' => $request->title,
                'markdown_text' => $request->markdown_text,
                'article_type' => $request->article_type,
                'public_type' => $request->public_type,
                'draft' => $request->draft,
            ]
        ]);

        return view('article.edit_posted_preference',['article' => $article]);
    }

    public function update(Request $request)
    {
        $article = session()->get('article');
        // 記事編集履歴データ作成
        $diff = Article::where('id', $article['id'])->first();
        $differOptions = [
            'context' => 3,
        ];
        $rendererOptions =  [
            'detailLevel' => 'line',
        ];
        $rendererName = 'Unified';
        $result = DiffHelper::calculate($diff['markdown_text'], $article['markdown_text'], $rendererName, $differOptions, $rendererOptions);

        // 記事編集登録
        $article['user_id'] = auth()->id();
        Article::where('id' , $article['id'])->update([
            'title' => $article['title'],
            'markdown_text' => $article['markdown_text'],
            'public_type' => $article['public_type'],
            'draft' => $article['draft'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // 記事編集履歴登録
        $articleHistory = [
            'article_id' => $article['id'],
            'diff_text' => $result,
            'comment' => $request->comment,
            'crated_at' => date('Y-m-d H:i:s'),
        ];
        ArticleEditHistory::create($articleHistory);
        session()->forget('article'); // 記事編集フォームセッション削除

        return redirect('/index');
    }


}
