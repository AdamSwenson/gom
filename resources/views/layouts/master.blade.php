<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('pageTitle')</title>

    <link href='inc/images/favicon.ico' rel='icon' type='image/x-icon'/>

    <!--here is where bootstrap UI is linked -->
    <link href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    @yield('cssLinks')
     @include('layouts.js_jqueryCss')
</head>

<body>
<!--include('layouts.navbar')-->

<div id="container">
    @yield('body')

   @include('layouts.footer')
    <input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">
</div>
<div id="scriptBox">
    @include('layouts.js_jqueryJs')
    @include('layouts.js_scriptloader')
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