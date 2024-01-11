<!DOCTYPE html>
<html lang="ja">
 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>テスト</title>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
        <!-- <link rel="stylesheet" href="style.css"> -->

        <meta http-equiv="refresh" content="600">

        <script>


        </script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    </head>
    
    <body class="bg-light">
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-3">
                    <h4 class="text-white">About</h4>
                    <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-3">
                    <h4 class="text-white">Contact</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Follow on Twitter</a></li>
                        <li><a href="#" class="text-white">Like on Facebook</a></li>
                        <li><a href="#" class="text-white">Email me</a></li>
                    </ul>
                    </div>
                </div>
                </div>
            </div>
            <div id="header" class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg> -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <style>svg{fill:#eeeeee}</style>
                        <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                    </svg>
                    <strong>Home</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </div>
            </div>
        </header>


        <main role="main">



            <!-- <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">テスト</h1>
                    <p class="lead text-muted">テスト中</p>
                    <p>
                    <a href="#" class="btn btn-primary my-2">Main call to action</a>
                    <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                    </p>
                </div>
            </section> -->



            <div class="album py-5 bg-light">
            <div class="container">



            </div>
            </div>

        </main>

        <!-- <footer class="text-muted fixed-bottom bg-light">
            <div class="container">
                <p>&copy; Home</p>
            </div>
        </footer> -->

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


        <script>
            // グラフ用
            // 外部ファイルで使用する変数を設定
            window.Laravel = {};
            window.Laravel.weather = @json($weather_from_today);
        </script>
        <script src="{{ asset('js/chart.js') }}"></script>

        <script>
            var title = '';
            //アコーディオンをクリックした時の動作
            $('.title').on('click', function() {
                var findElm = $(this).next(".box");//直後のアコーディオンを行うエリアを取得し
                $(findElm).slideToggle();//アコーディオンの上下動作
                    
                //タイトル要素にクラス名closeがあれば消し、無ければ付ける
                if($(this).hasClass('close')){
                    $(this).removeClass('close');
                }else{
                    $(this).addClass('close');
                }

                // タイトル文字を消す
                if($(this).text() === '　') {
                    $(this).text(title);
                } else {
                    title = $(this).text();
                    $(this).text('　');
                }
            });

            //ページが読み込まれた際にopenクラスをつけ、openがついていたら開く動作※不必要なら下記全て削除
            $(window).on('load', function(){
                $('.box').hide(); // 初期状態を非表示に

                $('.accordion-area li:first-of-type section').addClass("open"); //accordion-areaのはじめのliにあるsectionにopenクラスを追加
                $(".open").each(function(index, element){ //openクラスを取得
                    var Title =$(element).children('.title'); //openクラスの子要素のtitleクラスを取得
                    $(Title).addClass('close');       //タイトルにクラス名closeを付与し
                    var Box =$(element).children('.box'); //openクラスの子要素boxクラスを取得
                    $(Box).slideDown(500);          //アコーディオンを開く
                });
            });

            // ループ処理
            // MINUTES = 0.2;
            const MINUTES_SWITCHBOT = 5; // minutes 本番用
            let flame_time_switchbot = MINUTES_SWITCHBOT * 60 * 1000; // [ms/frame]
            setInterval(function() {
                getSwitchbot();
            }, flame_time_switchbot);

            // 1時間雨予報
            const MINUTES_RAIN = 5; // minutes 本番用
            let flame_time_rain = MINUTES_RAIN * 60 * 1000; // [ms/frame]
            setInterval(function() {
                // getRain();
            }, flame_time_rain);


            // チャート
            const MINUTES_CHART = 10; // minutes 本番用
            let flame_time_chart = MINUTES_CHART * 60 * 1000; // [ms/frame]
            setInterval(function() {
                getWeatherChart();
            }, flame_time_chart);

            getRain();


            function getSwitchbot() {
                $.ajax({
                    // url: 'http://127.0.0.1:8000/test1/getTemp',
                    // url: 'https://xprkd134.site/laravel/public/test1/getTemp',
                    url: "{{ route('temperature') }}",
                    type: 'get',
                    dataType: 'JSON',
                    // data: {
                    //     "param": // Controllerに渡したい値
                    // }
                }).done(function (data) {
                    // console.log(data);
                    data.forEach(function(d) {
                        // 値を変更
                        $('.switchbot #' + d['id']).find('.temperature').text(d['temperature'] + ' ℃');
                        $('.switchbot #' + d['id']).find('.humidity').text(d['humidity'] + ' %');
                        // 色を変更
                        $('.switchbot #' + d['id']).find('.temperature').css('background-color', d['temperature_color']);
                        $('.switchbot #' + d['id']).find('.humidity').css('background-color', d['humidity_color']);

                        // $('.switchbot #' + d['id']).find('.humidity').css('background-color', 'blue');
                    });


                    // $('#table').append(data['view'])
                }).fail(function () {
                    console.log('ajaxの通信に失敗しました:' + arguments.callee.name);
                    console.log('jqXHR: ' + jqXHR.status); // HTTPステータス
                    console.log('textStatus: ' + textStatus); // タイムアウト、パースエラー
                    console.log('errorThrown: ' + errorThrown.message); // 例外情報
                    console.log('URL: ' + url);
                    alert("エラーが発生しました");
                });
            }

            function getRain() {
                console.log("{{ route('rain') }}");

                $.ajax({
                    // url: 'http://127.0.0.1:8000/test1/getTemp',
                    // url: 'https://xprkd134.site/laravel/public/test1/getTemp',
                    url: "{{ route('rain') }}",
                    type: 'get',
                    dataType: 'JSON',
                    // data: {
                    //     "param": // Controllerに渡したい値
                    // }
                }).done(function (data) {
                    console.log(data);
                    data.forEach(function(d, index) {

                        // テスト
                        $('.rain #' + index).find('.card-text').text('aa');
                        $('.rain #' + index).find('.text-center').text('11');
                        // 色を変更
                        $('.rain #' + index).find('.text-center').css('background-color', 'black');



                        // // 値を変更
                        // $('.rain #' + index).find('.card-text').text(d['time_mm']);
                        // $('.rain #' + index).find('.text-center').text(d['rainfall']);
                        // // 色を変更
                        // $('.rain #' + index).find('.text-center').css('background-color', d['rainfall_color']);
                    //     $('.switchbot #' + d['id']).find('.humidity').css('background-color', d['humidity_color']);

                    //     // $('.switchbot #' + d['id']).find('.humidity').css('background-color', 'blue');
                    });


                    // $('#table').append(data['view'])
                }).fail(function () {
                    ajaxFail(arguments.callee.name);
                });
            }


            function getWeatherChart() {
                console.log("{{ route('weatherChart') }}");

                $.ajax({
                    // url: 'http://127.0.0.1:8000/test1/getTemp',
                    // url: 'https://xprkd134.site/laravel/public/test1/getTemp',
                    url: "{{ route('weatherChart') }}",
                    type: 'get',
                    dataType: 'JSON',
                    // data: {
                    //     "param": // Controllerに渡したい値
                    // }
                }).done(function (data) {
                    data[5]['temp'] = 15;
                    console.log(data);
                    window.Laravel.weather = data;
                    $.getScript("{{ asset('js/chart.js') }}");
                    // data.forEach(function(d) {
                    //     // 値を変更
                    //     $('.rain #' + d['id']).find('.temperature').text(d['temperature'] + ' ℃');
                    //     $('.switchbot #' + d['id']).find('.humidity').text(d['humidity'] + ' %');
                    //     // 色を変更
                    //     $('.switchbot #' + d['id']).find('.temperature').css('background-color', d['temperature_color']);
                    //     $('.switchbot #' + d['id']).find('.humidity').css('background-color', d['humidity_color']);

                    //     // $('.switchbot #' + d['id']).find('.humidity').css('background-color', 'blue');
                    // });


                    // $('#table').append(data['view'])
                }).fail(function () {
                    console.log('ajaxの通信に失敗しました:' + arguments.callee.name);
                    console.log('jqXHR: ' + jqXHR.status); // HTTPステータス
                    console.log('textStatus: ' + textStatus); // タイムアウト、パースエラー
                    console.log('errorThrown: ' + errorThrown.message); // 例外情報
                    console.log('URL: ' + url);
                    alert("エラーが発生しました");
                });
            }
            function ajaxFail(functionName) {
                console.log('ajaxの通信に失敗しました:' + functionName);
                console.log('jqXHR: ' + jqXHR.status); // HTTPステータス
                console.log('textStatus: ' + textStatus); // タイムアウト、パースエラー
                console.log('errorThrown: ' + errorThrown.message); // 例外情報
                console.log('URL: ' + url);
                alert("エラーが発生しました");                
            }



        </script>


    </body>
 
</html>