@extends('layouts.master')

@section('otherCss')
    <link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/grading-styles.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('body')
    <div id="app">
        <div class="row">
            <div class="col-md-5">
                <h1 class="text-center">Do this</h1>

                <div class="row">
                    <div class="col-md-12">
                        <!-- question panel -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="panelQuestion1" data-question-number="1" class="">
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
                                                        <input class="form-control pull-right"
                                                               id="questionScore1"
                                                               v-model="questionScore"
                                                                {{--v-on:change="updateGrade"--}}
                                                        />
                                                    </div>
                                                    <div class="col-xs-2 control-label" style="text-align: left;">
                                                        <b>/ 100</b>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- element area holds all sliders and comments for this question -->
                                        <div class="list-group">
                                            <div class="list-group-item" style="background-color: #DDDDDD;">
                                                <h5>Element #1: "@{{ elements[0] }}"</h5>

                                                <div class="row">
                                                <span class="col-md-12" style="padding-right: 0px;">
                                                    <label for="slider1"></label>
                                                    <input
                                                            class="slider"
                                                            id="slider1"
                                                            v-model="slider1"
                                                            v-on:blur="updateSlider1"
                                                            type="text"
                                                    />
                                                </span>
                                                </div>
                                            </div>

                                            <div class="list-group-item" style="background-color: #DDDDDD;">
                                                <h5>Element #2: "@{{ elements[1] }}"</h5>

                                                <div class="row">
                                                <span class="col-md-12" style="padding-right: 0px;">
                                                    <label for="slider2"></label>
                                                    <input class="slider"
                                                           id="slider2"
                                                           v-model="slider2"
                                                           v-on:slidechange="updateSlider2"
                                                           type="text"/>
                                                </span>
                                                </div>
                                            </div>

                                            <div class="list-group-item"
                                                 style="background-color: #DDDDDD;">
                                                <h5>Element #3: "@{{ elements[2] }}"</h5>

                                                <div class="row">
                                                <span class="col-md-12" style="padding-right: 0px;">
                                                    <label for="slider3"></label>
                                                    <input type="text"
                                                           class="slider"
                                                           id="slider3"
                                                           v-model="slider3"
                                                    />
                                                </span>
                                                </div>
                                            </div>

                                            <slider element-number="1" element-name="test 4" target-id="commentPara1"></slider>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

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
                            <mark>@{{ grade }}</mark>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h3>@{{ questionName }}</h3>

                        <p id="commentPara1">@{{ commentPara1 }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="chart1"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p id="commentPara2">@{{ commentPara2 }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="chart2"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p id="commentPara3">@{{ commentPara3 }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="chart3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <template id="sliderArea">

    </template>
@endsection

@section('jsArea')
    {{--<script type='text/javascript' src="{{ asset('inc/js/bootstrap-slider.js') }}"></script>--}}

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load('visualization', '1', {'packages': ['corechart']});
    </script>
    <script type="text/javascript">
        //        $(document).ready(function(){
        //            var valenceCutoffs = [0, 3.25, 6.75, 10];
        //                   var valenceLabels = ["Missing", "Poor", "Fair", "Excellent"];
        //                    var valenceLabelPositions= [0, 33, 67, 100];
        //                    var sliderStep=.25;
        //
        //                    $('input.slider').slider({
        //                tooltip: 'show',
        //                value: 0,
        //                step: sliderStep,
        //                ticks: valenceCutoffs,
        //                ticks_labels: valenceLabels,
        //                ticks_position: valenceLabels
        //            });
        //        });
        //        window.console.log('ready2');
    </script>

    <script src="{{ asset('js/home-package.js') }}"></script>
@endsection