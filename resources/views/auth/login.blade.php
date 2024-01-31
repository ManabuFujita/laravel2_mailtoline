@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card my-4">
                <div class="card-header card-add-header">
                    {{ __('Login') }}
                </div>

                <div class="card-body card-add-body">
                    <p>Lineでログインしてください</p>
                    <a href="{{ route('login.line') }}">
                        <img src="{{ asset('img/sign_in_with_line.png') }}" alt="LineLogin">
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
