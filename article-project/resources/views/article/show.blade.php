<x-app-layout>
    @push(('styles'))
    {{-- preタグのスタイル --}}
    <link rel="stylesheet" href="{{ asset('highlight/styles/base16/atelier-lakeside.css')}}">
    @vite(['resources/css/image.css'])
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"> 
                    @if ($article['extension'] === null && $article['imagedata'] === null)
                    <img id="icon_img_prv" class="nospimgs img-thumbnail h-25 w-25 mb-3"
                        src="{{ asset('image/articledfimage.jpg') }}" alt="">
                    @elseif($article['extension'] !== null && $article['imagedata'] !== null)
                    <img src="data:image/{{ $article['extension'] }};base64,{{ base64_encode($article['imagedata']) }}"
                        alt="サムネイル画像">
                    @elseif($article['extension'] !== null && $article['imagedata'] === null)

                    @endif
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
        <form action="{{ route('article.edit') }}" method="get">
            @csrf
            {{-- @method('PATCH') --}}
            <input type="hidden" name="id" value="{{ $article->id }}">
            <button>編集する</button>
        </form>
    </div>

@push('scripts')
<script src="{{ asset('/highlight/package.json') }}" ></script>
@endpush
</x-app-layout>

