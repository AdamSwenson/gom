<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Welcome to the Gradeomatic</title>
    <meta name="description" content="Gradeomatic home page">

    <link href='{{ asset('inc/images/favicon.ico') }}' rel='icon' type='image/x-icon'/>
    {{--<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="right/css">--}}
    {{--<link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="right/css">--}}
    {{--<link href="{{ asset('css/grade-styles.css') }}" rel="stylesheet" type="right/css">--}}

    <link href="{{ asset('css/home-styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('grade') }}" rel="stylesheet" type="text/css">
    @include('layouts.js.js_jquery_loader')
    @include('layouts.js.js_bootstrap_loader')
</head>

<body>
@if( Auth::check() )
    @include('navigation.nav_bar_main')
@else
    @include('navigation.nav_bar_landing')
@endif
<div class="container-fluid">
    <div id="app">
        <div class="row">
            <div class="col-md-5">
                <h1 class="text-center">Do this</h1>

                <div class="row">
                    <div class="col-md-12">
                        <!-- question panel -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {{--<div class="tab-content">--}}
                                    {{--<div id="panelQuestion1" data-question-number="1" class="">--}}
                                        <div class="row">
                                            <div class="col-xs-7">
                                                <!-- question Name -->
                                                <h4 id="questionName">Question #1:
                                                    "@{{ questionName }}"</h4>
                                            </div>
                                            <!-- question Score -->

                                            <form class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <label class="col-xs-2 control-label"
                                                           for="questionScore1"
                                                    >Score: </label>

                                                    <div class="col-xs-1" style="padding: 0px;">
                                                        <a href="#" class="instructionTooltip instructionOrder1"
                                                           data-toggle="tooltip" title="Give the answer a score">
                                                        <input class="form-control pull-right"
                                                               id="questionScore1"
                                                               v-model="questionScore"
                                                               v-spinner
                                                        />
                                                            </a>
                                                    </div>
                                                    <div class="col-xs-2 control-label" style="text-align: left;">
                                                        <b>/ 100</b>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                <a href="#" class="instructionTooltip instructionOrder3"
                                   data-toggle="tooltip" title="Move sliders to score subsidiary tasks"></a>
                                        <div class="list-group">
                                            <slider element-number="1" element-name="Explain Descartes' goal"
                                                    target-id="commentPara1"></slider>
                                            <slider element-number="2" element-name="Explain role of doubt"
                                                    target-id="commentPara2"></slider>
                                            <slider element-number="3" element-name="Explain the dreaming doubt"
                                                    target-id="commentPara3"></slider>
                                        </div>

                                    </div>

                                </div>

                            </div>
                    {{--</div>--}}
                    {{--</div>--}}
                </div>

            </div>


            {{--Comments side--}}
            <div class="col-md-7">
                <h1 class="text-center">Give your students this</h1>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-left"><strong>Student name:</strong>
                            <mark>Smith, Jane</mark>
                        </p>
                        <p class="text-left"><strong>Grade:</strong>
                        <a href="#" class="instructionTooltip instructionOrder2"
                           data-toggle="tooltip" title="The exam grade automatically updates">
                            <mark>@{{ grade }}</mark>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h3>@{{ questionName }}</h3>

                        <p class="commentPara">@{{ commentPara1 }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="chart1"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="commentPara">@{{ commentPara2 }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="chart2"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="commentPara">@{{ commentPara3 }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="chart3"></div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

<input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">

<div id="scriptBox">

    <script type='text/javascript' src="{{ asset('inc/js/bootstrap-slider.js') }}"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load('visualization', '1', {'packages': ['corechart']});
    </script>

    {{--<script type="right/javascript" src="{{ asset('js/commonScripts.js') }}"></script>--}}
    <script src="{{ asset('js/home-package.js') }}"></script>


    @if(env('APP_ENV') == 'production')
        @include('other.google_analytics_include')
    @endif

</div>
</body>
</html>
