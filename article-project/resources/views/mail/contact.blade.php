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

<p class="fj tj">名前：{{ $data['user_name'] }}さん</p><br>
<p>問い合わせ者のメールアドレス：{{ $data['email'] }}</p><br>
<p>メッセージ</p>
<p class="fj tj">{!! nl2br( $data['inquiry'] ) !!}</p><br>

<p>問い合わせが来ました返信してください。</p>
