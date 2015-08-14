<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/13/15
 * Time: 6:19 PM
 */ ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    @include('layouts.js_jqueryCss')
    {!! \HTML::style(asset('/css/app.css')) !!}


</head>
<body>
<div id="app" class="container">

    {{--<script id="slider-template" type="x-template">--}}
        {{--<div class="sliderArea">--}}
            {{--<div class="gradeLabelArea">--}}
                {{--<div class="gradeLabelArea left">--}}
                    {{--<input type="text" name="@{{gradeName}}_minScore" v-model="minScore"--}}
                           {{--placeholder="Min"/>--}}
                {{--</div>--}}

                {{--<div class="gradeLabelArea center">@{{ gradeLabel }}</div>--}}
                {{--<div class="gradeLabelArea right">--}}
                    {{--<input type="text" class="gradeLabelArea right" name="@{{gradeName}}_maxScore" v-model="maxScore"--}}
                           {{--placeholder="Max"/>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="sliderHolder">--}}
                {{--<div class="slider" id="@{{ sliderId }}" data-slider-min="0" data-slider-max="100" data-slider-step="1"--}}
                     {{--data-slider-value="0"--}}
                     {{--data-slider-orientation="horizontal"--}}
                     {{--data-slider-selection="after"--}}
                     {{--data-slider-tooltip="show">--}}
                {{--</div>--}}
                {{--<div class="sliderRemove">--}}
                    {{--<button v-on="click:remove(this)">X</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</script>--}}


    <div id="gradeSlidersHere">
        <div v-repeat="grade : grades">
            <grade-slider grade-name="@{{ grade.name }}"  grade-label="@{{ grade.label }}" grade-order="@{{ grade.order }}"></grade-slider>
        </div>
    </div>

    <pre>@{{ $components | json }}</pre>



    @include('layouts.js_jqueryJs')
            <!-- bootstrap -->
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.10/vue.js"></script>

    <script src="{{asset('/js/bundle.js')}}"></script>
</div>
</body>
</html>
