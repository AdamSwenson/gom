@extends('new.newmaster')

@section('pageTitle', 'Gradeomatic - Set up and manage exams')
@section('description', 'Setup page for the Gradeomatic')

@section('pageCss')
<style>
    html{
        /*height: 100vh;*/
        height: 100%;
        margin:0;
        /*height:auto !important;*/
    }
    body{
        min-height: 100%;
margin:0;
        /*height:auto !important;*/
        /*height: 100vh;*/
    }
</style>
{{--<link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">--}}
@endsection

@section('pageJs')

    <script src="{{ asset('/js/dev/new-setup-package.js') }}"></script>


@endsection
