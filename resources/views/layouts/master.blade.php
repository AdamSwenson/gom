<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('pageTitle')</title>
    <meta name="description" content="@yield('description')">
    <link href='{{secure_asset('inc/images/favicon.ico')}}' rel='icon' type='image/x-icon'/>

    @include('layouts.js_jquery_loader')
    @include('layouts.js_bootstrap_loader')
    @include('layouts.js_additional_libs')

</head>

<body>
    @include('navigation.nav_bar_main')
    <div id="container">
    @yield('body')
    @include('layouts.footer')
    <input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">
    </div>
<div id="scriptBox">
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('jsArea')
</div>
</body>
</html>