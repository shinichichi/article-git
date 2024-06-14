<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('公開プロフィール') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('公開プロフィール変更') }}
                    </h2><br>

                    @if(session('message'))
	                    <div style="color: #006400;">
		                    {{ session('message') }}
	                    </div>
                    @endif

                    <form method="post" action="{{ route('open_profile_store') }}" class="p-6">
                        @csrf

                        <div>
                            <x-input-label for="user_name" :value="__('ユーザー名')" />
                            <x-text-input id="user_name" name="user_name" type="text" class="mt-1 block" value="{{$user->user_name != null ? $user->user_name : ''}}"/>
                        </div><br>

                        <div>
                            <x-input-label for="account_name" :value="__('アカウント名')" />
                            <x-text-input id="account_name" name="account_name" type="text" class="mt-1 block" value="{{$user->account_name != null ? $user->account_name : ''}}"/>
                        </div><br>

                        <div>
                            <x-input-label for="open_email" :value="__('公開用メールアドレス')" />
                            <x-text-input id="open_email" name="open_email" type="text" class="mt-1 block" value="{{$user->open_email != null ? $user->open_email : ''}}"/>
                        </div><br>

                        <div>
                            <x-input-label for="site_url" :value="__('サイトURL')" />
                            <x-text-input id="site_url" name="site_url" type="text" class="mt-1 block" value="{{$user->site_url != null ? $user->site_url : ''}}"/>
                        </div><br>

                        <div>{{ __('自己紹介') }}</div>
                            <textarea name="self_introduction" class="mt-1  block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="" cols="30" rows="10">{{$user->site_url != null ? $user->site_url : ''}}</textarea><br>

                        <x-secondary-button onClick="history.back()">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-4">
                            {{ __('変更') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
