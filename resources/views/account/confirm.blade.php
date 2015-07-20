@extends('layouts.master')

@section('pageTitle', 'Welcome to the gradeomatic')

@section('cssLinks')

 <!-- styles for jsArea(the top bar of the webpage-->
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/navMenuStyles.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/standardStyles.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/examCreateStyles.css")}}"/>

  <!--styles for the rest of the webpage -->
    <link href="{{asset('inc/css/landing.css')}}" type="text/css" rel="stylesheet"/>
    <link href="{{asset('inc/css/indexStyle.css')}}" type="test/css" rel="stylesheet"/>
@endsection

@section('body')
    <div id="pageContainer">
        <div id="container" class="container">
            <div class="row">
                <div class="col-xs-10">
                    <h1 id="GradeomaticHomeTitle" class="text-left">Gradeomatic</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10 btn-group">
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Home</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Guides</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Features</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg ">News</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">About Us</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Help</a>
                </div>
            </div>
            <div class="row" >
                <div class="col-xs-8">
                    <h1> <h1>Account Created Check your email to confirm!</h1>  </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsArea')

    <script type="text/javascript" src="<?php echo asset("inc/js/common.js");?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var scripts = [
                "inc/js/common.js",
                "inc/js/examSetup.js"
            ];

            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */
            function onLoad() {
                $('.navMenuItem').menu();
                $('.prettyButton').button();
                bindListeners();
                console.log('onload fired');
            }

            onLoad();
//                    scriptLoader(scripts.length, 0);
        });
    </script>

@endsection

@endsection