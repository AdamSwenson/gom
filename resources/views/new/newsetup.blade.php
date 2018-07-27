@extends('new.newmaster')

@section('pageTitle', 'Set up and manage exams')
@section('description', 'Setup page for the Gradeomatic')

@section('pageCss')
{{--<link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">--}}
@endsection

@section('pageJs')
    <script src="{{ asset('/js/dev/new-setup-package.js') }}"></script>
@endsection

{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
    {{--<meta charset="UTF-8">--}}
    {{--<meta name=viewport content="width=device-width, initial-scale=1">--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}"/>--}}
    {{--<meta name="google-site-verification" content="DCGG7JLvksNEN9XdkbV0IUENjMa5cOMopPQaB3dYzLc"/>--}}
    {{--<meta name="description" content="Setup page for the gradeomatic">--}}

    {{--<link href='{{ asset('inc/images/favicon.ico') }}' rel='icon' type='image/x-icon'/>--}}

    {{--<link rel="manifest" href="/manifest.webmanifest">--}}

    {{--<title>Set up and manage exams</title>--}}

{{--    <link rel="stylesheet" href="{{ asset("css/common-package.css")}}">--}}
    {{--<link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
{{--</head>--}}

{{--<body>--}}

{{--<div class="main-area">--}}

    {{--<div id="app"></div>--}}

    {{--{{ method_field('PUT') }}--}}

    {{--{{ method_field('PATCH') }}--}}

    {{--{{ method_field('DELETE') }}--}}

    {{--<input type="hidden" id="routeRoot" data="{{ url('') }}"/>--}}
    {{--<input type="hidden" id="examId" data="{{ $exam->id }}"/>--}}


{{--</div>--}}

{{--<script type="text/javascript">--}}
    {{--window.routeRoot = document.getElementById( 'routeRoot' ).getAttribute( 'data' );--}}
    {{--window.examId = document.getElementById( 'examId' ).getAttribute( 'data' );--}}

{{--</script>--}}
{{--@section('pageJs')--}}
{{--<script src="{{ asset('/js/dev/new-setup-package.js') }}"></script>--}}
{{--<script src="http://localhost:35729/livereload.js"></script>--}}
{{--@endsection--}}
{{--</body>--}}
{{--</html>--}}