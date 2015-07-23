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
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Payment</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Guides</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Features</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg ">News</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">About Us</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Help</a>
                </div>
            </div>
            <div class="row" >
                <div class="col-xs-8">
                    <!-- Something goes here -->

                </div>
                <form method="post" action="{{url('select')}}" accept-charset="UTF-8" class="col-xs-4">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <h3 class="text-left"> Log In:</h3>
                    <div class="form-group ">
                        <input class="form-control" type="email" name="email"  placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox"> Remember me</label>
                        <label><a>Forgot Password</a></label>
                    </div>
                    <input class="btn btn-default" type="submit" >
                    <a href="{{url('account/create')}}" class="btn btn-default" >Create Account</a>
                </form>
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