<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-xl">
            {{ __('お問い合わせ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('公開プロフィール変更') }}
                    </h2><br> --}}

                    @if(session('message'))
	                    <div style="color: #006400;">
		                    {{ session('message') }}
	                    </div>
                    @endif

                    <form method="post" action="{{ route('forminputconf') }}" class="p-6">
                        @csrf

                        <div>
                            <x-input-label for="user_name" :value="__('お名前')"/>
                            <x-text-input id="user_name" name="user_name" type="text" class="mt-1 block text-xl" placeholder="必須" value="" required autofocus/>
                        <br>

                        <div>
                            <x-input-label for="email" :value="__('メールアドレス')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block text-xl" placeholder="半角必須" value="" required autofocus/>
                        </div><br>

                        <div>{{ __('お問い合わせ内容') }}</div>
                            <textarea name="inquiry" placeholder="必須" class="text-xl mt-1  block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="" cols="30" rows="10" required autofocus></textarea><br>

                        <x-secondary-button onClick="history.back()">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-4">
                            {{ __('次へ') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
