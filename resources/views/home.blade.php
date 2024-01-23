@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if ($gmail_list->isEmpty())
            <div class="card my-4">
                <div class="card-header">はじめに</div>
                <div class="card-body">
                まずは、Gmailアカウントでログインしましょう！<br>
                <br>
                <a href="{{ route('login.google.redirect') }}">googleでログイン</a>
                </div>
            </div>
        @else
            @foreach ($gmail_list as $l)
                <div class="card my-4">
                    <div class="card-header">{{$l->email}}</div>

                    <div class="card-body">
                        <!-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif -->

                        <!-- <p>access token: {{$access_token}}</p>
                        <p>refresh token: {{$refresh_token}}</p>
                        <p>token expired: {{$token_expired}}</p> -->

                        <!-- ToDo:再認証チェック -->

                        <!-- 設定済みフィルター一覧 -->
                        <p>転送設定一覧</p>
                        @foreach ($filters as $f)
                            <div class="card my-4">
                                <div class="card-header">From（差出人）</div>

                                <div class="card-body">
                                {{$f->mail_from}}
                                </div>
                            </div>

                        @endforeach

                        <!-- <label for="filter-selector mb-3">選択してください</label>
                        <select id="filter-selector mb-3">
                            <option value="from" selected>From（差出人）</option>
                            <option value="title">Title（件名）</option>
                        </select> -->

                        <!-- <button class="btn btn-outline-secondary dropdown-toggle" id="filter-selector" type="button" data-bs-toggle="dropdown" aria-expanded="false">選択してください</button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item" id="from">From（差出人）</li>
                            <li class="dropdown-item" id="from">Title（件名）</li>
                        </ul> -->

                        <div class="input-group mb-3">
                            <!-- <label class="input-group-text" for="filter-selector">選択してください</label> -->
                            <select class="form-select" id="filter-selector">
                                <option value="default" selected>転送設定の追加（選択してください）</option>
                                <option value="from" @if ($errors->first('mail_from')!=null) selected @endif>・From（差出人）</option>
                                <option value="title" @if ($errors->first('title')!=null) selected @endif>・Title（件名）</option>
                            </select>
                        </div>

                        <!-- 差出人設定 -->
                        <div class="filter-form"
                        @if ($errors->first('mail_from')==null && $errors->first('title')==null)
                            style="display: none;" 
                            @endif
                        >
                        <div class="email-login-form-title align-middle">
                                    @if ($errors->first('mail_from')!=null)
                                    メールアドレス
                                    @endif
                                    @if ($errors->first('title')!=null)
                                    件名
                                        @endif
                                </div>

                        <form class="input-group mb-3 p-3 register-form align-middle" action="/mailfilter" method="post">




                            {{ csrf_field() }}


                            <div class="d-flex align-items-center p-2">


                                <div class="email-login-form-input">
                                    @if ($errors->first('mail_from')!=null)
                                    <input type="email" class="form-control" name="mail_from" placeholder="abc@xxx.com" aria-label="mail_from" value="{{old('mail_from')}}">
                                    @elseif ($errors->first('title')!=null)
                                    <input type="text" class="form-control" name="title" placeholder="件名" aria-label="title" value="{{old('title')}}">
                                    @else
                                    <input type="email" class="form-control" name="mail_from" placeholder="abc@xxx.com" aria-label="mail_from" value="{{old('mail_from')}}">
                                    @endif
                                    
                                </div>
                                <input type="hidden" name="email" value="{{$l->email}}">



                                <button class="btn btn-secondary" type="submit">追加</button>
                            </div>
                        </form>
                            @if ($errors->first('mail_from'))
                                <p class="validation">※{{$errors->first('mail_from')}}</p>
                            @endif
                            @if ($errors->first('title'))
                                <p class="validation">※{{$errors->first('title')}}</p>
                            @endif

                        </div>

                        {{$errors}}

                        <!-- 件名設定 -->
                        <!-- <form class="input-group mb-3 register-form-title" style="display: none;" action="/mailfilter" method="post">
                            {{ csrf_field() }}
                            <div class="email-login-form-title mb-3">件名</div>
                            <div class="email-login-form-input mb-3">
                                <input type="title" class="form-control" name="title" value="{{old('title')}}"></div>
                            <input type="hidden" name="email" value="{{$l->email}}"> -->

                            @if ($errors->first('title'))   <!-- ここ追加 -->
                                <!-- <p class="validation">※{{$errors->first('title')}}</p> -->
                            @endif

                            <!-- <button type="submit">追加</button>
                        </form> -->


                    </div>
                </div>
            @endforeach

            <a href="{{ route('login.google.redirect') }}">googleアカウントを追加</a>
        @endif

        </div>
    </div>
</div>

<script type="module">

    // $(function(){
    //     $('.register-form-title').hide();
    // });


    $("#filter-selector").change(function() {
		// value値を取得
		const str1 = $("#filter-selector").val();
        // $("#span4").text(str1);

        switch (str1) {
            case "from":
                // $('.register-form-title').animate({ height: 'hide' }, 'slow');
                // $('.register-form-from').animate({ height: 'show' }, 'slow');
                showSelectorFrom();
                break;

            case "title":
                // $('.register-form-from').animate({ height: 'hide' }, 'slow');
                // $('.register-form-title').animate({ height: 'show' }, 'slow');
                showSelectorTitle();
                break;

            default:
                $('.filter-form').animate({ height: 'hide' }, 'slow');
                break;
        }

	});

    function showSelectorFrom() {
        $('.filter-form').stop().animate({ height: 'hide' }, 'slow', 'swing', function(){

            $('.email-login-form-title').text("メールアドレス");

            $('.form-control').attr('type', "email");
            $('.form-control').attr('name', "mail_from");
            $('.form-control').attr('placeholder', "abc@xxx.com");

            $('.filter-form').animate({ height: 'show' }, 'slow', 'swing');
        });


    }

    function showSelectorTitle() {
        $('.filter-form').stop().animate({ height: 'hide' }, 'slow', 'swing', function(){

            $('.email-login-form-title').text("件名");

            $('.form-control').attr('type', "text");
            $('.form-control').attr('name', "title");
            $('.form-control').attr('placeholder', "件名");

            $('.filter-form').animate({ height: 'show' }, 'slow', 'swing');
        });
    }

</script>

@endsection
