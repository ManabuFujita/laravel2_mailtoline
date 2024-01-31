@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

<div class="container document">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row">
                <h2>プライバシーポリシー</h2>
                <p>このプライバシーポリシー（以下、「本ポリシー」といいます。）は、このウェブサイト上で提供するサービス（以下、「本サービス」といいます。）の利用条件を定めるものです。登録ユーザーの皆さま（以下、「ユーザー」といいます。）には、本ポリシーに従って、本サービスをご利用いただきます。</p>
            </div>

            <div class="row">
                <h3>1. 取得するユーザー情報と目的</h3>
                <p>ユーザーのLINEアカウント情報を取得する必要があります。この情報は、ユーザーが本サービスにログインするため、また、ユーザーのLINEアカウントへのメールの転送のために使用されます。</p>
                <p>ユーザーのGmail等のメールアカウント情報が必要になります。これらの情報は、本サービスがユーザーのメールを取得するために使用されます。</p>
                <p>取得したデータは、利便性向上のため、匿名で個人を特定できない範囲で最新の注意を払い、アクセス解析のために使用されます。</p>
                <p>取得したデータは、その他の目的で使用されることはありません。</p>
            </div>

            <div class="row">
                <h3>2. 第三者提供</h3>
                <p>本サービスで取得したデータについて、ユーザーの同意なしに第三者へ提供することはありません。</p>
            </div>

            <div class="row">
                <h3>3. 免責事項</h3>
                <p>利用上の不具合・不都合に対して可能な限りサポートを行っておりますが、ユーザーが本サービスを利用して生じた損害に関して、開発元は責任を一切負わないものとします。</p>
            </div>
            
            <div class="row">
                <p class="text-right" style="text-align: right;">以上</p>
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
