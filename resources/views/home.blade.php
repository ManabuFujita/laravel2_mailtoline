@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                        <p>line id: {{$line_id}}</p>
                        <p>gmail: {{$gmail_address}}</p>
                        <p>access token: {{$access_token}}</p>
                        <p>refresh token: {{$refresh_token}}</p>
                        <p>token expired: {{$token_expired}}</p>

                    {{ __('You are logged in!') }}
                    <a href="{{ route('login.google.redirect') }}">googleでログイン</a>
                </div>
            </div>
        </div>
    </div>
</div>
aaa

<script src="https://apis.google.com/js/platform.js" async defer></script>

<meta name="google-signin-client_id" content="299041316552-8lv9u0ngcq7jn26btn6nhdcepnu3lcu8.apps.googleusercontent.com">

<div class="g-signin2" data-onsuccess="onSignIn"></div>



<script>
        function onSignIn(googleUser) {
            console.log('onSignIn.');
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.disconnect();

            // Get ID Token
            var id_token = googleUser.getAuthResponse().id_token;

            // Send ID Token to Backend
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:8080/signin');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if(xhr.readyState == 4 && xhr.status == 200){
                    // Redirect
                    window.location.href = 'http://localhost:8080/userinfo';
                }else{
                    console.log('Error');
                }
            };
            xhr.send('credential=' + id_token);
        }
    </script>
<!--  -->

<script src="https://accounts.google.com/gsi/client" async defer></script>

<div id="g_id_onload"
     data-client_id="299041316552-8lv9u0ngcq7jn26btn6nhdcepnu3lcu8.apps.googleusercontent.com"
     data-context="signin"
     data-ux_mode="popup"
     data-login_uri="http://127.0.0.1:8000/login/google/callback"
     data-prompt_parent_id='g_id_onload'
  style='position: fixed; top: 76px; right: 16px;'
     data-auto_select="true"
     data-itp_support="true">
</div>

<div class="g_id_signin"
     data-type="standard"
     data-shape="rectangular"
     data-theme="outline"
     data-text="signin_with"
     data-size="large"
     data-logo_alignment="left">
</div>

bbb

@endsection
