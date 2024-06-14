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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-xl">
            {{ __('お問い合わせ完了') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">

                        <div>
                            <x-input-label class="text-xl" :value="__('お問い合わせが完了しました')"/><br><br>
                        </div>

                        <div>
                            <p>お問い合わせありがとうございます。</p>
                            <p>2~3営業日以内に担当者よりご連絡致しますので、恐れ入りますが今しばらくお待ちください。</p><br>
                            <p>※2~3営業日以内に返信がない場合、ご入力いただいたメールアドレスが間違っているか、迷惑メールフォルダーに入っている場合がありますのでメールフォルダーをご確認ください。</p><br>
                        </div>
                        <div class="example">
                            <x-secondary-button onClick="history.back()">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
