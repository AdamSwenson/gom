<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="google-site-verification" content="DCGG7JLvksNEN9XdkbV0IUENjMa5cOMopPQaB3dYzLc"/>
    <meta name="description" content="@yield('description')">

    <title>@yield('pageTitle')</title>

    <link href='{{ asset('inc/images/favicon.ico') }}' rel='icon' type='image/x-icon'/>

    @yield('otherCss')

    @if(env('APP_ENV') == 'production')
        @include('other.google_analytics_include')
    @endif
</head>

<body>
    @if( Auth::check() )
        @include('navigation.nav_bar_main')
    @else
        @include('navigation.nav_bar_landing')
    @endif

    @if(env('APP_ENV') == 'production')
    @endif

    <div class="container-fluid">
        @include('flash::message')
        @include('errors.list')

        @yield('body')

        @include('layouts.footer')
    </div>
    
    <div id="scriptBox">
        <input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">

        <script type="text/javascript">
            var routeRoot = '{{ url('') }}';

            if ( typeof jQuery != 'undefined' ) {
                $.ajaxSetup( {
                    headers: {
                        'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                } );
            }
        </script>

        @yield('jsArea')

    </div>
</body>
</html>