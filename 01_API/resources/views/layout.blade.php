<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-key" content="{{ explode(',', config('app.api_key'))[0] }}">
    <link href="/favicon.ico" rel="shortcut icon">
    {!! Html::style('/css/common/bootstrap.min.css') !!}
    {!! Html::style('/css/common/bootstrap-datetimepicker.min.css') !!}
    {!! Html::style('/css/common/jquery-colorbox.min.css') !!}
    {!! Html::style('/css/common/fontawesome.min.css') !!}
    {!! Html::style('/css/common/select2.min.css') !!}
    {!! Html::style('/css/common/common.css') !!}
    @yield('css')
</head>
<body class="ans-body">
    @yield('content')
    <div class="modal fade modal-message" id="ansMessage" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content">
                        <h5 class="text-center message-title"></h5>
                        <p class="text-center message-content"></p>
                    </div>
                    <div class="modal-footer flex-nowrap justify-content-center">
                        <button type="button" class="text-center btn-action btn-ok"></button>
                        <button type="button" class="text-center btn-action btn-cancel"></button>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="loading hide" id="ansLoading">
        <div class="loading-bg"></div>
        <img src="/img/loading.gif" alt="Loading..." />
    </div>
    {!! Html::script('/js/common/jquery.min.js') !!}
    {!! Html::script('/js/common/bootstrap.min.js') !!}
    {!! Html::script('/js/common/moment.min.js') !!}
    {!! Html::script('/js/common/bootstrap-datetimepicker.min.js') !!}
    {!! Html::script('/js/common/jquery-colorbox.min.js') !!}
    {!! Html::script('/js/common/js.cookie.min.js') !!}
    {!! Html::script('/js/common/axios.min.js') !!}
    {!! Html::script('/js/common/select2.min.js') !!}
    {!! Html::script('/js/common/lodash.min.js') !!}
    {!! Html::script('/js/common/messages.js') !!}
    {!! Html::script('/js/common/common.js') !!}
    {!! Html::script('/js/common/validate.js') !!}
    {!! Html::script('/js/common/ansAxios.js') !!}
    @yield('js')
</body>
</html>
