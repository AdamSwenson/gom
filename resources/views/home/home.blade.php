@extends('layouts.master')
@section('pageTitle', "Gradeomatic | Grade faster. Teach better")
@section('description', "Give personalized feedback. Collect detailed data. Finish grading faster.")

@section('otherCss')

    <link href="https://fonts.googleapis.com/css?family=Cabin+Condensed|Dancing+Script|Gloria+Hallelujah|Lobster|Oswald"
          rel="stylesheet">
    <style>
        .secHead h1 {
            {{--font-family: 'Oswald', sans-serif;--}}
            {{--font-family: 'Lobster', cursive;--}}
             font-family: 'Dancing Script', cursive;
            /*font-family: 'Gloria Hallelujah', cursive;*/
        }

        p .bodyText {

            font-family: 'Cabin Condensed', sans-serif;
            font-size: 14px;
        }
    </style>

@endsection

@section('body')
    <div id="homePage" class="mainBodyLocator">

        <div id="gradeFaster" class="row panel">
            <div class="row secHeader">
                <div class="col-lg-12 secHead text-center">
                    <h1>Grade Faster</h1>
                </div>
            </div>
            <div class="row secBody">
                <div class="col-md-6 col-sm-12 secText">
                    @include('home.left.grade_faster')
                </div>
                <div class="col-md-6 col-sm-12 secImage">
                    @include('home.right.grade_faster')
                </div>
            </div>
        </div>

        <div id="commentBetter" class="row panel">
            <div class="row secHeader" data-spy="affix-bottom" >
                <div class="col-lg-12 secHead text-center">
                    <h1>Comment Better</h1>
                </div>
            </div>
            <div class="row secBody">
                <div class="col-md-6 col-sm-12 secText">
                    @include('home.left.comment_better')
                </div>
                <div class="col-md-6 col-sm-12 secImage">
                    @include('home.right.comment_better')
                </div>
            </div>
        </div>

        <div id="teachBetter" class="row panel">
            <div class="row secHeader" data-spy="affix-bottom">
                <div class="col-lg-12 secHead  text-center">
                    <h1>Teach Better</h1>
                </div>
            </div>
            <div class="row secBody">
                <div class="col-md-6 col-sm-12 secText">
                    @include('home.left.teach_better')
                </div>
                <div class="col-md-6 col-sm-12 secImage">
                    @include('home.right.teach_better')
                </div>
            </div>
        </div>

        <div id="gradeBetter" class="row panel">
            <div class="row secHeader" data-spy="affix-bottom">
                <div class="col-lg-12 secHead text-center">
                    <h1>Grade Better</h1>
                </div>
            </div>
            <div class="row secBody">
                <div class="col-md-6 col-sm-12 secText">
                    @include('home.left.grade_better')
                </div>
                <div class="col-md-6 col-sm-12 secImage">
                    @include('home.right.grade_better')
                </div>
            </div>
        </div>

        <div id="beAdored" class="row panel">
            <div class="row secHeader" data-spy="affix-bottom">
                <div class="col-lg-12 secHead text-center">
                    <h1>Be Adored</h1>
                </div>
            </div>
            <div class="row secBody">
                @include('home.left.be_adored')
            </div>
        </div>

        <div id="signUpArea" class="row affix-bottom">
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
        $( ".affix-bottom" ).affix();
    </script>
@endsection