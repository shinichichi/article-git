<x-app-layout>
    <div>
        @if(optional($articles) && $article_comments === null && $article_goods === null)
            <p>記事一覧</p>
            <a href="{{ route('mypage.comment_list') }}">コメント一覧</a></br>
            <a href="{{ route('mypage.good_list') }}">いいね一覧</a>

            @if($articles === 'なし')
                <p>記事投稿がありません</p>
            @elseif($articles !== 'なし')
                @foreach($articles as $article)
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900"> 
                            <p>記事内容：</p>
                            <p>{!! $article['markdown_text'] !!}</p>
            </br>

                            <!-- article_type -->
                            <p>記事タイプ：</p>
                            @if ($article['article_type'] === 0)
                            <p>　記事</p>
                            @elseif ($article['article_type'] === 1)
                            <p>　Q&A</p>
                            @elseif ($article['article_type'] === 2)
                            <p>　意見交換</p>
                            @endif
            </br>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

        @elseif(optional($article_comments) && $article_goods === null && $articles === null)
            <a href="{{ route('mypage.show') }}">記事一覧</a></br>
            <p>コメント一覧</p>
            <a href="{{ route('mypage.good_list') }}">いいね一覧</a>

            @if($article_comments === 'なし')
                <p>記事投稿がありません</p>
            @elseif($article_comments !== 'なし')
                @foreach($article_comments as $article_comment)
                    <p>{{ $article_comment }}</p>
                @endforeach
            @endif

        @elseif(optional($article_goods) && $article_comments === null && $articles === null)
            <a href="{{ route('mypage.show') }}">記事一覧</a></br>
            <a href="{{ route('mypage.comment_list') }}">コメント一覧</a>
            <p>いいね一覧</p>
            @if($article_goods === 'なし')
                <p>記事投稿がありません</p>
            @elseif($article_goods !== 'なし')
                @foreach($article_goods as $article_good)
                    <p>{{ $article_good }}</p>
                @endforeach
            @endif
        @endif
    </div>
</x-app-layout>