<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\Markdown\Facades\Markdown;

class ArticleController extends Controller
{

    public function index(){
        $articles = Article::get();
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
        // dd($articles);
        return view('article.index', ['articles' => $articles]);
    }


    public function create(){
        return view('article.create');
    }


    public function createPostedPreference(Request $request)
    {
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

        // dd($article['markdown_text']);
        // $article['markdown_text'] = Markdown::convert($article['markdown_text'])->getContent();
        $request->session()->put([
            'article' =>[
                'title' => $request->title,
                'markdown_text' => $request->markdown_text,
                'article_type' => $request->article_type,
                'public_type' => $request->public_type,
                'draft' => $request->draft,
            ]
        ]);

        // $article = [
        //     'title' => $request->title,
        //     'markdown_text' => $request->markdown_text,
        //     'article_type' => $request->article_type,
        //     'public_type' => $request->public_type,
        //     'draft' => $request->draft,
        // ];

        return view('article.create_posted_preference',['article' => $article]);
    }

    public function store(Request $request) {
        $article = session()->get('article');
        $article['user_id'] = auth()->id();
        $article['created_at'] = date('Y-m-d H:i:s');
        Article::create($article);
        session()->forget('article');
        return redirect('article/index');
    }

    public function show(Request $request)
    {
        $value = session()->pull('article');
        $article = Article::where('id', $request->id)->first();
        // dd($article);
        // $article['markdown_text'] = Markdown::convert($article->markdown_text);
        // dd($article['markdown_text']);

        // dd($article);
        return view('article.show',compact('article'));
    }

    public function edit(Request $request)
    {
        $article = Article::where('id',$request->id)->first();
        // dd($article);
        return view('article.edit',['article' => $article]);
    }

    public function editPostedPreference(Request $request)
    {
        // dd($request);
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
        // $article['markdown_text'] = Markdown::convert($article['markdown_text'])->getContent();


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
        // dd($article);


        return view('article.edit_posted_preference',['article' => $article]);
    }

    public function update()
    {
        // dd($i = session()->get('article'));

        $article = session()->get('article');
        $article['user_id'] = auth()->id();
        Article::where('id' , $article['id'])->update([
            'title' => $article['title'],
            'markdown_text' => $article['markdown_text'],
            'public_type' => $article['public_type'],
            'draft' => $article['draft'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        session()->forget('article');

        return redirect('/article/index');
    }


}
