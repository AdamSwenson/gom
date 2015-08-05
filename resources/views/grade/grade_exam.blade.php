@extends('layouts.master')

@section('pageTitle', 'Grade Exam')
@section('description', 'Grade the exam')
@section('cssLinks')

@endsection

@section('body')
    <div class="container">
        <div class="row">
            <!-- Left column holds questions and sliders -->
            <div class="col-md-8">
                <h3>Question #1: "Causes of the Civil War"</h3>
                <!-- Centered Question Pills -->
                <ul class="nav nav-pills nav-justified">
                    <li class="active" role="presentation"><a href="#q1-panel" data-toggle="tab">Q1</a></li>
                    <li role="presentation"><a href="#q2-panel" data-toggle="tab">Q2</a></li>
                    <li role="presentation"><a href="#q3-panel" data-toggle="tab">Q3</a></li>
                    <li role="presentation"><a href="#q4-panel" data-toggle="tab">Q4</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <?php for ($count = 0; $count < 4; $count++) { ?>
                                    <!-- element sliders -->
                            @include('grade.element_slider')
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column holds Roster and Time info -->
            <div class="col-md-4">

                <!-- student name and / or ID -->
                <div class="row">
                    <div class="col-md-6">
                        <h4 id="student-name"><span class="glyphicon glyphicon-pencil"> </span> John Doe</h4>
                    </div>
                    <div class="col-md-6">
                        <h4 id="student-id">ID 123456789</h4>
                    </div>
                </div>
                <p>Graded: 0 Remaining: 22</p>
                <!-- student table -->
                @include('grade.student_table')
                        <!-- timing and data -->
                <h4><span class="glyphicon glyphicon-time"></span> Statistics</h4>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <span class="col-md-6">Time This Exam</span>
                        <span class="col-md-6">00:35</span>

                        <span class="col-md-6">Average Time</span>
                        <span class="col-md-6">02:25</span>

                        <span class="col-md-6">Total Time</span>
                        <span class="col-md-6">00:45:55</span>

                        <span class="col-md-6">Time Remaining</span>
                        <span class="col-md-6">01:34:15</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('jsArea')
    <script type="text/javascript">

        $(document).ready(function () {
            // Instantiate a slider
            var mySlider = $("input.slider").bootstrapSlider();

            // Call a method on the slider
            var value = mySlider.bootstrapSlider('getValue');
        });
    </script>
@endsection
