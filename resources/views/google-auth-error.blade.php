@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

<div class="container document">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row">
                <h2>Googleアカウント追加時のエラー画面について</h2>
            </div>

            <div class="row">
                <p>Googleアカウントを追加する際に、以下のエラー画面が出ます。</p>
                <img src="{{ asset('img/google-auth-error1.png') }}" style="width: 80%;">
            </div>

            <div class="row">
                <p>これは、Googleの審査が完了していないためです。</p>
            </div>

            <div class="row">
                <p>アプリの性質上、システム的にユーザーのメールボックスを取得するため、Gmailの認可とGoogleの審査が必要になります。しかし、年間の維持費用を捻出できないため、審査を通過できません（泣）。</p>
                <p>そのため、審査の通っていないアプリを使用を承諾できる方のみ、ご利用ください。</p>
            </div>

            <div class="row">
                <p>上記の画面から進むには、以下の通りにしてください。</p>
                <p>・左下の「詳細」を押す（下の画像のようになる）。</p>
                <p>・下部の「mailtoline.com（安全ではないページ）に移動」を押す。</p>
                <img src="{{ asset('img/google-auth-error2.png') }}" style="width: 80%;">
            </div>

            <div class="row">
                <p>以降は通常のログイン動作で進められます。</p>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


</script>

<script type="module">


</script>

@endsection
