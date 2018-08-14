<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="google-site-verification" content="DCGG7JLvksNEN9XdkbV0IUENjMa5cOMopPQaB3dYzLc"/>

    <meta name="description" content="@yield('description')">

    <link href='{{ asset('inc/images/favicon.ico') }}' rel='icon' type='image/x-icon'/>

    <link rel="manifest" href="/manifest.webmanifest">

    <title>@yield('pageTitle')</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--All page specific stylesheets should go here--}}
    @yield('pageCss')


    @if(env('APP_ENV') == 'production')
        @include('other.google_analytics_include')
    @endif
</head>

<body>

    <div class="main-area">

        <div id="app"></div>

        {{ method_field('PUT') }}

        {{ method_field('PATCH') }}

        {{ method_field('DELETE') }}

        <input type="hidden" id="routeRoot" data="{{ url('') }}"/>
        <input type="hidden" id="examId" data="{{ $exam->id }}"/>

    </div>

    <script type="text/javascript">
        window.routeRoot = document.getElementById( 'routeRoot' ).getAttribute( 'data' );
        window.examId = document.getElementById( 'examId' ).getAttribute( 'data' );
    </script>

    {{--All page specific javascript should go here--}}
    @yield('pageJs')

</body>
</html>