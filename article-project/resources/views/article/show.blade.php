<x-app-layout>
    @push('styles')
        {{-- preタグのスタイル --}}
        <link rel="stylesheet" href="{{ asset('highlight/styles/base16/atelier-lakeside.css') }}">
        @vite(['resources/css/image.css', 'resources/css/sample.css'])
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- @if ($article['extension'] === null && $article['imagedata'] === null)
                        <img id="icon_img_prv" class="nospimgs img-thumbnail h-25 w-25 mb-10 mt-10 a"
                            src="{{ asset('image/articledfimage.jpg') }}" alt="">
                    @elseif($article['extension'] !== null && $article['imagedata'] !== null)
                        <img class="nospimgs img-thumbnail h-25 w-25 mb-10 mt-10 a"
                            src="data:image/{{ $article['extension'] }};base64,{{ base64_encode($article['imagedata']) }}"
                            alt="サムネイル画像">
                    @elseif($article['extension'] !== null && $article['imagedata'] === null)
                    @elseif($article['thumbnail'] !== null && $article['imagedate'] === null)
                    <img class="bora imagk100" src="{{ asset($article->thumbnail) }}"
                    alt="">

                    @endif --}}
                    @if($article['thumbnail'] !== null && $article['imagedata'] !== null)
                    <img class=" h-25 w-25 mb-10 mt-10 a radius "
                    src="data:image/{{ $article['extension'] }};base64,{{ base64_encode($article['imagedata']) }}"
                    alt="サムネイル画像">
                    @elseif($article['thumbnail'] !== null && $article['imagedata'] === null)
                    <img class=" h-25 w-25 mb-10 mt-10 a radius " src="{{ asset('image/'.$article->thumbnail) }}"
                    alt="">
                    @else
                    <img class="bora imagk100"
                    src="{{ asset('image/articledfimage200.jpg') }}" alt="">
                    @endif
                    {{-- <p>タイトル</p> --}}
                    <p class="text-xl center-btn pb-12 tl mt-12 ml-14 mr-14 line">{{ $article['title'] }}</p>

                    {{-- <p>記事内容：</p> --}}
                    <pre class="center-btn pb-3 k tl mt-14 ml-14 mr-14">{!! $article['markdown_text'] !!}</pre>
                    </br>

                    <!-- article_type -->
                    {{-- <p>記事タイプ：</p>
                @if ($article['article_type'] === 0)
                <p>　記事</p>
                @elseif ($article['article_type'] === 1)
                <p>　Q&A</p>
                @elseif ($article['article_type'] === 2)
                <p>　意見交換</p>
                @endif --}}
                    </br>
                    <!-- public_type -->
                    {{-- <p>公開設定：</p>
                @if ($article['public_type'] === 0)
                <p>　全体に公開</p>
                @elseif ($article['public_type'] === 1)
                <p>　限定公開</p>
                @elseif ($article['public_type'] === 2)
                <p>　公開停止</p>
                @endif --}}
                    {{-- </br> --}}

                    <!-- draft -->
                    {{-- <p>下書き設定：</p>
                @if ($article['draft'] === 0)
                <p>　下書き</p>
                @elseif ($article['draft'] === 1)
                <p>　投稿</p>
                @endif --}}
                    {{-- </br> --}}
                    <div>
                        <form action="{{ route('article.edit') }}" method="get">
                            @csrf

                            <input type="hidden" name="id" value="{{ $article->id }}">
                            <div class="center-btn">
                            <x-primary-button class="mt-4 mb-14" id="edit-article-button">
                                編集
                            </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('/highlight/package.json') }}"></script>
        <script>
        document.getElementById('edit-article-button').addEventListener('click', function(event) {
        // リンクのデフォルトの動作を防ぐ
        // event.preventDefault();
        // ローカルストレージをクリア
        localStorage.removeItem('title');
        localStorage.removeItem('content');
        localStorage.setItem('action', 'edit');

        // リンク先に遷移
        window.location.href = this.href;
        });
        </script>
    @endpush
</x-app-layout>
