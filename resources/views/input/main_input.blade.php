@extends('layouts.master')

@section('pageTitle', 'Grade exam')

@section('cssLinks')

    <link rel="stylesheet" type="text/css" href="{{asset('inc/css/jslider/css/jslider.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('inc/css/jslider/css/jslider.blue.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('inc/css/jslider/css/jslider.plastic.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('inc/css/jslider/css/jslider.round.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('inc/css/jslider/css/jslider.round.plastic.css')}}"/>

    <style type="text/css" media="screen">
        body {
            background: #EEF0F7;
        }

        .layout {
            padding: 50px;
            font-family: Georgia, serif;
        }

        .layout-slider {
            margin-bottom: 60px;
            width: 50%;
        }

        .layout-slider-settings {
            font-size: 12px;
            padding-bottom: 10px;
        }

        .layout-slider-settings pre {
            font-family: Courier;
        }

        .ui-slider-handle {
            -ms-touch-action: none;
            touch-action: none;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/navMenuStyles.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/standardStyles.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/examCreateStyles.css")}}"/>
@endsection

@section('body')
    <div id="mainTab">
        @include('input.dashboard')
        <div id="mainBody">
            @include('input.question_select')
            <div id="optionalQsHere">
                @include('input.question_div')
                @include('input.exam_info_area')
            </div>
            @include('input.backup_button')
        </div>
    </div>
@endsection

@section('jsArea')
    <div id="templatescripts">

        <script id="elementSlider" type="text/x-jQuery-tmpl">
                <li class="q${questionNumber}">
                <label for="${elementAbbr}">${elementEnglish}</label>
                <input type="text" id="${elementAbbr}" data="${elementID}" name="${elementAbbr}" value="${elementScore}" /> <br />
                <div class="layout-slider" style="width: 100%">
                <span style="display: inline-block; width: 400px; padding: 0 5px;">
                <input id="${elementAbbr}Slider" value="${sliderScore}" data="${elementID}" type="slider"  />
                </span>
                </div>
                </li>

        </script>
        <!--elementSlider-->

        <script id="questionScoreSelector" type="text/x-jQuery-tmpl">
                <div class="questionScore">
                <label for="q${questionNumber}Score">Question ${questionNumber} score: ${questionTitle}</label>
                <input type="text" id="q${questionNumber}Score" name="q${questionNumber}" class="qs" data="${questionID}" value="${questionScore}"/>
                <select id="q${questionNumber}Select" class="qs" name="q${questionNumber}" data="${questionID}" value="${questionScore}">
                </div>

        </script>

        <script id="selectTemplate" type="text/x-jQuery-tmpl">
                <label for="${selectID}">${selectLabel}</label>
                <input type="text" id="${selectTextID}" class="${selectTextClasses}" name="${selectTextName}" data="${selectTextData}"/>
                <select id="${selectID}" class="${selectClasses}" data="${selectData}"></select>

        </script>
    </div> <!--template scripts-->

    <div id="optionalQsHere">
        @for($qnum = 1; $qnum <= $numberOfQuestions; $qnum++ )
            <div id='question{{ $qnum }}' class='secTwo optionalQ'>
                <ul class="dump"></ul>
            </div>
        @endfor
    </div>
    <script type="text/javascript">
//        setTimeout(function(){}, 10);
        </script>

    <script type="text/javascript" src="{{asset('inc/js/securityTools.js')}}"></script>
    <script type="text/javascript" src="{{asset('inc/js/input_plugins.js')}}"></script>

    <script type="text/javascript" src="{{asset('inc/js/inputScripts.js')}}"></script>
    <script type="text/javascript" src="{{asset('inc/js/dashboardscripts.js')}}"></script>
    <script type="text/javascript" src="{{asset( 'inc/js/dashboardStatsScripts.js')}}"></script>
    <script type="text/javascript" src="{{asset('inc/js/dashboardStatsDisplay.js')}}"></script>

    <script type="text/javascript">
        setTimeout(function(){}, 10);
        $(document).ready(function () {
            // $.ajaxSetup({cache: false});
            {{--var scripts = [--}}
                {{--{{asset('inc/js/securityTools.js')}},--}}
                {{--{{asset('inc/js/input_plugins.js')}},--}}
{{--//                            "js/input_plugins-min.js",--}}
                {{--{{asset('inc/js/inputScripts.js')}},--}}
                {{--{{asset('inc/js/dashboardscripts.js')}},--}}
                {{--{{asset('inc/js/dashboardStatsScripts.js')}},--}}
                {{--{{asset('inc/js/dashboardStatsDisplay.js')}}--}}
                {{--];--}}

            var AUTOSTARTGROUP = true;
            var AUTOSTARTEXAM =true;

            function onLoad() {
                window.console.log('onload fired');
                $('.navMenuItem').menu();
                $('.prettyButton').button();
                $('#groupTimeControls').buttonset();
                $('#examTimeControls').buttonset();
                $('#showAll').button();
                $("#questionSelector").buttonset();
                bindHandlersToNewRecordButton();
                //initialize data handling objects
                var exam = new Exam();
                var record = new Record();
                setAutocomplete(exam, record);

                makePageSelect();
                makeNotecardSelect();
                makeCompletionSelect();

                //Setup and start the group timer
                var gtr = new TimerRecord('group');
                var gtd = new TimerDisplay('group');
                gtd.createGauge();
                if (AUTOSTARTGROUP) {
                    autorunGroup(gtd, gtr);
                }
                var intervalID = 0;
                //prepare exam timer
                var ttr = new TimerRecord('exam');
                var ttd = new TimerDisplay('exam');
                ttd.createGauge();
                if (AUTOSTARTEXAM) {
                    window.console.log('autostart exam set');
                    $(".qSelect").bind('click', function () {
                        ttr.start();
                        ttd.start();
                        $('#pagesSelect').bind("click", function () {
                            ttr.stop();
                            ttd.stop();
                        });
                    });
                }

                //Now that have all the exam data, start loading the statistics
                var statsData = new StatsData();
                statsData.setFormatter(new Formatter());
                statsData.addDisplayManager(new MakeCompletionStatsGauge());
                statsData.addDisplayManager(new DisplayOverallStats());
                statsData.addDisplayManager(new MakeSpeedTrendChart());
                //then make the ajax call for server data
                statsData.loadAllStats('api');
            }

            onLoad();
// scriptLoader(scripts, scripts.length, onLoad, 0);
        });
    </script>
@endsection