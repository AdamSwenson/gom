<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>@yield('pageTitle')</title>

    <link href='inc/images/favicon.ico' rel='icon' type='image/x-icon'/>

    @yield('cssLinks')
    @include('layouts.js_jqueryCss')
</head>

<body>
@include('layouts.navbar')
<div id="container">
    @yield('body')

    @include('layouts.footer')
</div>
<div id="scriptBox">
    @include('layouts.js_jqueryJs')
    @include('layouts.js_scriptloader')
    @yield('jsArea')
</div>
</body>
</html>