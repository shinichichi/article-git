<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('highlight/styles/base16/atelier-lakeside.css') }}">
        @vite(['resources/css/image.css', 'resources/css/sample.css'])
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- サムネ画像 --}}
                    @if ($article['extension'] === null)
                        <img id="icon_img_prv" class="nospimgs img-thumbnail h-25 w-25 mb-10 mt-10 a"
                            src="{{ asset('image/articledfimage.jpg') }}" alt="">
                    @else
                        <img class=" h-25 w-25 mb-10 mt-10 a radius "
                            src="data:image/{{ $article['extension'] }};base64,{{ base64_encode($article['imagedata']) }}"
                            alt="サムネイル画像">
                    @endif
                    {{-- タイトル --}}
                    {{-- <p class="center-btn text-xl pb-3">タイトル</p> --}}
                    <p class="text-xl center-btn pb-12 tl mt-12 ml-14 mr-14 line">{{ $article['title'] }}</p>
                    {{-- 記事内容 --}}
                    {{-- <p class="center-btn text-xl pb-4">記事内容</p> --}}
                    <div class="">
                        <pre class="center-btn pb-3 k tl mt-14 ml-14 mr-14">{!! $article['markdown_text'] !!}</pre>
                    </div>
                    </br>

                    <!-- article_type -->
                    {{-- <p>記事タイプ：</p>
                    @if ($article['article_type'] === '0')
                        <p>　記事</p>
                    @elseif ($article['article_type'] === '1')
                        <p>　Q&A</p>
                    @elseif ($article['article_type'] === '2')
                        <p>　意見交換</p>
                    @endif --}}
                    </br>

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
                <form action="{{ route('article.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="title" value="{{ $article['title'] }}">
                    <input type="hidden" name="markdown_text" value="{{ $article['markdown_text'] }}">
                    <input type="hidden" name="article_type" value="{{ $article['article_type'] }}">
                    <input type="hidden" name="public_type" value="{{ $article['public_type'] }}">
                    <input type="hidden" name="draft" value="{{ $article['draft'] }}">
                    <button>投稿</button>    
                </form>
                {{-- <a href="{{ route('article.store') }}">投稿する</a> --}}

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('/highlight/package.json') }}"></script>
        <script>
            
        </script>
    @endpush



</x-app-layout>
