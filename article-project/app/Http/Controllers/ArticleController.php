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
use Intervention\Gif\Blocks\ImageData;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Jfcherng\Diff\Renderer\Html\Unified;
use League\HTMLToMarkdown\HtmlConverter;
use Carbon\Carbon;
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
            'thumbnail_image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'not_image' => 'required',
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
        // if (($file = $request->file('thumbnail_image_path')) !== null) {
        //     $article['thumbnail'] = $file->getClientOriginalName();
        //     $article['imagedata'] = file_get_contents($file);
        //     $request->session()->put([
        //         'image' => [
        //             'thumbnail' => $file->getClientOriginalName(),
        //             'imagedata' => file_get_contents($file),
        //         ]
        //     ]);
        //     $path = pathinfo($article['thumbnail']);
        //     // 拡張子
        //     if ($path['extension'] === 'svg') {
        //         $article['extension'] = 'svg+xml';
        //     } else {
        //         $article['extension'] = $path['extension'];
        //     }
        // } else {
        //     // 画像データなし処理
        //     session()->forget('image');
        //     $article['extension'] = null;
        // }

        // サムネ画像処理
        // 新記事に画像を登録する場合
        if (($file = $request->file('thumbnail_image_path')) !== null && $article['not_image'] === '1') {
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
        } elseif ($article['not_image'] === '0') {
            $article['thumbnail'] = null;
            $article['imagedata'] = null;
            $article['extension'] = null;
        }


        // 投稿するデータをセッションに登録
        $request->session()->put([
            'article' => [
                'not_image' => $article['not_image'],
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
            'not_image' => 'required',
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
        // セッション情報とpostされた情報が一致しない場合は、edit画面りエラーを返す
        $comparison['markdown_text'] = $result;
        if (
            $validated['not_image'] !== $comparison['not_image'] || $validated['title'] !== $comparison['title'] || $validated['article_type'] !== $comparison['article_type']
            || $validated['markdown_text'] !== $comparison['markdown_text'] || $validated['public_type'] !== $comparison['public_type'] || $validated['draft'] !== $comparison['draft']
        ) {
            return redirect()->route('article.create')->withErrors(['title', 'markdown_text'])->with('error', 'データが一致しません。もう一度確認してください。');
        }

        $article = session()->get('article');
        // 画像ファイルあればarticleと合わせる
        // if ($image = session()->get('image')) {
        //     $article = array_merge($article, $image);
        // }
        if ($article['not_image'] === '1') {
            $image = session()->get('image');
            $article = array_merge($article, $image);
        } elseif ($article['not_image'] === '0') {
            $article['thumbnail'] = null;
            $article['imagedata'] = null;
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
        unset($article['not_image']);
        $article = Article::create($article);

        // 記事編集データ登録
        $articleHistory = [
            'article_id' => $article->id,
            'diff_text' => $result,
            'comment' => $comment,
            'crated_at' => $article['created_at'],
        ];
        ArticleEditHistory::create($articleHistory);
        session()->forget('article'); // 記事入力セッション削除

        return redirect('/index')->with('success', '投稿しました！！');
    }


    // 記事編集画面遷移
    public function edit(Request $request)
    {
        $article = Article::where('id', $request->id)->first();
        if ($article->thumbnail !== null) {
            $path = pathinfo($article['thumbnail']);
            // 拡張子
            if ($path['extension'] === 'svg') {
                $article['extension'] = 'svg+xml';
            } else {
                $article['extension'] = $path['extension'];
            }
        }
        // session()->forget('image');
        return view('article.edit', ['article' => $article]);
    }
    // 記事編集画面
    public function editPostedPreference(Request $request)
    {
        // バリデーション処理
        $validated = $request->validate([
            'thumbnail_image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'not_image' => 'required',
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

        // dd($file = $request->file('thumbnail_image_path'));
        // サムネ画像処理
        // 旧記事に画像が登録されていたら
        $model = Article::where('id', $article['id'])->first();
        if ($model['thumbnail'] !== null && $model['imagedata'] !== null) {
            // 新記事に画像を登録する場合
            if (($file = $request->file('thumbnail_image_path')) !== null && $article['not_image'] === '1') {
                // dd($file);
                $filePath = $file->store('temp'); // ファイルを一時ディレクトリに保存
                $article['thumbnail'] = $file->getClientOriginalName();
                $article['imagedata'] = file_get_contents($file);
                $request->session()->put([
                    'image' => [
                        'thumbnail' => $file->getClientOriginalName(),
                        // 'imagedata' => $filePath,
                        'imagedata' => file_get_contents($file),
                        // 'file' => $file = $request->file('thumbnail_image_path')
                    ]
                ]);
                $path = pathinfo($article['thumbnail']);
                // 拡張子
                if ($path['extension'] === 'svg') {
                    $article['extension'] = 'svg+xml';
                } else {
                    $article['extension'] = $path['extension'];
                }
            } elseif($article['not_image'] === '0' || $article['not_image'] === '2') {
                $article['extension'] = null;
                $article['thumbnail'] = null;
                $article['imagedata'] = null;
            } elseif(($file = $request->file('thumbnail_image_path')) === null && $article['not_image'] === '1'){
                $article['thumbnail'] = $model['thumbnail'];
                $article['imagedata'] = $model['imagedata'];
                $path = pathinfo($article['thumbnail']);
                // 拡張子
                if ($path['extension'] === 'svg') {
                    $article['extension'] = 'svg+xml';
                } else {
                    $article['extension'] = $path['extension'];
                }

            }
            // 旧記事に画像がないなら
        } elseif ($model['thumbnail'] === null || $model['imagedata'] === null) {
            // 新記事に画像を登録する場合
            if (($file = $request->file('thumbnail_image_path')) !== null) {
                $filePath = $file->store('temp'); // ファイルを一時ディレクトリに保存
                $article['thumbnail'] = $file->getClientOriginalName();
                $article['imagedata'] = file_get_contents($file);
                $request->session()->put([
                    'image' => [
                        'thumbnail' => $file->getClientOriginalName(),
                        // 'imagedata' => file_get_contents($file),
                        // 'imagedata' => $filePath,
                        'imagedata' => file_get_contents($file),
                        // 'file' => $file = $request->file('thumbnail_image_path'),
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
                $article['extension'] = null;
                $article['thumbnail'] = null;
                $article['imagedata'] = null;
            }
        }

        // 投稿するデータをセッションに登録
        $request->session()->put([
            'article' => [
                'not_image' => $request->not_image,
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
        // dd($article);

        return view('article.edit_posted_preference', ['article' => $article]);
    }

    public function update(Request $request)
    {
        // セッション情報とpostされたものを比較する
        $comparison = $request->session()->get('article');
        $validated = $request->validate([
            'not_image' => 'required',
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
        // $article = Article::where('id', $request->id)->first();
        // セッション情報とpostされた情報が一致しない場合は、edit画面りエラーを返す
        $comparison['markdown_text'] = $result;
        if (
            $validated['not_image'] !== $comparison['not_image'] || $validated['id'] !== $comparison['id'] || $validated['title'] !== $comparison['title'] || $validated['article_type'] !== $comparison['article_type']
            || $validated['markdown_text'] !== $comparison['markdown_text'] || $validated['public_type'] !== $comparison['public_type'] || $validated['draft'] !== $comparison['draft']
        ) {
            $article = $validated;
            $request->session()->forget('article');
            return redirect()->route('article.edit', ['id' => $validated['id']])->withErrors(['title', 'markdown_text'])->with('error', 'データが一致しません。もう一度確認してください。');
        }

        // dd(session()->get('image'));
        $article = session()->get('article');
        $image = session()->get('image');
        // dd($image);
        // 画像ファイルあればarticleと合わせる
        if ($article['not_image'] === '1' && $image !== null) {
            // $article = array_merge($article, $image);
            // dd($image);
            $article['thumbnail'] = $image['thumbnail'];
            // $article['imagedata'] = file_get_contents(storage_path('app/' . $image['imagedata']));
            $article['imagedata'] = $image['imagedata'];
        } elseif ($article['not_image'] === '2' || $article['not_image'] === '0') {
            $article['thumbnail'] = null;
            $article['imagedata'] = null;
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
        unset($article['not_image']);
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

    // 一覧ページで画面スクロールした時の関数
    public function loadMore(Request $request)
    {
        try {
            $offset = $request->input('offset', 0); // オフセットを取得、デフォルトは0

            // おすすめ記事を5件取得
            $articles = Article::where('is_delete', null)
                ->with('user')
                ->orderBy('updated_at', 'desc')
                // ->orderBy('updated_at', 'asc')
                ->skip($offset)
                ->take(5)
                ->get();

            // 各記事のサムネイルとアイコンのパスを設定
            foreach ($articles as $article) {
                if ($article->thumbnail !== null && $article->imagedata == null) {
                    $article->thumbnail = asset('image/' . $article->thumbnail);
                } elseif ($article->thumbnail !== null && $article->imagedata !== null) {
                    $path = pathinfo($article['thumbnail']);
                    // 拡張子
                    if ($path['extension'] === 'svg') {
                        $article->extension = 'svg+xml';
                    } else {
                        $article->extension = $path['extension'];
                    }

                    $article->thumbnail = 'data:image/' . $article->extension . ';base64,' . base64_encode($article->imagedata);

                }
                if ($article->user && $article->user->icon !== null) {
                    $article->user->icon = asset('image/' . $article->user->icon);
                }
                // imagedata がある場合、バイナリデータを base64 エンコードして返す
                if ($article->imagedata !== null) {
                    $article->imagedata = base64_encode($article->imagedata);
                }
                $article->updated_at = Carbon::parse($article->updated_at)->format('Y-m-d');

                // // 各フィールドをUTF-8に変換
                // $article->title = mb_convert_encoding($article->title, 'UTF-8', 'auto');
                // $article->content = mb_convert_encoding($article->content, 'UTF-8', 'auto');
                // if ($article->user) {
                //     $article->user->user_name = mb_convert_encoding($article->user->user_name, 'UTF-8', 'auto');
                //     $article->user->account_name = mb_convert_encoding($article->user->account_name, 'UTF-8', 'auto');
                // }
                Log::info('aa', $article->toArray());

            }


            // JSON形式でレスポンスを返す
            return response()->json([
                'articles' => $articles,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            // エラーをログに記録
            Log::error('Error loading more articles: ' . $e->getMessage());
            Log::error($e->getTraceAsString()); // スタックトレースをログに記録
            return response()->json(['error' => 'Error loading more articles'], 500);
        }
    }
}
