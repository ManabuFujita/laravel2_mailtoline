@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if (($lineFriendFlag == false) 
            || ($gmailList->isEmpty()))

            <!-- 初期設定 -->
            <div class="card my-4">
                <div class="card-header">はじめに</div>
                <div class="card-body container">

                    @if ($lineFriendFlag == false)
                    <div class="row">
                        <span>まずは、LINEの友達登録をしましょう！</span>
                        <span>↓このLINEアカウントに転送メールが届くようになります。</span>
                        <div class="py-2">
                            <div class="line-it-button" data-lang="ja" data-type="friend" data-env="REAL" data-count="false"  data-lineId="{{ config('services.line.talk_channel_id') }}" style="display: none;"></div>
                            <script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
                        </div>
                    </div>
                    @else

                    @if ($gmailList->isEmpty())
                    <div class="row py-2">
                        <span>次に、転送設定をしたいGmailアカウントでログインしましょう！</span>
                        <span>（現在、Gmailしか対応しておりません）</span>
                    </div>
                    <div class="row py-2">
                        <span style="color: red;">※途中でエラー画面が表示されるため、以下をお読みください。</span>
                        <a class="" href="{{ route('page.view', ['page' => 'google-auth-error']) }}">Googleアカウント追加時のエラー</a>
                    </div>
                    <div class="row py-2">
                        <a href="{{ route('login.google.redirect') }}">
                            <img src="{{ asset('img/sign_in_with_google.png') }}" alt="GoogleLogin">
                        </a>
                    </div>
                    @endif

                    @endif



                </div>
            </div>
        @endif



        @if ($gmailList->isEmpty())
            <!-- <div class="card my-4">
                <div class="card-header">はじめに</div>
                <div class="card-body">
                    まずは、転送設定をしたいGmailアカウントでログインしましょう！<br>
                    <br>
                    <a href="{{ route('login.google.redirect') }}">
                        <img src="{{ asset('img/sign_in_with_google.png') }}" alt="GoogleLogin">
                    </a>
                </div>
            </div> -->
        @else
            @php
                $today = new DatetimeImmutable();
                $oneMonthAgo = new DatetimeImmutable();
                $oneMonthAgo = $oneMonthAgo->add(DateInterval::createFromDateString('-30 days'));
            @endphp


            @foreach ($gmailList as $list)
                <div class="card card-mail-list border my-4" id="{{$list->email}}">
                    <div class="card-header">{{$list->email}}</div>

                    <div class="card-body">
                        <!-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif -->

                        <!-- ToDo:再認証チェック -->

                        <!-- 設定済みフィルター一覧 -->

                        @if (isset($filterList[$list->email]))
                        <!-- <p>転送設定一覧</p> -->
                        @foreach ($filterList[$list->email] as $f)
                        <div class="mx-4 mail-list-form">
                            <form class="align-middle" id="test" action="./mailfilter/delete" method="post" onsubmit="return checkDelete()">
                                @csrf
                                <div class="card card-filter border my-4">
                                    <div class="container card-header">
                                        <div class="row">
                                            <div class="col">転送フィルター {{$loop->index + 1}}</div>

                                            <!-- 削除ボタン -->
                                            <button class="btn delete-button" type="submit" name="test">
                                                <img src="{{ asset('img/trush.png') }}" alt="GoogleLogin" width="20px" height="20px">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <ul class="list-group list-group-horizontal-sm my-2">
                                            <li class="list-group-item filter-col-key col-sm-3">From</li>
                                            <li class="list-group-item filter-col-value col">{{$f->mail_from}}</li>
                                        </ul>
                                        <ul class="list-group list-group-horizontal-sm my-2">
                                            <li class="list-group-item filter-col-key col-sm-3">Subject</li>
                                            <li class="list-group-item filter-col-value col">{{$f->subject}}</li>
                                        </ul>
                                    </div>

                                </div>
                                <input type="hidden" name="mail_from" aria-label="mail_from" value="{{$f->mail_from}}">
                                <input type="hidden" name="subject" aria-label="subject" value="{{$f->subject}}">
                                <input type="hidden" name="email" aria-label="email" value="{{$list->email}}">
                            </form>
                        </div>
                        @endforeach
                        @else
                        <p>転送フィルターを追加しましょう！</p>
                        @endif




                        <!-- @php
                        echo '<pre>';
                            print_r($errors);
                        echo '</pre>';
                        @endphp -->


                        <!-- トークン更新 -->
                        <!-- @if ($token_expired)
                        <p>トークンを更新してください</p>
                        @else
                        <p>トークンOK {{$token_expired}}</p>
                        @endif -->


                        <!-- フィルター設定 -->
                        <div class="mx-4 add-filter card-add">
                            <form class="register-form align-middle" action="./mailfilter" method="post">
                                @csrf

                                <div class="card card-filter border my-4">
                                    @if (($list->email == old('email'))&&(session('mail_from') || session('subject') || $errors->first('mail_from')!=null || $errors->first('subject')!=null))
                                    <div class="filter card-header card-add-header rounded-top is-active">
                                        <!-- <div class="filter-top"> -->
                                            <div class="plus-button"></div>
                                            転送フィルター追加
                                        <!-- </div> -->
                                    </div>
                                    <div class="card-body card-add-body border">
                                    @else
                                    <div class="filter card-header card-add-header rounded-top">
                                        <!-- <div class="filter-top"> -->
                                            <div class="plus-button"></div>
                                            転送フィルター追加
                                        <!-- </div> -->
                                    </div>
                                    <div class="card-body card-add-body" style="display: none;" >
                                    @endif
                                    
                                    <!-- <div class="email-login-form-title mb-3 align-middle">
                                    </div> -->

                                    <div class="container">

                                        <!-- 宛先（固定） -->
                                        <div class="row input-group my-2">
                                            <span class="input-group-text col-sm-3 filter-col-key">To</span>
                                            <input type="text" class="form-control" name="mail_to" placeholder="{{$list->email}}" aria-label="mail_to" value="{{$list->email}}" disabled>
                                        </div>


                                        <!-- 差出人 -->
                                        <div class="row input-group my-2">
                                            <span class="input-group-text col-sm-3 filter-col-key">From</span>
                                            @if ($list->email == old('email'))
                                            <input type="email" class="form-control" name="mail_from" placeholder="abc@xxx.com" aria-label="mail_from" value="{{old('mail_from')}}">
                                            @else
                                            <input type="email" class="form-control" name="mail_from" placeholder="abc@xxx.com" aria-label="mail_from">
                                            @endif
                                        </div>
                                        <!-- エラーメッセージ -->
                                        @if ($errors->first('mail_from'))
                                        <div class="row error-message text-danger">
                                            <p class="validation">※{{$errors->first('mail_from')}}</p>
                                        </div>
                                        @endif



                                        <!-- 件名 -->
                                        <div class="row input-group my-2">
                                            <span class="input-group-text col-sm-3 filter-col-key">Subject</span>
                                            @if ($list->email == old('email'))
                                            <input type="text" class="form-control" name="subject" placeholder="件名" aria-label="subject" value="{{old('subject')}}">
                                            @else
                                            <input type="text" class="form-control" name="subject" placeholder="件名" aria-label="subject">
                                            @endif
                                        </div>
                                            <!-- エラーメッセージ -->
                                        @if ($errors->first('subject'))
                                        <div class="row error-message text-danger">
                                            <p class="validation">※{{$errors->first('subject')}}</p>
                                        </div>
                                        @endif
                                        <!-- 重複エラー -->
                                        @if (session('error')=='register_duplicate')
                                        <div class="row error-message text-danger">
                                            <p class="validation">※既に登録されているため、登録できません。</p>
                                        </div>
                                        @endif

                                        <div class="row">
                                            <input type="hidden" name="email" aria-label="email" value="{{$list->email}}">
                                        </div>

                                        <!-- 送信ボタン -->
                                        <div class="row container px-0 mt-3 pt-4 border-top">
                                            <div class="col-2 col-button">
                                                <button class="btn btn-secondary rounded-2" type="submit" name="test">① 確認</button>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <span>上記のフィルター設定でメールを正しく抽出できるか確認できます</span>
                                                    <span>（抽出結果が多くなりすぎないよう、抽出期間を指定して確認ボタンを押してください）</span>
                                                </div>

                                                <div class="container mt-3">
                                                    <div class="row input-group input-group-sm mb-3">
                                                        <div class="col px-0">
                                                            <label class="input-group-text test-term" for="start">抽出期間（確認用）</label>
                                                        </div>                                                        
                                                        <div class="col px-0">
                                                            <input type="date" id="start" class="form-control" name="term_start" value="{{ old('term_start', $oneMonthAgo->format('Y-m-d')) }}" max="{{$today->format('Y-m-d')}}" /> 
                                                        </div>                                                        
                                                        <div class="col px-0" style="max-width: 40px;">
                                                            <label class="input-group-text test-term" for="end">～</label>
                                                        </div>
                                                        <div class="col px-0">
                                                            <input type="date" id="end" class="form-control" name="term_end" value="{{ old('term_end', $today->format('Y-m-d')) }}" max="{{$today->format('Y-m-d')}}" /> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row container px-0 mt-2 pt-4 border-top">
                                            <div class="col-2 col-button">
                                                <button class="btn btn-secondary rounded-2" type="submit" name="register">② 登録</button>
                                            </div>

                                            <div class="col">
                                                <span>「確認」して問題なければ登録してください</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>

                    

                            <!-- テスト結果 -->
                            @if (session('filterTest') && session('filterTestUser') == $list->email)
                            <div class="container test-result mt-2">
                                <span style="font-weight: bold;">抽出結果（{{session('filterTestListCount')}}件）</span>
                                @if (session('filterTestListCount') == 0)
                                    <p class="text-danger">※抽出結果がありません。設定を変更して再度お試しください。</p>
                                @elseif (session('filterTestListCount') <= 50)
                                    @foreach(session('filterTestList') as $r)
                                        <div class="card m-4">
                                            <div class="card-header"><p>{{$r['date']}}</p></div>

                                            <div class="card-body">
                                                <p>To: {{$r['to']}}</p>
                                                <p>From: {{$r['from']}}</p>
                                                <p>Subject: {{$r['subject']}}</p>
                                            </div>
                                        </div>      
                                    @endforeach
                                @else
                                    <p class="text-danger">※抽出結果が多すぎます。50件以下となるように再度設定してテストしてください。</p>
                                @endif
                            </div>
                            @endif
                        
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach



            <!-- 新規メールアドレス追加 -->
            <div class="card add-email card-add card-mail-list my-4">
                <div class="card-header card-add-header">
                    <div class="plus-button"></div>
                    メールアドレス追加
                </div>

                <div class="card-body card-add-body" style="display: none;">
                    <p>他のメールアドレス宛の転送フィルターを追加できます。</p>
                    <p>（現在、Gmailしか対応しておりません）</p>

                    <div class="row py-3">
                        <span style="color: red;">※途中でエラー画面が表示されるため、以下をお読みください。</span>
                        <a class="" href="{{ route('page.view', ['page' => 'google-auth-error']) }}">Googleアカウント追加時のエラー</a>
                    </div>


                    <a href="{{ route('login.google.redirect') }}">
                        <img src="{{ asset('img/sign_in_with_google.png') }}" alt="GoogleLogin">
                    </a>
                </div>
            </div>

        @endif

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // const Swal = require('sweetalert2');

    // Swal.fire({
    //         title: "削除してよろしいですか？",
    //         showDenyButton: true,
    //         // showCancelButton: true,
    //         confirmButtonText: "はい",
    //         denyButtonText: "いいえ"
    //     }).then((result) => {
    //         /* Read more about isConfirmed, isDenied below */
    //         if (result.isConfirmed) {
    //             Swal.fire("Saved!", "", "success");
    //             return true;
    //         } else if (result.isDenied) {
    //             Swal.fire("Changes are not saved", "", "info");
    //             return false;
    //         }
    //     });



    // 削除ボタン押下時の確認
    function checkDelete() {
        if(window.confirm('削除しますか？')){ 
            return true; 
        }else{
            alert('キャンセルされました'); 
            return false; 
        }


        // Swal.fire({
        //     title: "削除してよろしいですか？",
        //     showDenyButton: true,
        //     // showCancelButton: true,
        //     confirmButtonText: "はい",
        //     denyButtonText: "いいえ"
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //         Swal.fire("Saved!", "", "success");
        //         return true;
        //     } else if (result.isDenied) {
        //         Swal.fire("Changes are not saved", "", "info");
        //         return false;
        //     }
        // });

    }
</script>

<script type="module">

    $(".card-add-header").click(function() {
        $(this).next('.card-add-body').toggle('slow');
        $(this).toggleClass("is-active");
    });

    // 削除ボタン押下時の確認
    // function checkDelete() {
    //     if(window.confirm('削除しますか？')){ 
    //         return true; 
    //     }else{
    //         alert('キャンセルされました'); 
    //         return false; 
    //     }
    // }

    // document.getElementById('test').addEventListener('submit', function() {
    //     if(window.confirm('2削除しますか？')){ 
    //         return true; 
    //     }else{
    //         alert('2キャンセルされました'); 
    //         return false; 
    //     }
    // });

</script>

@endsection
