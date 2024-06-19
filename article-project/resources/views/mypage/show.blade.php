<style>
    /* デスクトップCSS */
    @media (max-width: 750px) {
        .desktop {
            display: none !important;
        }


    }

    /* 自動改行 */
    .lo {
        word-break: break-all;
    }

    /* 要素を左右に分ける */
    .sp {
        display: flex;
        justify-content: space-between;
    }

    /* 子要素のflexを伸ばす */
    .sp span:first-child {
        flex-grow: 1;
    }

    /*　自動改行しない */
    .sp span:nth-child(2) {
        white-space: nowrap;
    }

    a {
        display: block;
        transition: all .3s ease 0s;
        text-decoration: none;
    }

    .a:hover {
        cursor: pointer;
        transform: scale(1.05);
        text-decoration: none;
    }

    .as:hover {
        cursor: pointer;
        /* transform: scale(1.05); */
        text-decoration: none;
    }

    .box {
        display: flex;
        width: 250px;
        height: 270px;
        /* overflow-x: scroll; */
    }

    .box div {
        width: 90%;
        margin: 5px;
        flex-shrink: 0;
    }

    .scroll_content {
        /* リスト全体のスタイル */
        display: flex;
        max-width: 800px;
        margin: auto;
        overflow-x: auto;
    }

    .scroll_content li {
        /* 各リストのスタイル */
        width: 90%;
        padding: 8px;
        margin: 3px;
        flex-shrink: 0;
        list-style: none;
    }

    .scroll_content img {
        /* 画像のスタイル */
        width: 100%;
        max-height: 200px;
        object-fit: cover;
    }

    /* firefoxスクロールバー非表示 */
    .scroll_content {
        scrollbar-width: none;
    }

    /* chrome safariスクロールバー非表示 */
    .scroll_content::-webkit-scrollbar {
        height: 12px;
        display: none;
    }

    .scroll_content::-webkit-scrollbar-thumb {
        background: #aaa;
        /* ツマミの色 */
        border-radius: 6px;
        /* ツマミ両端の丸み */
    }

    .scroll_content::-webkit-scrollbar-track {
        background: #ddd;
        /* トラックの色 */
        border-radius: 6px;
        /* トラック両端の丸み */
    }

    /* スライド画像上だけ丸く */
    .spbrue {
        border-radius: 30px 30px 0px 0px;
    }

    .imagk400 {
        /* width: 360px;
                    height: 360px; */
        width: 100vw
    }

    .imagk300 {
        width: 300px;
        height: 300px;
    }

    .imagk200 {
        width: 200px;
        height: 200px;
    }

    .imagk150 {
        width: 150px;
        height: 150px;
    }

    .imagk100 {
        width: 100px;
        height: 100px;
    }

    @media screen and (min-width: 450px) {
        .scroll_content li {
            width: 30%;
        }
    }

    /* 表示文字数行数制限2行 */
    .tg {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .ex {
        line-height: 2;
    }

    .kasaneru {
        position: relative;
        /*親要素にrelative*/
    }

    .kasaneru p {
        position: absolute;
        /*重ねたい子要素にabsolute*/
        top: 95%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        /*ベンダープレフィックス*/
        -webkit-transform: translate(-50%, -50%);
        /*ベンダープレフィックス*/
        transform: translate(-50%, -50%);
        font-size: 0.9rem;
        text-shadow: 1px 1px 0 #FFF, -1px -1px 0 #FFF,
            -1px 1px 0 #FFF, 1px -1px 0 #FFF,
            0px 1px 0 #FFF, 0-1px 0 #FFF,
            -1px 0 0 #FFF, 1px 0 0 #FFF;
    }

    .onimg img {
        width: 100%;
    }

    .flex {
        display: flex;
        /*横並び*/
    }

    .wi {
        width: 100%;
    }

    .down {
        display: inline-block;
        margin: 15px 0 0 0;
    }

    .tu {
        /* vertical-align top: 10%; */
    }

    /* サムネ画像角丸 */
    .bora {
        border-radius: 20%;
    }

    .bora-20 {
        border-radius: 0 0 20% 20%;
    }

    .bora10 {
        border-radius: 10% 10% 0 0;
    }

    /* 記事角丸 */
    .bora1 {
        border-radius: 50%;
    }

    img {
        max-width: 100%;
    }

    /* スマホCSS */
    @media(min-width:751px) {
        .smartphone {
            display: none !important;
        }
    }

    .spbox {
        display: flex;
        width: 201px;
        margin-right: 30px;
        /* height: 270px; */
    }

    .spscroll_content {
        /* リスト全体のスタイル */
        display: flex;
        max-width: 500px;
        margin: auto;
        overflow-x: auto;
    }

    /*SP firefoxスクロールバー非表示 */
    .spscroll_content {
        scrollbar-width: none;
    }

    /*SP chrome safariスクロールバー非表示 */
    .spscroll_content::-webkit-scrollbar {
        height: 12px;
        display: none;
    }

    /* SP記事角丸 */
    .spbora1 {
        border-radius: 10%;
    }

    /* SP文字をはみ出させない */
    .spwb {
        word-break: break-all;
    }

    /* アイコン画像調整 */
    .spimgs {
        height: 40px;
        width: 40px;
        border-radius: 20%;
        /* padding-right: 10px; */
    }
</style>
<x-app-layout>
    @push('styles')
        <link rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
    @endpush
    {{-- デスクトップ画面 --}}
    {{-- <p>記事一覧</p>
            <a href="{{ route('mypage.comment_list') }}">コメント一覧</a></br>
            <a href="{{ route('mypage.good_list') }}">いいね一覧</a> --}}
    <div class="desktop">
        <p class="mt-10 text-center text-xl text-gray-500">{{ session('flash_message') }}</p>
        <div class="py-3 col-span-8 lg:grid-col-span-8 gap-3">
            <div class="container">
                {{-- <div class="row row-cols-auto"> --}}
                @for ($i = 0; $i < $count; $i++)
                    <div class="form-group">
                        <div class="form-inline">
                            <div class="col">
                                <div class="max-w-4xl mx-auto sm:px-20 lg:px-30 mb-1">
                                    <a class="a mt-2" href="{{ route('indexshow', $articles[$i]->id) }}">
                                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-10">
                                            <div class="flex">
                                                {{-- 記事にサムネがついていない場合 --}}
                                                @if ($articles[$i]->thumbnail == null)
                                                    <img class="bora imagk100"
                                                        src="{{ asset('image/articledfimage200.jpg') }}" alt="">
                                                @endif
                                                {{-- 記事にサムネイルがある場合 --}}
                                                @if ($articles[$i]->thumbnail != null)
                                                    <img class="bora imagk100"
                                                        src="{{ asset($articles[$i]->thumbnail) }}" alt="">
                                                @endif
                                                <div class="wi col- mx-3 my-2">
                                                    <!-- タイトル -->
                                                    <p class="lo text-xl text-gray-500 pt-2">{{ $articles[$i]->title }}
                                                    </p>

                                                    <div class="sp pt-2">
                                                        <span
                                                            class="text-xs text-right down">{{ $articles[$i]->updated_at }}</span><br>
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
        </div>
    </div>


    {{-- スマホ画面 --}}
    <div class="smartphone">
        <p class="mt-4 text-center text-xl text-gray-500">{{ session('flash_message') }}</p>
        <div class="py-3 col-span-8 lg:grid-col-span-8 gap-3">
            <div class="container">
                {{-- <div class="row row-cols-auto"> --}}
                @for ($i = 0; $i < $count; $i++)
                    <div class="form-group">
                        <div class="form-inline">
                            <div class="col pl-0 pr-0">
                                <div class="max-w-4xl mx-auto sm:px-20 lg:px-30 mb-1">
                                    <a class="a mt-2" href="{{ route('indexshow', $articles[$i]->id) }}">
                                        <div class="bg-white overflow-hidden shadow-sm bora10 sm:rounded-lg">
                                            <div class="">
                                                {{-- 記事にサムネがついていない場合 --}}
                                                @if ($articles[$i]->thumbnail == null)
                                                    <img class=" imagk400"
                                                        src="{{ asset('image/articledfimage200.jpg') }}"
                                                        alt="">
                                                @endif
                                                {{-- 記事にサムネイルがある場合 --}}
                                                @if ($articles[$i]->thumbnail != null)
                                                    <img class=" imagk400" src="{{ asset($articles[$i]->thumbnail) }}"
                                                        alt="">
                                                @endif
                                                <div class="wi col mx-1 my-2">
                                                    <!-- タイトル -->
                                                    <p class="lo text-xl text-gray-500 pt-2">{{ $articles[$i]->title }}
                                                    </p>
                                                    {{-- ユーザー名 更新日 --}}
                                                    <div class="sp pt-2">
                                                        <span
                                                            class="text-xs text-right down">{{ $articles[$i]->updated_at }}</span><br>
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
        </div>
    </div>
</x-app-layout>
