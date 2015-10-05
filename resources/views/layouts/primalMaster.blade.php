<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('pageTitle')</title>
    <meta name="description" content="@yield('description')">
    <link href='inc/images/favicon.ico' rel='icon' type='image/x-icon'/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    @yield('cssLinks')
</head>

<body>
<!-- no longer have NavBar, so this may produce side effects -->
@yield('NavBar')
<div id="container">
    @include('flash::message')
    @include('errors.list')
    @yield('body')
    @include('layouts.footer')
    <input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">
</div>

<div id="scriptBox">
    @include('layouts.js_jquery_loader')
    @include('layouts.js_bootstrap_loader')
    @include('layouts.js_scriptloader')

    <script type="text/javascript" src="<?php echo asset("inc/js/bootbox.min.js");?>"></script>
    <!-- bootbox for easy modals -->
    <script type="text/javascript" src="<?php echo asset("inc/js/bootbox.min.js");?>"></script>
    <!--  rubaXA Sortable for drag and drop -->
    <script src="http://rubaxa.github.io/Sortable/Sortable.js"></script>

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