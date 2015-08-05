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
    @include('layouts.js_jqueryCss')
            <!-- moved these to test responsiveness -->
    @include('layouts.js_jqueryJs')
    @include('layouts.js_scriptloader')
            <!-- bootstrap -->
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- bootstrap sliders -->
    <script type='text/javascript' src="<?php echo asset("inc/js/bootstrap-slider.min.js");?>"></script>
    <link href="inc/css/bootstrap-slider.min.css" rel="stylesheet">
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