@extends('layouts.master')

@section('pageTitle', 'Welcome to the gradeomatic')

@section('cssLinks')
    <link href="{{asset('inc/css/landing.css')}}" type="text/css" rel="stylesheet"/>
@endsection

@section('body')
    <div id="pageContainer">

        <div id="container">
            <div id="test">Test</div>
            <div id="navarea">
                <div class="navs">
                    <h3>Get started</h3>
                    <ul>
                        <li><a href="<?php  ?>">Sign up</a></li>
                        <li><a href="<?php  ?>">Login</a></li>
                    </ul>
                </div>
                <div class="navs">
                    <h3>Guides and the future</h3>
                    <ul>
                        <li><a href="<?php  ?>">Instructions</a></li>
                        <li><a href="<?php  ?>">Announcements</a></li>
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