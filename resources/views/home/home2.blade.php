@extends('layouts.master')
@section('pageTitle', "Gradeomatic | Grade faster. Teach better")
@section('description', "Give personalized feedback. Collect detailed data. Finish grading faster.")

@section('otherCss')

    <link href="https://fonts.googleapis.com/css?family=Cabin+Condensed|            Cinzel|Francois+One|Lalezar|Patua+One|Lobster|Oswald"
          rel="stylesheet">
    <style>
        .secHead h1 {
            /*font-family: 'Oswald', sans-serif;*/
            /*font-family: 'Lalezar', cursive;*/

            /*font-family: 'Francois One', sans-serif;*/

            /*font-family: 'Patua One', cursive;*/

            font-family: 'Cinzel', serif;

            /*font-family: 'Lobster', cursive;*/
            /*font-family: 'Dancing Script', cursive;*/
        }

        .bodyText {

            /*font-family: 'Cabin Condensed', sans-serif;*/
            font-family: 'Cinzel', serif;

            font-size: 14px;
        }
    </style>

@endsection

@section('body')
    <div id="homePage" class="mainBodyLocator">

        <div class="row">
            <div class="col-lg-2"></div>
            <div id="gradeFaster" class="col-lg-4 col-md-6 col-sm-12 ">
                <div class="panel-heading secHead text-center">
                    <h1>Grade Faster</h1>
                </div>

                <div class="panel-body secBody">
                    @include('home.text.grade_faster')
                </div>
            </div>

            <div id="commentBetter" class="col-lg-4 col-md-6 col-sm-12 ">
                <div class="panel-heading secHead text-center">
                    <h1>Comment Better</h1>
                </div>
                <div class="panel-body secBody">
                    @include('home.text.comment_better')
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="row">
            <div class="col-lg-2"></div>
            <div id="teachBetter" class="col-lg-4 col-md-6 col-sm-12 ">
                <div class="panel-heading secHead  text-center">
                    <h1>Teach Better</h1>
                </div>
                <div class="panel-body secBody">
                    @include('home.text.teach_better')
                </div>
            </div>

            <div id="gradeBetter" class="col-lg-4 col-md-6 col-sm-12 ">
                <div class="panel-heading secHead text-center">
                    <h1>Grade Better</h1>
                </div>
                <div class="panel-body secBody">
                    @include('home.text.grade_better')
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="row">
            <div class="col-lg-2"></div>
            <div id="beAdored" class="col-lg-8 col-md-6 col-sm-12 ">
                <div class="panel-heading secHead text-center">
                   <h1>Help More</h1>
                    {{--<h1>Learn Better</h1>--}}
                </div>
                <div class="panel-body secBody">
                    @include('home.text.be_adored')
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div id="signUpArea" class="row">
            <div class="col-lg-12 col-md-12 text-center ">
                @include('home.partials.signup_area')
            </div>
        </div>

    </div>
@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = '';
    </script>
    <script type='text/javascript' src="{{ asset('js/common-package.js') }}"></script>
    <script>
      //  $( ".affix-bottom" ).affix();
    </script>
@endsection