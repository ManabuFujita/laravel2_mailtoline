@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

<div class="container document">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">

                    <div class="headline">
                        <img src="{{ asset('img/mail-icon.png') }}" alt="icon" style="width: 30px;">
                        メールをLINEに自動転送するアプリ
                    </div>
                </div>

                <div class="card-body">
                    <div class="container">

                        <div class="row">
                            <p>{{ config('app.name', 'Laravel') }}は、メールをLINEに自動転送するアプリです。</p>
                            <p>見落としがちなメール、すぐに反応しないといけないメールを、LINEでチェックできます。</p>
                            <p>（現在、Gmailのみに対応）</p>
                        </div>

                        <div class="row mt-4 pt-4 border-top">
                            <h4>特徴</h4>
                            <ul>
                                <li>無料で利用できます。</li>
                                <li>メールアドレスごとに転送フィルターを設定し、設定したフィルターに該当するメールをLINEに転送します</li>
                                <li>（※転送には5分ほどのタイムラグが発生します）</li>
                            </ul>
                        </div>

                        <div class="row mt-4 pt-4 border-top">
                            <h4>使い方</h4>
                            <ol>
                                <li>LINEアカウントでログインします。</li>
                                <li>Googleアカウントでログインし、転送フィルターを設定します。</li>
                                <li>メールが届いたらLINEに転送されます。</li>
                            </ol>
                            <p>以下のメールサービスに対応しています。</p>
                            <ul>
                                <li>Gmailのみ（今後、他のメールサービスに対応する予定です）</li>
                            </ul>
                        </div>

                        <div class="row mt-4 pt-4 border-top text-center">
                            <p>LINEアカウントでログインしてください</p>
                            <a href="{{ route('login.line') }}">
                                <img src="{{ asset('img/sign_in_with_line.png') }}" alt="LineLogin">
                            </a>
                        </div>


                    </div>



                </div>
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
