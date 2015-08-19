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
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group ">
                                            <span class="col-md-9">
                                                <!-- question Name -->
                                                <h4 id="questionName">Question #{{ $qNumber }}:
                                                    "{{ $qAssignment->getQuestionName() }}"</h4>
                                            </span>
                                            <label class="col-md-1 control-label" for="customScore{{ $qNumber }}">
                                                Score:</label>
                                            <!-- question Score -->
                                            <div class="col-md-2">
                                                <input class="form-control" type="number"
                                                       id="questionScore{{ $qNumber }}"/>
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
                        <h4>
                            <span class="glyphicon glyphicon-pencil"> </span>
                            <span id="studentName"></span>
                        </h4>
                    </div>
                    <div class="col-md-6">
                        <h4>ID <span id="studentId"></span></h4>
                    </div>
                </div>
                <!-- graded / remaining counters -->
                <p>Graded: <span id="graded">0</span> Remaining: <span id="remaining">0</span></p>
                <!-- save & finish button -->
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

        var students = <?= json_encode($students) ?>;
        var studentScores = <?= json_encode($studentScores) ?>;
        var activeStudent = null;
        var examGrades = [];

        updateExamGrades();
        console.log(examGrades);

        /*
         * GENERAL FUNCTIONS
         */

        // keeps a persistent total of the exam score for each student
        function updateExamGrades() {
            for (var i = 0; i < studentScores.length; i++) {
                var thisScore = null;
                studentScores[i].forEach(function (gradeEntry) {
                    if (gradeEntry.score >= 0) {
                        if (thisScore === null) { thisScore = 0; }
                        thisScore += gradeEntry.score;
                    }
                });
                examGrades[i] = thisScore.toPrecision(3);
            };
        };

        // sets the studentName and studentId fields
        function setNameAndId(student) {
            var name = student.last_name + ", " + student.first_name;
            var id = student.student_identifier;
            $("#studentName").text(name);
            $("#studentId").text(id);
        }

        // update the "graded: xx remaining: xx" counters
        function updateGradedCounter() {
            var total = examGrades.length;
            var graded = examsGraded();
            var remaining = total - graded;
            $("#graded").text(graded);
            $("#remaining").text(remaining);
        }

        // returns number of exams graded
        function examsGraded() {
            var graded = 0;
            for (var i = 0; i < examGrades.length; i++) {
                if (examGrades[i] >= 0) graded++;
            }
            return graded;
        }

        // set the "grades" column in the student roster
        function updateRosterGradeDisplay() {
            /// set all graded exams green: grab data-index="k" and pass that object into function
            for (var i = 0; i < examGrades.length; i++) {
                if (examGrades[i] >= 0) {
                    $('#examGrade' + i).text(examGrades[i]);
                }
            }
        }

        // set backgrounds for all students who have graded exams
        function setStudentBackgroundColors() {
            for (var i = 0; i < examGrades.length; i++) {
                if (examGrades[i] >= 0) {
                    var name = "#studentListItem" + i;
                    var item = $('#studentRoster').find(name);
                    setRosterBackgroundGraded(item);
                }
            }
        }

        // set student roster background green when an exam has been scored
        function setRosterBackgroundGraded(item) {
            $(item).find('[class^="col"]').css('background-color', '#5cb85c');
            $(item).css('color', 'white');
        }

        /*
         ONLOAD AREA
         */
        $(document).ready(function () {

            updateGradedCounter();
            updateRosterGradeDisplay();
            setStudentBackgroundColors();

            /* initialize Sliders */
            $("[id^='slider']").slider({
                value: 0
            });

            // SELECT STUDENT - DO LOTS OF STUFF
            $("[id^='studentListItem']").click(function () {

                /*
                 when a student is selected:
                 -load scores for all sliders
                 -load text for all comments
                 -load timers
                 */

                // set StudentName and StudentId fields
                var index = $(this).attr("data-index");
                var aStudent = students[index];
                setNameAndId(aStudent);

                // calculate and display graded / remaining
                // THIS WILL BE MOVED TO THE SLIDER INTERACTION FUNCTION
                updateGradedCounter();
                setRosterBackgroundGraded(this);

                activeStudent = index;
            });

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
