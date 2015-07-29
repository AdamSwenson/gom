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
                <div class="col-xs-12">
                    <h1 id="GradeomaticHomeTitle" class="text-left">Gradeomatic</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 btn-group">
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Home</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Features</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">About Us</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg ">News</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Pricing</a>
                </div>
            </div>
                <div class="container">
                        <div class="row" >
                            <div class="col-xs-12">
                        <div class="panel panel-default">
                            <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#Home">Home</a></li>
                            <li><a data-toggle="tab" href="#profile">Profile</a></li>
                          <!--  <li><a data-toggle="tab" href="#examMenu">Exams</a></li>
                            <li><a data-toggle="tab" href="#questionMenu">Questions</a></li>
                            <li><a data-toggle="tab" href="#elementsMenu">Elements</a></li>
                            <li><a data-toggle="tab" href="#studentsMenu">Students</a></li> -->
                        </ul>
                            <div class="tab-content">
                            <div id="profile" class="tab-pane fade">
                                <div class="list-group">
                                    <a href="#" class="list-group-item"><h4>Preferences</h4></a>
                                    <a href="#" class="list-group-item"><h4>Security</h4></a>
                                    <a href="#" class="list-group-item"><h4>Payment</h4></a>
                                    <a href="#" class="list-group-item"><h4>Upgrade</h4></a>
                                </div>
                            </div>
                            <div id="Home" class="tab-pane fade in active">
                                    <h3>Tasks</h3>
                                <a href="{{url('select')}}" type="button" class="btn btn-primary btn-lg">Exam Setup Wizard</a><br>
                                <label> See your list of Exams:</label><br>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Exams
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Exam1</a></li>
                                        <li><a href="#">Exam2</a></li>
                                        <li><a href="#">Exam3</a></li>
                                    </ul>
                                </div>
                                </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-xs-4">
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