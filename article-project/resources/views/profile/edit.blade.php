<style>
    /* アイコン画像調整 */
    .spimgs {
        height: 150px;
        width: 150px;
        border-radius: 20%;
        /* padding-right: 10px; */
    }

    /* アイコン画像調整 */
    .nospimgs {
        height: 150px;
        width: 150px;
        border-radius: 20%;
        /* padding-right: 10px; */
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('アイコン画像') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">アイコン画像を変更できます</p>
                        </header>

                        <form method="post" action="{{ route('iconchange') }}" class="mt-6 space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            {{-- アイコン画像プレビュー表示 --}}
                            <div class="text-center">
                                {{-- アイコンが設定されている場合表示 --}}
                                @if ($user->icon != null)
                                    <img id="icon_img_prv" class="bora spimgs img-thumbnail h-25 w-25 mb-3" src="{{ asset('image/'.$user->icon) }}" alt="">
                                @endif
                                {{-- アイコンが設定されいない場合デフォルト画像を表示 --}}
                                @if ($user->icon == null)
                                    <img id="icon_img_prv" class="nospimgs img-thumbnail h-25 w-25 mb-3" src="{{ asset('image/articledfimage.jpg') }}" alt="">
                                @endif
                            </div>
                            {{-- アイコン画像 --}}
                            <div class="row mb-3">
                                
                                <div class="col-md-6">
                                    <input id="icon" type="file" class="form-control mb-5" accept="image/*"
                                        name="icon_image_path" onchange="setImage">
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600">{{ __('変更') }}</p>
                                </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
{{-- <script src="{{ asset('js/image.js') }}" defer></script> --}}
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    // アイコン画像プレビュー処理
    // 画像が選択される度に、この中の処理が走る
    $('#icon').on('change', function(ev) {
        // このFileReaderが画像を読み込む上で大切
        const reader = new FileReader();
        // ファイル名を取得
        const fileName = ev.target.files[0].name;
        // 画像が読み込まれた時の動作を記述
        reader.onload = function(ev) {
            $('#icon_img_prv').attr('src', ev.target.result).css('width', '150px').css('height', '150px');
        }
        reader.readAsDataURL(this.files[0]);
    })
</script>
