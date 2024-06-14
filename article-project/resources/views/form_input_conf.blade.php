<style>
    .example {
        text-align: center;
        Justify-content: Flex-start;
    }

    .fj {
        word-break: break-all;
    }

    .tj {
        white-space: pre-wrap;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-xl text-gray-800 leading-tight">
            {{ __('お問い合わせ確認') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">

                    @if(session('message'))
	                    <div style="color: #006400;">
		                    {{ session('message') }}
	                    </div>
                    @endif

                    <form method="post" action="{{ route('forminputcomp') }}" class="p-6">
                        @csrf

                        <div>
                            <x-input-label class="text-xl" for="user_name" :value="__('お名前')"/>
                            <x-text-input id="user_name" name="user_name" type="hidden" class="text-xlmt-1 block" value="{{ $item['user_name'] }}"/>
                        </div>
                        <div class="text-xl fj tj">{{ $item['user_name'] }}</div><br>

                        <div>
                            <x-input-label class="text-xl" for="email" :value="__('メールアドレス')"/>
                            <x-text-input id="email" name="email" type="hidden" class="mt-1 block" value="{{ $item['email'] }}"/>
                        </div>
                        <div class="text-xl">{{ $item['email'] }}</div><br>

                        <x-input-label class="text-xl" for="email" :value="__('お問い合わせ')"/>
                        <x-text-input class="text-xl" type="hidden" name="inquiry" class="mt-1  block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="" cols="30" rows="10" value="{{ $item['inquiry'] }}"/>
                        <div class="text-xl fj tj">{{ $item['inquiry'] }}</div><br>

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
