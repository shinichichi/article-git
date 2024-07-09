<x-app-layout>
    @push(('styles'))
    <link rel="stylesheet" href="{{ asset('highlight/styles/base16/atelier-lakeside.css')}}">
    @vite(['resources/css/image.css', 'resources/css/sample.css'])
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($article['extension'] === null)
                    {{-- サムネ --}}
                    <img id="icon_img_prv" class="nospimgs img-thumbnail radius h-25 w-25 mb-10 mt-10 a"
                        src="{{ asset('image/articledfimage.jpg') }}" alt="">
                    @else
                    <img class="radius mb-10 mt-10 a" src="data:image/{{ $article['extension'] }};base64,{{ base64_encode($article['imagedata']) }}"
                        alt="サムネイル画像">
                    @endif
                    {{-- タイトル --}}
                    <p class="text-xl center-btn pb-12 tl mt-12 ml-14 mr-14 line">{{ session('article.title') }}</p>
                    {{-- <p>記事内容：</p> --}}
                    {{-- 記事内容 --}}
                    <pre class="center-btn pb-3 k tl mt-14 ml-14 mr-14">{!! $article['markdown_text'] !!}</pre>

                    <!-- article_type -->
                    {{-- <p>記事タイプ：</p>
                    @if ($article['article_type'] === '0')
                    <p>　記事</p>
                    @elseif ($article['article_type'] === '1')
                    <p>　Q&A</p>
                    @elseif ($article['article_type'] === '2')
                    <p>　意見交換</p>
                    @endif
                    </br> --}}

                    <!-- public_type -->
                    {{-- <p>公開設定：</p>
                    @if ($article['public_type'] === '0')
                    <p>　全体に公開</p>
                    @elseif ($article['public_type'] === '1')
                    <p>　限定公開</p>
                    @elseif ($article['public_type'] === '2')
                    <p>　公開停止</p>
                    @endif
                    </br> --}}

                    <!-- draft -->
                    {{-- <p>下書き設定：</p>
                    @if ($article['draft'] === '0')
                    <p>　下書き</p>
                    @elseif ($article['draft'] === '1')
                    <p>　投稿</p>
                    @endif
                    </br> --}}

                </div>
                <form action="{{ route('article.update') }}" method="POST">
                    @csrf
                    {{-- @method('patch') --}}
                    {{-- @if ($article['thumbnail'] !== null)
                    <input type="hidden" name="thumbnail" value="{{ $article['thumbnail'] }}">
                    @endif
                    @if($article['imagedata'] !== null)
                    <input type="hidden" name="imagedata" value="{{ $article['imagedata'] }}">
                    @endif --}}
                    <input type="hidden" name="not_image" value="{{ $article['not_image'] }}">
                    <input type="hidden" name="id" value="{{ $article['id'] }}">
                    <input type="hidden" name="title" value="{{ $article['title'] }}">
                    <input type="hidden" name="markdown_text" value="{{ $article['markdown_text'] }}">
                    <input type="hidden" name="article_type" value="{{ $article['article_type'] }}">
                    <input type="hidden" name="public_type" value="{{ $article['public_type'] }}">
                    <input type="hidden" name="draft" value="{{ $article['draft'] }}">
                    <div class="w-full flex flex-col">
                        <label for="comment" class="text-gray-500 font-semibold mt-4 mb-5 center-btn">コメント</label>
                        <input type="text" name="comment" id="comment" value="{{old('comment')}}">
                    </div>
                    <div class="fl mt-14">
                    <button class="bt text-xl radius mb-14"  onclick="history.back()">戻る</button>
                    <button class="bg-blue-400 hover:bg-blue-300 bt text-xl radius mb-14" id="dataForm" onclick="history.back()">作成</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('/highlight/package.json') }}"></script>
    <script>
        document.getElementById('dataForm').addEventListener('click', function(event) {
        // リンクのデフォルトの動作を防ぐ
        // event.preventDefault();
        // ローカルストレージをクリア
        localStorage.removeItem('title');
        localStorage.removeItem('content');

        // リンク先に遷移
        window.location.href = this.href;
        });
        </script>
    @endpush


</x-app-layout>