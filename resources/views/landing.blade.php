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
                    <button type="button" class="btn btn-primary btn-lg">Guides</button>
                    <button type="button" class="btn btn-primary btn-lg">Features</button>
                    <button type="button" class="btn btn-primary btn-lg ">News</button>
                    <button type="button" class="btn btn-primary btn-lg">About Us</button>
                    <button type="button" class="btn btn-primary btn-lg">Help</button>
                </div>
            </div>
            <div class="row" >
                <div class="col-xs-8">
                    <!-- Something goes here-->

                </div>
                <form role="form" method="POST" action="{{url('account/home')}}" accept-charset="UTF-8" class="col-xs-4">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <h3 class="text-left"> Log In:</h3>
                    <div class="form-group ">
                        <input class="form-control" type="email" name="email"  placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="pwd" placeholder="Enter password">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox"> Remember me</label>
                        <label><a>Forgot Password</a></label>
                    </div>
                    <input class="btn btn-default" type="submit" >
                    <a href="{{url('account/create')}}" class="btn btn-default" >Create Account</a>
                </form>
            </div>


            <!--
            <div id="navarea">
                <div class="navs">
                    <h3>Get started</h3>
                    <ul>
                        <li><a href="<?php  ?>">Sign up</a></li>
                        <li><a href="<?php  ?>">Login</a></li>
                    </ul>
                </div>
                <div class="navs">
                    <h3 id="Guides">Guides and the future</h3>
                    <ul>
                        <li><a id="Instructions" href="<?php  ?>">Instructions</a></li>
                        <li><a id="Announcements" href="<?php  ?>">Announcements</a></li>
                        <li><a href="<?php  ?>">Known bugs</a></li>
                        <li><a href="<?php  ?>">History of the gradeomatic</a></li>
                    </ul>
                </div>

                <div class="navs">
                    <h3>Setup an exam</h3>
                    <ul>
                        <li>Wizard</li>
                        <li><a href="{{url('setup/exam')}}">Create the exam</a> <span class="ui-icon ui-icon-locked"
                                                                                      style="display: inline-block"></span>
                        </li>
                        <li><a href="{{url('setup/question')}}">Create and edit questions</a> <span
                                    class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                        <li><a href="{{url('setup/element')}}">Create and edit comments</a> <span
                                    class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                        <li><a href="<?php  ?>">Upload your roster</a> <span class="ui-icon ui-icon-locked"
                                                                             style="display: inline-block"></span></li>
                    </ul>
                </div>
                <div class="navs">
                    <h3>Grade an exam</h3>
                    <ul>
                        <li><a href="{{url('exammanager')}}">Choose an exam for grading</a><span
                                    class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                        <li><a href="{{url('input')}}">Grade it</a><span class="ui-icon ui-icon-locked"
                                                                         style="display: inline-block"></span></li>
                        <li><a href="{{url('report/gradeassign')}}">Assign grades</a><span
                                    class="ui-icon ui-icon-locked"
                                    style="display: inline-block"></span>
                        </li>
                        <li><a href="{{url('exammanager')}}">Release comments to students </a><span
                                    class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                    </ul>
                </div>
                <div class="navs">
                    <h3>Quality control</h3>
                    @include('navigation.nav_other')

                </div>
            </div>
        </div>
    </div> -->
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