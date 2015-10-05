@extends('layouts.master')

@section('pageTitle', 'Welcome to gradeomatic')

@endsection
@section('description', 'Grade Exam | gradeomatic')

@section('cssLinks')

@endsection

@section('body')
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: auto;
            margin: auto;
            height: 500px;
        }

    </style>
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
@endsection


@section('jsArea')


@endsection