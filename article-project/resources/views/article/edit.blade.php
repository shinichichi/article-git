<x-app-layout>
    @push('styles')
    @vite(['resources/js/simplemde.js'])
    @vite(['resources/css/image.css'])
    @endpush
    <div class="max-w-7xl mx-auto px-6">
        @if(session('message'))
        <div class="text-red-600 font-bold">
            {{session('message')}}
        </div>
        @endif
        <form method="post" action="{{ route('article.edit.posted_preference') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            {{-- サムネ --}}
            <img id="thumbnail_img_prv" class="nospimgs img-thumbnail h-25 w-25 mb-3"
                src="{{ asset('image/articledfimage.jpg') }}" alt="">
            <div class="col-md-6">
                <input id="thumbnail" type="file" class="form-control mb-5" accept="image/*" name="thumbnail_image_path"
                    onchange="setImage">
            </div>
            <input name="id" type="hidden" value="{{ $article['id'] }}">
            {{-- タイトル --}}
            <div class="w-full flex flex-col">
                <label for="title" class="font-semibold mt-4">タイトル</label>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <input type="text" name="title" id="title" value="{{old('title', $article->title)}}">
            </div>
            {{-- 本分 --}}
            <div class="w-full flex flex-col">
                <label for="markdown-editor" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('markdown_text')" class="mt-2" />
                <textarea name="markdown_text" class="w-auto py-2 border border-gray-300 rounded-md"
                    id="markdown-editor" cols="30"
                    rows="5">{{old('markdown_text', $article['markdown_text'])}}</textarea>
                <div id="editor-content" data-content="{{old('markdown_text', $article['markdown_text'])}}"></div>
            </div>
            <div id="editor-content" data-content="{{ $article['markdown_text'] }}"></div>
            <!--ドロップダウン記事タイプ -->
            <input type="hidden" name="draft" value="0">
            {{-- <div class="form-group">
                <label for="tag-id">{{ __('記事タイプ') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="article_type">
                    @foreach (Config::get('tag.article_type') as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div> --}}
            <!-- /ドロップダウン -->

            <!--ドロップダウン公開設定 -->
            <div class="form-group">
                <label for="tag-id">{{ __('公開設定') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="public_type">
                    @foreach (Config::get('tag.public_type') as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <!-- /ドロップダウン -->

            <!--ドロップダウン下書き -->
            <input type="hidden" name="article_type" value="0">
            {{-- <div class="form-group">
                <label for="tag-id">{{ __('下書き') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="draft">
                    @foreach (Config::get('tag.draft') as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div> --}}
            <!-- /ドロップダウン -->
            <x-primary-button class="mt-4">
                送信する
            </x-primary-button>
        </form>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        // アイコン画像プレビュー処理
        // 画像が選択される度に、この中の処理が走る
        $('#thumbnail').on('change', function(ev) {
            // このFileReaderが画像を読み込む上で大切
            const reader = new FileReader();
            // ファイル名を取得
            const fileName = ev.target.files[0].name;
            // 画像が読み込まれた時の動作を記述
            reader.onload = function(ev) {
                $('#thumbnail_img_prv').attr('src', ev.target.result).css('width', '150px').css('height', '150px');
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
    
    @endpush
</x-app-layout>