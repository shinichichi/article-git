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
use League\HTMLToMarkdown\HtmlConverter;
// ログ確認用
use Illuminate\Support\Facades\Log;


class ArticleController extends Controller
{
    // 記事作成画面遷移
    public function create()
    {
        return view('article.create');
    }

    // 記事作成確認画面
    public function createPostedPreference(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required',
            'article_type' => 'required',
            'markdown_text' => 'required',
            'public_type' => 'required',
            'draft' => 'required',
            // 'created_at' => 'required',
            // 'updated_at' => 'required',
            // 'is_delete' => 'required',
        ]);

        $article = $validated;
        // サムネ画像の処理
        if (($file = $request->file('thumbnail_image_path')) !== null) {
            $article['thumbnail'] = $file->getClientOriginalName();
            $article['imagedata'] = file_get_contents($file);
            $request->session()->put([
                'image' => [
                    'thumbnail' => $file->getClientOriginalName(),
                    'imagedata' => file_get_contents($file),
                ]
            ]);
            $path = pathinfo($article['thumbnail']);
            // 拡張子


            if ($path['extension'] === 'svg') {
                $article['extension'] = 'svg+xml';
            } else {
                $article['extension'] = $path['extension'];
            }
        } else {
            // 画像データなし処理
            session()->forget('image');
            $article['extension'] = null;
        }

        // 投稿するデータをセッションに登録
        $request->session()->put([
            'article' => [
                'title' => $request->title,
                'markdown_text' => $request->markdown_text,
                'article_type' => $request->article_type,
                'public_type' => $request->public_type,
                'draft' => $request->draft,
            ]
        ]);
        // マークダウンテキストをHTMLにコンバート
        $article['markdown_text'] = Str::markdown($article['markdown_text']);
        return view('article.create_posted_preference', ['article' => $article]);
    }

    // 新規記事投稿処理
    public function store(Request $request)
    {
        // セッション情報とpostされたものを比較する
        $comparison = $request->session()->get('article');
        $validated = $request->validate([
            'title' => 'required',
            'article_type' => 'required',
            'markdown_text' => 'required',
            'public_type' => 'required',
            'draft' => 'required',
            // 'created_at' => 'required',
            // 'updated_at' => 'required',
            // 'is_delete' => 'required',
        ]);
        // $comparison['markdown_text'] = Str::markdown($comparison['markdown_text']);
        $lines = preg_split('/\r\n|\r|\n/', $comparison['markdown_text']);
        // 最後の行を除いて結合し、各行の後ろに\r\nを追加
        $result = '';
        $lineCount = count($lines);
        foreach ($lines as $index => $line) {
            if ($index < $lineCount - 2) {
                $result .= $line;
                $result .= "\r\n";
            } elseif ($index === $lineCount - 2) {
                $result .= $line;
            }
        }
        // セッション情報とpostされた情報が一致しない場合は、edit画面りエラーを返す
        $comparison['markdown_text'] = $result;
        if ($validated['title'] !== $comparison['title'] || $validated['article_type'] !== $comparison['article_type'] 
        || $validated['markdown_text'] !== $comparison['markdown_text'] || $validated['public_type'] !== $comparison['public_type'] || $validated['draft'] !== $comparison['draft']) {
            return redirect()->route('article.create')->withErrors(['title', 'markdown_text'])->with('error', 'データが一致しません。もう一度確認してください。');
        }


        
        $article = session()->get('article');
        // 画像ファイルあればarticleと合わせる
        if ($image = session()->get('image')) {
            $article = array_merge($article, $image);
        }
        // 記事編集データ作成
        $comment = 'コメントなし';
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
        // dd($article);

        // 記事編集データ登録
        $articleHistory = [
            'article_id' => $article->id,
            'diff_text' => $result,
            'comment' => $comment,            'crated_at' => $article['created_at'],
        ];
        ArticleEditHistory::create($articleHistory);
        session()->forget('article'); // 記事入力セッション削除
        
        return redirect('/index')->with('success' , '投稿しました！！');
    }


    // 記事編集画面遷移
    public function edit(Request $request)
    {
        $article = Article::where('id', $request->id)->first();
        return view('article.edit', ['article' => $article]);
    }

    // 記事編集画面
    public function editPostedPreference(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'article_type' => 'required',
            'markdown_text' => 'required',
            'public_type' => 'required',
            'draft' => 'required',
            // 'created_at' => 'required',
            // 'updated_at' => 'required',
            // 'is_delete' => 'required',
        ]);
        $article = $validated;
        // サムネ画像の処理
        if (($file = $request->file('thumbnail_image_path')) !== null) {
            $article['thumbnail'] = $file->getClientOriginalName();
            $article['imagedata'] = file_get_contents($file);
            $request->session()->put([
                'image' => [
                    'thumbnail' => $file->getClientOriginalName(),
                    'imagedata' => file_get_contents($file),
                ]
            ]);
            $path = pathinfo($article['thumbnail']);
            // 拡張子

            if ($path['extension'] === 'svg') {
                $article['extension'] = 'svg+xml';
            } else {
                $article['extension'] = $path['extension'];
            }
        } else {
            // 画像データなし処理
            session()->forget('image');
            $article['extension'] = null;
        }

        // 投稿するデータをセッションに登録
        $request->session()->put([
            'article' => [
                'id' => $request->id,
                'title' => $request->title,
                'markdown_text' => $request->markdown_text,
                'article_type' => $request->article_type,
                'public_type' => $request->public_type,
                'draft' => $request->draft,
            ]
        ]);
        // マークダウンテキストをHTMLにコンバート
        $article['markdown_text'] = Str::markdown($article['markdown_text']);


        return view('article.edit_posted_preference', ['article' => $article]);
    }

    public function update(Request $request)
    {
        // セッション情報とpostされたものを比較する
        $comparison = $request->session()->get('article');
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'article_type' => 'required',
            'markdown_text' => 'required',
            'public_type' => 'required',
            'draft' => 'required',
            // 'created_at' => 'required',
            // 'updated_at' => 'required',
            // 'is_delete' => 'required',
        ]);
        $comparison['markdown_text'] = Str::markdown($comparison['markdown_text']);
        $lines = preg_split('/\r\n|\r|\n/', $comparison['markdown_text']);
        // 最後の行を除いて結合し、各行の後ろに\r\nを追加
        $result = '';
        $lineCount = count($lines);
        foreach ($lines as $index => $line) {
            if ($index < $lineCount - 2) {
                $result .= $line;
                $result .= "\r\n";
            } elseif ($index === $lineCount - 2) {
                $result .= $line;
            }
        }
        dd($comparison);
        // $article = Article::where('id', $request->id)->first();
        // セッション情報とpostされた情報が一致しない場合は、edit画面りエラーを返す
        $comparison['markdown_text'] = $result;
        if ($validated['id'] !== $comparison['id'] || $validated['title'] !== $comparison['title'] || $validated['article_type'] !== $comparison['article_type'] 
        || $validated['markdown_text'] !== $comparison['markdown_text'] || $validated['public_type'] !== $comparison['public_type'] || $validated['draft'] !== $comparison['draft']) {
            // dd($validated);
            $article = $validated;
            return redirect()->route('article.edit', ['id' => $validated['id']])->withErrors(['title', 'markdown_text'])->with('error', 'データが一致しません。もう一度確認してください。');
        }

        $article = session()->get('article');
        // 画像ファイルあればarticleと合わせる
        if (($image = session()->get('image')) !== null) {
            $article = array_merge($article, $image);
        }
        // 記事編集履歴データ作成
        if ($request->comment === '') {
            $comment = 'コメントなし';
        } else {
            $comment = $request->comment;
        }

        // 記事編集データ作成
        $diff = Article::where('id', $article['id'])->first();
        $differOptions = [
            'context' => 3,
        ];
        $rendererOptions =  [
            'detailLevel' => 'line',
        ];
        $rendererName = 'Unified';
        $result = DiffHelper::calculate($diff['markdown_text'], $article['markdown_text'], $rendererName, $differOptions, $rendererOptions);

        // 記事のupdate
        $article['updated_at'] = date('Y-m-d H:i:s');
        // dd($article['markdown_text'] .= "\r\n");
        $article = Article::where('id', $article['id'])->update($article);

        // 記事編集履歴登録
        $articleHistory = [
            'article_id' => $validated['id'],
            'diff_text' => $result,
            'comment' => $comment,
            'crated_at' => date('Y-m-d H:i:s'),
        ];
        ArticleEditHistory::create($articleHistory);
        session()->forget('article'); // 記事編集フォームセッション削除
        session()->forget('image'); // 画像セッション削除

        return redirect('/index')->with('success', '記事を編集しました！！');
        // return redirect()->route('articles.index')->with('success', '記事を投稿しました');
        // 
    }

    public function loadMore(Request $request)
    {
        try {
            $offset = $request->input('offset', 0);
    
            // おすすめ記事5個取得
            $articles = Article::where('is_delete', null)
                ->with('user')
                ->orderBy('updated_at', 'desc')
                ->skip(10)
                ->take(10)
                ->get();
    
            // 各記事のサムネイルとアイコンのパスを設定
            foreach ($articles as $article) {
                if ($article->thumbnail !== null) {
                    $article->thumbnail = asset('image/' . $article->thumbnail);
                }
                if ($article->user && $article->user->icon !== null) {
                    $article->user->icon = asset('image/' . $article->user->icon);
                }
            }
    
            return response()->json([
                'articles' => $articles,
            ]);
        } catch (\Exception $e) {
            // エラーをログに記録
            Log::error('Error loading more articles: ' . $e->getMessage());
            return response()->json(['error' => 'Error loading more articles'], 500);
        }
    }
}