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
                <div class="container">
                        <div class="row" >
                            <div class="col-xs-10">
                        <div class="panel panel-default">
                            <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#Home">Home</a></li>
                            <li><a data-toggle="tab" href="#profile">Profile</a></li>
                            <li><a data-toggle="tab" href="#menu1">Exams</a></li>
                            <li><a data-toggle="tab" href="#menu2">Students</a></li>
                            <li><a data-toggle="tab" href="#menu3">Questions</a></li>
                            <li><a data-toggle="tab" href="#menu4">Comments</a></li>
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
                            <div id="menu1" class="tab-pane fade">
                                <h3>Menu 1</h3>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <h3>Menu 2</h3>
                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                            </div>
                            <div id="menu3" class="tab-pane fade">
                                <h3>Menu 3</h3>
                                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                            </div>
                            <div id="menu4" class="tab-pane fade">
                                    <h3>Menu 3</h3>
                                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                </div>
                            <div id="Home" class="tab-pane fade in active">
                                    <h3>Tasks</h3>
                                <a href="{{url('select')}}" type="button" class="btn btn-primary btn-lg">Exam Setup Wizard</a>
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