<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('pageTitle')</title>
    <meta name="description" content="@yield('description')">
    <link href='inc/images/favicon.ico' rel='icon' type='image/x-icon'/>


    @yield('cssLinks')
    <link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.js"></script>
    @include('layouts.js_scriptloader')
            <!-- bootstrap -->
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- bootbox: was going to use for warning easy modals NOT CURRENTLY USED -->
    <script type="text/javascript" src="<?php echo asset("inc/js/bootbox.min.js");?>"></script>
    <!--  rubaXA Sortable for drag and drop -->
    <script src="http://rubaxa.github.io/Sortable/Sortable.js"></script>
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