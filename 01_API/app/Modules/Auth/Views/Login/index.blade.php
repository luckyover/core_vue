@extends('layout')

@section('title', 'APIログイン | スパークル')

@section('css')
{!! Html::style('/css/auth/login.css') !!}
@stop

@section('js')
    <script>
        const urls = {
            login: '{{ route('login.store') }}'
        };
    </script>
    {!! Html::script('/js/auth/login.js') !!}
@stop

@section('content')
<div class="login-form">
    <div class="form">
        <h2 class="text-center">APIログイン</h2>
        <div class="form-group have-error">
            <input type="text" class="form-control" placeholder="ユーザID" id="username">
        </div>
        <div class="form-group have-error">
            <input type="password" class="form-control" placeholder="パスワード" id="password">
        </div>
        <div class="form-group text-center">
            <button type="button" class="btn btn-primary btn-block" id="btn-login" tabindex="3">ログイン</button>
        </div>
    </div>
</div>
@stop
