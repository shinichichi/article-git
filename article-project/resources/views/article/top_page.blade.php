<x-app-layout>
    <div class="grid grid-cols-12">
        <div class="grid-item col-span-2 lg:grid-col-span-2 gap-3"></div>
        <div class="py-12 col-span-8 lg:grid-col-span-8 gap-3">
            @foreach($articles as $article)
            <form action="{{ route('article.show') }}" method="post">
                @csrf
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900"> 
                            <p>記事内容：</p>
                            <p>{!! $article['markdown_text'] !!}</p>
</br>

                            <!-- article_type -->
                            <p>記事タイプ：</p>
                            @if ($article['article_type'] === 0)
                            <p>記事</p>
                            @elseif ($article['article_type'] === 1)
                            <p>Q&A</p>
                            @elseif ($article['article_type'] === 2)
                            <p>意見交換</p>
                            @endif
</br>

                            <!-- public_type -->
                            <p>公開設定：</p>
                            @if ($article->public_type === 0)
                            <p>全体に公開</p>
                            @elseif ($article->public_type === 1)
                            <p>限定公開</p>
                            @elseif ($article->public_type === 2)
                            <p>公開停止</p>
                            @endif
</br>

                            <!-- draft -->
                            <p>下書き設定：</p>
                            @if ($article->draft === 0)
                            <p>下書き</p>
                            @elseif ($article->draft === 1)
                            <p>投稿</p>
                            @endif
</br>

                            <input type="hidden" name="id" value="{{ $article->id }}">
                            <button type="submit">ボタン</button>
                        </div>
                    </div>
                </div>
            </form>
            @endforeach
        </div>
    </div>

</x-app-layout>