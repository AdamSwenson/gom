@extends('layouts.master')
@section('pageTitle', "Gradeomatic | Grade faster. Teach better")
@section('description', "Give personalized feedback. Collect detailed data. Finish grading faster.")

@section('otherCss')

    <link rel="stylesheet" href="{{ asset("css/home-package.css")}}">
    <style>
        .secHead {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .maintenance-mode-message{
            margin: 1%;
            outline: #0000FF;
            outline-style: groove;
            padding-bottom: 17px;
            padding-top: 3px;
        }
    </style>
@endsection

@section('body')
    <div id="homePage" class="mainBodyLocator">

        @if( isset($exception) && $exception->getStatusCode() === 503)
            <div class="maintenance-mode-message ">
                <div class="text-center">
                    <h1>All access to the gradeomatic is presently disabled</h1>
                    <h3>Please use the feedback tab to contact us if you want access</h3>
                </div>
            </div>
        @endif

        <div class="row">

            <div class="col-lg-2"></div>

            <div id="gradeFaster"
                 class="col-lg-4 col-sm-6 col-xs-12 ">

                <h1 class="panel-heading secHead text-center sectionHeading">Grade Faster</h1>

                <div class="panel-body secBody text-justify">
                    @include('home.text.grade_faster')
                </div>
            </div>

            <div id="commentBetter"
                 class="mainSection col-lg-4 col-sm-6 col-xs-12 ">

                <h1 class="panel-heading secHead text-center sectionHeading">Comment Better</h1>

                <div class="panel-body secBody text-justify">
                    @include('home.text.comment_better')
                </div>
            </div>

            <div class="col-lg-2"></div>

        </div>

        <div class="row">
            <div class="col-lg-2"></div>

            <div id="teachBetter"
                 class="mainSection col-lg-4 col-sm-6 col-xs-12 ">

                <h1 class="panel-heading secHead text-center sectionHeading">Teach Better</h1>

                <div class="panel-body secBody text-justify">
                    @include('home.text.teach_better')
                </div>
            </div>

            <div id="gradeBetter"
                 class="mainSection col-lg-4 col-sm-6 col-xs-12">

                <h1 class="panel-heading secHead text-center sectionHeading">Grade Better</h1>

                <div class="panel-body secBody text-justify">
                    @include('home.text.grade_better')
                </div>
            </div>

            <div class="col-lg-2"></div>

        </div>

        <div class="row">

            <div id="signUpArea"
                 class="col-lg-12 col-xs-12 text-center "
            >
                @include('home.partials.signup_area')
            </div>
        </div>

    </div>
@endsection

@section('jsArea')
    @include('home.partials.student_feedback_modal')

    <script type="text/javascript">
        var activeTab = '';
    </script>
    <script type='text/javascript' src="{{ asset('js/common-package.js') }}"></script>
@endsection