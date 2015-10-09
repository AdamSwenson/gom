<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Welcome to the Gradeomatic </title>
    <meta name="description" content="Welcome to the Gradeomatic">

    <link href='{{asset('inc/images/favicon.ico')}}' rel='icon' type='image/x-icon'/>

    <style type="text/css">
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: auto;
            margin: auto;
            height: 500px;
        }

    </style>

    @include('layouts.js_jquery_loader')
    @include('layouts.js_bootstrap_loader')
    @include('layouts.js_additional_libs')

</head>
<body>
@include('navigation.nav_bar_landing')
<div class="container">
    <div id="myCarousel" class="carousel slide container" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{asset('inc/home/images/grading_shoulder.jpeg', env('APP_ENV') == 'production')}}"
                     alt="Grade">

                <div class="carousel-caption">
                    <h2>Grade Faster</h2>

                    <p>Gradeomatic makes grading fast and easy.</p>
                </div>
            </div>

            <div class="item">
                <img src="{{asset('inc/home/images/exam.jpg', env('APP_ENV') == 'production')}}"
                     alt="Teach">

                <div class="carousel-caption">
                    <h2>Teach Better</h2>

                    <p>Knowing where students need improvement helps you focus your teaching.</p>
                </div>
            </div>

            <div class="item">
                <img src="{{asset('inc/home/images/teacher_and_student.jpeg', env('APP_ENV') == 'production')}}"
                     alt="Feedback">

                <div class="carousel-caption">
                    <h2>More Feedback</h2>

                    <p>Let your students know how they perform.</p>
                </div>
            </div>

            <div class="item">
                <img src="{{asset('inc/home/images/analytics.png', env('APP_ENV') == 'production')}}" alt="analytics">

                <div class="carousel-caption">
                    <h2>Analytics</h2>

                    <p>Stats let you see your results in-depth.</p>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
</body>
</html>
