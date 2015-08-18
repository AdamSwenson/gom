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
                <h3>{{ $exam->getTerm() }}, {{ $exam->getYear() }}: "{{ $exam->getName() }}" </h3>
                <!-- Centered Question Pills -->
                <ul class="nav nav-pills nav-justified">
                    @foreach($questionAssignments as $qAssignment)
                        <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                        <li <?php if ($qNumber == 1) {
                            echo "class='active'";
                        } ?> role="presentation">
                            <a href="#q{{ $qNumber }}-panel" data-toggle="tab">
                                Q{{ $qNumber }}</a></li>
                    @endforeach
                </ul>
                <!-- question panel -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            @foreach($questionAssignments as $qAssignment)
                                <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                                <div id="q<?php echo "$qNumber" ?>-panel" class="tab-pane fade
                                <?php if ($qNumber === 1) {
                                    echo "in active";
                                } ?>">
                                    <!-- question Name -->
                                    <h4 id="questionName">Question #{{ $qNumber }}:
                                        "{{ $qAssignment->getQuestionName() }}"</h4>
                                    <!-- question Scores -->
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="inputScore{{ $qNumber }}">Question Score:</label>
                                                <span id="inputScore{{ $qNumber }}">22/30</span>
                                            </div>
                                                <label class="col-md-3" for="customScore{{ $qNumber }}">Custom Score:</label>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number"
                                                       id="customScore{{ $qNumber }}"/>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- element area holds all sliders and comments for this question -->
                                    <div class="list-group">
                                        <?php $elements = $allElements[$qNumber - 1];
                                        $eNumber = 1;
                                        while ($eNumber <= count($elements) ) { ?>
                                                <!-- add element panels -->
                                        @include('grade.element_panel')
                                        <?php $eNumber++; } ?>
                                    </div>
                                </div>
                            @endforeach
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
                <a class="btn btn-success col-md-12"><span class="glyphicon glyphicon-save-file"
                                                           aria-hidden="true"></span>
                    Save & Finish</a>
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
    <script type='text/javascript' src="{{ asset('inc/js/bootstrap-slider.js') }}"></script>
    <script type="text/javascript">

        /*
         EXAM GRADES? Any flag to know if an exam has been graded?

         * on load:
         *   - count graded, updated "graded / remaining"
         *   - set all roster backgrounds to appropriate colors
         */

        /* initialize Sliders */

        $("[id^='sliderQ']").slider({
            ticks: [0, 33, 67, 100],
            ticks_labels: ['Missing', 'Poor', 'Fair', 'Excellent'],
            ticks_snap_bounds: 0,
            value: 0
        });

        $(document).ready(function () {
            /*
             when a student is selected:
             -load scores for all sliders
             -load text for all comments
             -load timer
             -set roster background color
             -set StudentName and StudentId fields
             */

            /*
             when a slider is moved:
             - record value / slider position for this element
             - update comment text (if necessary - consider replacing comment with stock if moving to a new region)
             - update total score
             - check if exam done. if done, call "examDone()"
             - check if all exams done. if all done, call "examDone()" and show "finish" button
             - examDone() - saves scores and comments for the student,
             sets roster background color to green,
             sets rosterScore
             saves all timers,
             updates "graded / remaining" fields.
             */
        });
    </script>
@endsection
