@extends('layouts.primalMaster')

@section('pageTitle', 'Welcome to the gradeomatic')

@section('cssLinks')

        <!-- styles for jsArea(the top bar of the webpage-->
<link rel="stylesheet" type="text/css" href="{{asset("inc/css/navMenuStyles.css")}}"/>
<link rel="stylesheet" type="text/css" href="{{asset("inc/css/standardStyles.css")}}"/>
<link rel="stylesheet" type="text/css" href="{{asset("inc/css/examCreateStyles.css")}}"/>

<!--styles for the rest of the webpage -->
<link href="{{asset('inc/css/landing.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{asset('inc/css/indexStyle.css')}}" type="test/css" rel="stylesheet"/>
@yield('cssLinks')
@endsection

@section('body')
    @yield('body')
            <div class="row">
                <div class="col-xs-10">
                    <h1 id="GradeomaticHomeTitle" class="text-left">Gradeomatic</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10 btn-group">
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Home</a>
                    <button type="button" class="btn btn-primary btn-lg">Guides</button>
                    <button type="button" class="btn btn-primary btn-lg">Features</button>
                    <button type="button" class="btn btn-primary btn-lg ">News</button>
                    <button type="button" class="btn btn-primary btn-lg">About Us</button>
                    <button type="button" class="btn btn-primary btn-lg">Help</button>
                </div>
            </div>
@endsection