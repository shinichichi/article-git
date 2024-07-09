<x-app-layout>
    @push('styles')
    @vite(['resources/js/simplemde.js'])
    @vite(['resources/css/image.css', 'resources/css/sample.css'])
    <style>
    </style>
    @endpush
    <div class="max-w-7xl mx-auto px-6">
        @if (session('message'))
        <div class="text-red-600 font-bold">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="text-red-600 font-bold">
            <p>{{ session('error') }}</p>
        </div>
        @endif
        <form method="post" action="{{ route('article.edit.posted_preference') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            {{-- サムネ --}}
            <div id="thumbnail_container" style="position: relative; display: inline-block;">
                {{-- サムネなければ --}}
                {{-- @if ($article->extension === null || $article->imagedata === null)
                <img id="thumbnail_img_prv" class="nospimgs img-thumbnail h-25 w-25 mt-10"
                    src="{{ asset('image/articledfimage.jpg') }}" alt="">
                <button id="remove_thumbnail" class="btn btn-danger remove-btn" style="display: none;"
                    type="botton">×</button> --}}
                {{-- サムネあれば --}}
                {{-- @else --}}
                {{-- <img id="thumbnail_img_prv" class="nospimgs img-thumbnail h-25 w-25 mt-10"
                    src="data:image/{{ $article->extension }};base64,{{ base64_encode($article->imagedata) }}"
                    alt="サムネイル画像">
                <button id="remove_thumbnail" class="btn btn-danger remove-btn" style="display: none;"
                    type="botton">×</button> --}}
                {{-- @endif --}}
                @if($article->extension !== null && $article->imagedata !== null)
                <img id="thumbnail_img_prv" class="nospimgs img-thumbnail h-25 w-25 mt-10"
                    src="data:image/{{ $article->extension }};base64,{{ base64_encode($article->imagedata) }}"
                    alt="サムネイル画像">
                <input type="hidden" name="not_image" value="1" id="not_image">
                <button id="remove_thumbnail" class="btn btn-danger remove-btn" style="display: none;"
                    type="botton">×</button>
                @else
                <img id="thumbnail_img_prv" class="nospimgs img-thumbnail h-25 w-25 mt-10"
                    src="{{ asset('image/articledfimage.jpg') }}" alt="">
                <input type="hidden" name="not_image" value="0" id="not_image">
                <button id="remove_thumbnail" class="btn btn-danger remove-btn" style="display: none;"
                    type="botton">×</button>
                @endif
            </div>
            <div class="col-md-6">
                <input id="thumbnail" type="file" class="form-control mt-5 a" accept="image/*"
                    name="thumbnail_image_path">
            </div>
            <input name="id" type="hidden" value="{{ $article['id'] }}">
            {{-- タイトル --}}
            <div class="w-full flex flex-col">
                <label for="title" class="font-semibold mt-4">タイトル</label>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}">
            </div>
            {{-- 本分 --}}
            <div class="w-full flex flex-col">
                <label for="markdown-editor" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('markdown_text')" class="mt-2" />
                <textarea name="markdown_text" class="w-auto py-2 border border-gray-300 rounded-md"
                    id="markdown-editor" cols="30"
                    rows="5">{{ old('markdown_text', $article['markdown_text']) }}</textarea>
                <div id="editor-content" data-content="{{ old('markdown_text', $article['markdown_text']) }}"></div>
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
            <input type="hidden" name="public_type" value="0">
            {{-- <div class="form-group">
                <label for="tag-id">{{ __('公開設定') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="public_type">
                    @foreach (Config::get('tag.public_type') as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div> --}}
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
            <div class="center-btn">
                <x-primary-button class="mt-4">
                    次へ
                </x-primary-button>
            </div>
        </form>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    {{-- <script>
        // アイコン画像プレビュー処理
            // 画像が選択される度に、この中の処理が走る
            $('#thumbnail').on('change', function(ev) {
                // このFileReaderが画像を読み込む上で大切
                const reader = new FileReader();
                // ファイル名を取得
                const fileName = ev.target.files[0].name;
                // 画像が読み込まれた時の動作を記述
                reader.onload = function(ev) {
                    $('#thumbnail_img_prv').attr('src', ev.target.result).css('width', '150px').css('height',
                        '150px');
                }
                document.getElementById('not_image').value = 1;
                reader.readAsDataURL(this.files[0]);
            })
    </script> --}}
    {{-- <script>
        window.defaultThumbnail = "{{ asset('image/articledfimage.jpg') }}";
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                const thumbnailInput = document.getElementById('thumbnail');
                const thumbnailPreview = document.getElementById('thumbnail_img_prv');
                const removeButton = document.getElementById('remove_thumbnail');
                    // アイコン画像プレビュー処理
                    // 画像が選択されたときの処理
                    thumbnailInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            // このFileReaderが画像を読み込む上で大切
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                thumbnailPreview.src = e.target.result;
                                removeButton.style.display = 'block';
                            }
                            document.getElementById('not_image').value = 1;
                            reader.readAsDataURL(file);
                        }
                    });
                // 「×」ボタンが押されたときの処理
                removeButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    thumbnailPreview.src = '{{ asset('image/articledfimage.jpg') }}';
                    thumbnailInput.value = '';
                    // document.getElementById('not_image').value = 2;
                    document.getElementById('not_image').value = 0;
                    removeButton.style.display = 'none';
                });

                // 初期表示時に「×」ボタンを表示するかどうかの処理
                if (thumbnailPreview.src.includes('{{ asset('image/articledfimage.jpg') }}')) {
                    removeButton.style.display = 'none';
                } else {
                    removeButton.style.display = 'block';
                }
            });
    </script>
    {{-- @vite('resources/.js/thumbnail.js') --}}
    @endpush
</x-app-layout>