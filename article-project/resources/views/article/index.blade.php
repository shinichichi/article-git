<x-app-layout>
    @push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    @vite('resources/css/index.css')
    <style>
    </style>
    @endpush
    {{-- デスクトップ画面 --}}
    @if(session('success'))
    <div>
        <p>{{ session('success') }}</p>
    </div>
    @endif
    <div class="desktop">
        <div class="">
            <ul class="scroll_content">
                {{-- 5個まで表示 --}}
                @for ($i = 0; $i < 5; $i++) <li class="mt-1 spiw">
                    <div class="box">
                        <div>
                            <a class="as" href="{{ route('indexshow', $favorites[$i]->id) }}">
                                <div class="kasaneru">
                                    {{-- 記事にサムネがありイメージデータがある場合 --}}
                                    @if ($favorites[$i]->thumbnail !== null && $favorites[$i]->imagedata !== null)
                                    <img class="bora imagk200"
                                        src="data:image/{{ $articles[$i]['extension'] }};base64,{{ base64_encode($articles[$i]['imagedata']) }}"
                                        alt="サムネイル画像">
                                    {{-- 記事にサムネがありイメージデータがない場合 --}}
                                    @elseif ($favorites[$i]->thumbnail !== null && $favorites[$i]->imagedata === null)
                                    <img class="bora imagk200" src="{{ asset($favorites[$i]->thumbnail) }}" alt="">
                                    {{-- 記事にサムネが付いていない場合 --}}
                                    @else
                                    <img class="bora" src="{{ asset('image/articledfimage200.jpg') }}" alt="">
                                    @endif
                                    {{-- 日付 --}}
                                    <p>{{ $dates[$i] }}</p>
                                </div>
                                <!-- タイトル -->
                                <p class="lo text-xm text-gray-500 tg">{{ $favorites[$i]->title }}</p>
                            </a>
                        </div>
                    </div>
                    </li>
                    @endfor
            </ul>
        </div>

        <p class="mt-10 text-center text-xl text-gray-500">{{ session('flash_message') }}</p>
        <div class="py-3 col-span-8 lg:grid-col-span-8 gap-3">
            <div class="container" id="desktop_container">
                {{-- <div class="row row-cols-auto"> --}}
                    @for ($i = 0; $i < $count; $i++) <div class="form-group">
                        <div class="form-inline">
                            <div class="col">
                                <div class="max-w-4xl mx-auto sm:px-20 lg:px-30 mb-1">
                                    <a class="a mt-2" href="{{ route('indexshow', $articles[$i]->id) }}">
                                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-10">
                                            <div class="flex">
                                                {{-- 記事にサムネがありイメージデータがある時 --}}
                                                @if ($articles[$i]->thumbnail != null && $articles[$i]->imagedata !==
                                                null)
                                                <img class="bora imagk100"
                                                    src="data:image/{{ $articles[$i]['extension'] }};base64,{{ base64_encode($articles[$i]['imagedata']) }}"
                                                    alt="サムネイル画像">
                                                {{-- 記事にサムネがありイメージデータない時 --}}
                                                @elseif($articles[$i]->thumbnail != null && $articles[$i]->imagedata ===
                                                null)
                                                <img class="bora imagk100" src="{{ asset($articles[$i]->thumbnail) }}"
                                                    alt="">
                                                {{-- 記事にサムネがついていない場合 --}}
                                                @else
                                                <img class="bora imagk100"
                                                    src="{{ asset('image/articledfimage200.jpg') }}" alt="">
                                                @endif
                                                <div class="wi col- mx-3 my-2">
                                                    <!-- タイトル -->
                                                    <p class="lo text-xl text-gray-500 pt-2">{{ $articles[$i]->title }}
                                                    </p>
                                                    {{-- ユーザー名 更新日 --}}
                                                    <div class="sp pt-2">
                                                        <span class="lo text-xs text-gray-400">
                                                            <div class="flex">
                                                                {{-- 記事にユーザーが登録されていてユーザーアイコンが登録されている場合 --}}
                                                                @if($articles[$i]->user_id !== null &&
                                                                $articles[$i]->user->icon != null)
                                                                <img class="spimgs"
                                                                    src="{{ asset('image/'. $articles[$i]->user->icon) }}"
                                                                    alt="">
                                                                {{-- 名前 --}}
                                                                <div class="down pl-2">
                                                                    {{ $articles[$i]->user->user_name }}
                                                                    ({{ $articles[$i]->user->account_name }})
                                                                </div>
                                                                {{-- 記事にユーザーが登録さえていてユーザーアイコンが登録されていない場合 --}}
                                                                @elseif($articles[$i]->user_id !== null &&
                                                                $articles[$i]->user->icom === null)
                                                                <img class="" src="{{ asset('image/df40icon.jpg') }}"
                                                                    alt="">
                                                                {{-- 名前 --}}
                                                                <div class="down pl-2">
                                                                    {{ $articles[$i]->user->user_name }}
                                                                    ({{ $articles[$i]->user->account_name }})
                                                                </div>
                                                                {{-- 記事にユーザーが登録されていない場合 --}}
                                                                @elseif ($articles[$i]->user_id === null)
                                                                <img class="" src="{{ asset('image/df40icon.jpg') }}"
                                                                    alt="">
                                                                <div class="down pl-2">
                                                                    <p>名無し</p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </span>
                                                        <span class="text-xs text-right down">{{
                                                            $articles[$i]->updated_at }}</span><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
                @endfor
            </div>
            <div id="desktop-loading" style="display: none;">読み込み中...</div>
            <div id="desktop-load-more-trigger"></div>
        </div>
    </div>


    {{-- スマホ画面 --}}
    <div class="smartphone">
        <div class="">
            <ul class="spscroll_content pl-7">
                {{-- 5個まで表示 --}}
                @for ($i = 0; $i < 5; $i++) <li class="mt-3 spiw">
                    <div class="spbox">
                        <div>
                            <a class="as" href="{{ route('indexshow', $favorites[$i]->id) }}">
                                <div class="kasaneru bg-white spbrue">
                                    {{-- 記事にサムネがありイメージデータがある場合 --}}
                                    @if ($favorites[$i]->thumbnail !== null && $favorites[$i]->imagedata !== null)
                                    <img class="bora imagk200"
                                        src="data:image/{{ $articles[$i]['extension'] }};base64,{{ base64_encode($articles[$i]['imagedata']) }}"
                                        alt="サムネイル画像">
                                    {{-- 記事にサムネがありイメージデータがない場合 --}}
                                    @elseif ($favorites[$i]->thumbnail !== null && $favorites[$i]->imagedata === null)
                                    <img class="bora imagk200" src="{{ asset($favorites[$i]->thumbnail) }}" alt="">
                                    {{-- 記事にサムネが付いていない場合 --}}
                                    @else
                                    <img class="bora" src="{{ asset('image/articledfimage200.jpg') }}" alt="">
                                    @endif
                                    {{-- 日付 --}}
                                    <p>{{ $dates[$i] }}</p>
                                </div>
                                <!-- タイトル -->
                                <p class="lo text-xm bg-white text-gray-500 tg pt-2">{{ $favorites[$i]->title }}
                                </p>
                            </a>
                        </div>
                    </div>
                    </li>
                    @endfor
            </ul>
        </div>

        <p class="mt-4 text-center text-xl text-gray-500">{{ session('flash_message') }}</p>
        <div class="py-3 col-span-8 lg:grid-col-span-8 gap-3">
            <div class="container" id="smartphone_container">
                {{-- <div class="row row-cols-auto"> --}}
                    @for ($i = 0; $i < $count; $i++) <div class="form-group">
                        <div class="form-inline">
                            <div class="col pl-0 pr-0">
                                <div class="max-w-4xl mx-auto sm:px-20 lg:px-30 mb-1">
                                    <a class="a mt-2" href="{{ route('indexshow', $articles[$i]->id) }}"
                                        id="article-list">
                                        <div class="bg-white overflow-hidden shadow-sm bora10 sm:rounded-lg">
                                            <div class="">
                                                {{-- 記事にサムネがありイメージデータがあるとき --}}
                                                @if ($articles[$i]->thumbnail !== null && $articles[$i]->imagedata !==
                                                null)
                                                <img class="bora imagk400"
                                                    src="data:image/{{ $articles[$i]['extension'] }};base64,{{ base64_encode($articles[$i]['imagedata']) }}"
                                                    alt="サムネイル画像">
                                                {{-- 記事にサムネありイメージデータがない時 --}}
                                                @elseif ($articles[$i]->thumbnail !== null && $articles[$i]->imagedata
                                                === null)
                                                <img class=" imagk400" src="{{ asset($articles[$i]->thumbnail) }}"
                                                    alt="">
                                                {{-- 記事にサムネが付いてない場合 --}}
                                                @else
                                                <img class=" imagk400" src="{{ asset('image/articledfimage200.jpg') }}"
                                                    alt="">
                                                @endif
                                                <div class="wi col mx-1 my-2">
                                                    <!-- タイトル -->
                                                    <p class="lo text-xl text-gray-500 pt-2">{{ $articles[$i]->title }}
                                                    </p>
                                                    {{-- ユーザー名 更新日 --}}
                                                    <div class="sp pt-2">
                                                        <span class="lo text-xs text-gray-400">
                                                            <div class="flex">
                                                                {{-- 記事にユーザーが登録されていてユーザーアイコンが登録されている場合 --}}
                                                                @if ($articles[$i]->user_id !== null &&
                                                                $articles[$i]->user->icon != null)
                                                                <img class="spimgs"
                                                                    src="{{ asset('image/'. $articles[$i]->user->icon) }}"
                                                                    alt="">
                                                                <div class="down pl-2">
                                                                    {{ $articles[$i]->user->user_name }}
                                                                    ({{ $articles[$i]->user->account_name }})
                                                                </div>
                                                                {{-- 記事にユーザーが登録されていない場合 --}}
                                                                @elseif($articles[$i]->user_id !== null &&
                                                                $articles[$i]->user->icom === null)
                                                                <img class="" src="{{ asset('image/df40icon.jpg') }}"
                                                                    alt="">
                                                                <div class="down pl-2">
                                                                    {{ $articles[$i]->user->user_name }}
                                                                    ({{ $articles[$i]->user->account_name }})
                                                                </div>
                                                                {{-- 記事にユーザーが登録されていない場合 --}}
                                                                @elseif ($articles[$i]->user_id === null)
                                                                {{-- ユーザーアイコンが設定されていない場合デフォルト表示 --}}
                                                                <img class="" src="{{ asset('image/df40icon.jpg') }}"
                                                                    alt="">
                                                                <div class="down pl-2">
                                                                    <p>名無し</p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </span>
                                                        <span class="text-xs text-right down">{{
                                                            $articles[$i]->updated_at }}</span><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
                @endfor
            </div>
            <div id="smartphone-loading" style="display: none;">読み込み中...</div>
            <div id="smartphone-load-more-trigger"></div>
        </div>
    </div>
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/js/scroll.js')
    <script>
//         async function loadMoreArticles() {
//     const response = await fetch('/article/load-more?offset=5');
//     const data = await response.json();
    
//     console.log('Retrieved Articles:', data.articles);

//     if (data.articles) {
//         data.articles.forEach(article => {
//             // フロントエンドの処理
//             console.log('Article:', article);
//         });
//     } else {
//         console.error('No articles found');
//     }
// }

//     </script>
    @endpush
</x-app-layout>