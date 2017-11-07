@extends('layouts.master')
@section('pageTitle', "Gradeomatic | Grade faster. Teach better")
@section('description', "Give personalized feedback. Collect detailed data. Finish grading faster.")

@section('otherCss')
    {{--<link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">--}}
@endsection
@section('body')
    <div id="homePage" class="row mainBodyLocator">
        <div class="col-xs-1 col-md-2 col-lg-2"></div>
        <div class="col-xs-10 col-md-8 col-lg-8">
            <h1>Give personalized feedback. Collect detailed data. Finish grading fast.</h1>


@include('home.partials.slide_carousel')

    {{--<div class="row">--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
                {{--<div class="col-xs-10 col-md-8 col-lg-8">--}}
                    {{--<images--}}
                            {{--class="images-responsive"--}}
                            {{--src="{{asset('images/home/greenbookSmall.jpeg')}}"--}}
                            {{--alt="Picture of a student's exam1, ready for grading.">--}}
                {{--</div>--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
                {{--<div class="col-xs-10 col-md-8 col-lg-8">--}}
                    {{--<images--}}
                            {{--class="images-responsive"--}}
                            {{--src="{{asset('images/home/partial_example_of_feedback_small.jpeg')}}"--}}
                            {{--alt="Picture of a student's exam1, ready for grading.">--}}
                {{--</div>--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
                {{--<div class="col-xs-10 col-md-8 col-lg-8">--}}
                    {{--<images--}}
                            {{--class="images-responsive"--}}
                            {{--src="{{asset('images/home/StudentThankYou1.jpeg')}}"--}}
                            {{--alt="Picture of a student's exam1, ready for grading.">--}}
                {{--</div>--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
                {{--<div class="col-xs-10 col-md-8 col-lg-8">--}}
                    {{--<images--}}
                            {{--class="images-responsive"--}}
                            {{--src="{{asset('images/home/StudentThankYou2.jpeg')}}"--}}
                            {{--alt="Picture of a student's exam1, ready for grading.">--}}
                {{--</div>--}}
                {{--<div class="col-xs-1 col-md-2 col-lg-2"></div>--}}
            {{--</div>--}}
        {{--</div>--}}

@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = '';
    </script>
    <script type='text/javascript' src="{{ asset('js/common-package.js') }}"></script>
@endsection