<x-app-layout>
    @push(('styles'))
    <link rel="stylesheet" href="{{ asset('highlight/styles/base16/atelier-lakeside.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <!-- <script>hljs.highlightAll();</script> -->
    <script>
    </script>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"> 
                <p>タイトル</p>
                <p>{{ $article['title'] }}</p>

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

                <!-- public_type -->
                <p>公開設定：</p>
                @if ($article['public_type'] === 0)
                <p>　全体に公開</p>
                @elseif ($article['public_type'] === 1)
                <p>　限定公開</p>
                @elseif ($article['public_type'] === 2)
                <p>　公開停止</p>
                @endif
</br>

                <!-- draft -->
                <p>下書き設定：</p>
                @if ($article['draft'] === 0)
                <p>　下書き</p>
                @elseif ($article['draft'] === 1)
                <p>　投稿</p>
                @endif
</br>

                </div>
            </div>
        </div>
    </div>

    <div>
        <form action="{{ route('article.edit') }}" method="post">
            @csrf
            {{-- @method('PATCH') --}}
            <input type="hidden" name="id" value="{{ $article->id }}">
            <button>編集する</button>
        </form>
    </div>

    <div id="app"></div>

    {{-- <comment id="app" :comment-string='@json($article->id)'></comment> --}}

    <div id="app2"></div>

    <dev id="app3"></dev>

    <comment2 :article="{{ $article }}"></comment2>

</x-app-layout>

@push('scripts')
<script src="{{ asset('/highlight/package.json') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
    const easyMDE = new EasyMDE({element: document.getElementById('markdown-editor')});
</script>
@endpush