<x-app-layout>
    @push('styles')
    @vite(['resources/js/simplemde.js'])
    @endpush
    <div class="max-w-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        <form method="post" action="{{ route('article.create.posted_preference') }}" >
            @csrf
            {{-- タイトル --}}
            <div class="w-full flex flex-col">
                <label for="title" class="font-semibold mt-4">タイトル</label>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <input type="text" name="title" id="title" value="{{ old('title') }}">
            </div>
            {{-- 本分 --}}
            <div class="w-full flex flex-col">
                <label for="markdown-editor" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('markdown_text')" class="mt-2" />
                <textarea name="markdown_text" class="w-auto py-2 border border-gray-300 rounded-md" id="markdown-editor" cols="30" rows="5">{{old('markdown_text')}}</textarea >
                <div id="editor-content" data-content="{{old('markdown_text')}}"></div>
            </div>
            <!--ドロップダウン -->
            <div class="form-group">
                <label for="tag-id">{{ __('記事タイプ') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="article_type">
                    @foreach (Config::get('tag.article_type') as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <!-- /ドロップダウン -->

            <!--ドロップダウン -->
            <div class="form-group">
                <label for="tag-id">{{ __('公開設定') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="public_type">
                    @foreach (Config::get('tag.public_type') as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <!-- /ドロップダウン -->

            <!--ドロップダウン -->
            <div class="form-group">
                <label for="tag-id">{{ __('下書き') }}<span class="badge badg-danger ml-2"></span></label>
                <select class="form-control" id="tag-id" name="draft">
                    @foreach (Config::get('tag.draft') as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <!-- /ドロップダウン -->
            <x-primary-button class="mt-4">
                送信する
            </x-primary-button>
        </form>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    @endpush
</x-app-layout>