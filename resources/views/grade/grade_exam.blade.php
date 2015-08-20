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
                <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                    {{ $exam->getTerm() }}, {{ $exam->getYear() }}: "{{ $exam->getName() }}" </h3>
                <h4 id="selectPrompt">To begin grading, select a student.</h4>
                <div id="questionArea" style="display: none">
                    <!-- Centered Question Pills -->
                    <ul class="nav nav-pills nav-justified">
                        @foreach($questionAssignments as $qAssignment)
                            <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                            <li <?php if ($qNumber == 1) {
                                echo "class='active'";
                            } ?> role="presentation">
                                <a href="#panelQuestion{{ $qNumber }}" data-toggle="tab">
                                    Q{{ $qNumber }}</a></li>
                        @endforeach
                    </ul>
                    <!-- question panel -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="tab-content">
                                <?php $count = 0 ?>
                                @foreach($questionAssignments as $qAssignment)
                                    <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                                    <div id="panelQuestion{{ $qNumber }}" data-question-number="{{ $qNumber }}" class="tab-pane fade
                                                    <?php if ($qNumber === 1) {
                                        echo "in active";
                                    } ?>">
                                        <div class="form-horizontal" role="form">
                                            <div class="form-group ">
                                            <span class="col-md-9">
                                                <!-- question Name -->
                                                <h4 id="questionName">Question #{{ $qNumber }}:
                                                    "{{ $qAssignment->getQuestionName() }}"</h4>
                                            </span>
                                                <label class="col-md-1 control-label" for="questionScore{{ $qNumber }}">
                                                    Score:</label>
                                                <!-- question Score -->
                                                <div class="col-md-2">
                                                    <input class="form-control questionScore" type="number" min="0"
                                                           data-number="{{ $qNumber }}"
                                                           id="questionScore{{ $qNumber }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- element area holds all sliders and comments for this question -->
                                        <div class="list-group">
                                            <?php $elements = $allElements[$qNumber - 1];
                                            $eNumber = 0;
                                            while ($eNumber < count($elements) ) { ?>
                                                    <!-- add element panels -->
                                            @include('grade.element_panel')
                                            <?php $count++; $eNumber++; } ?>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column holds Roster and Time info -->
            <div class="col-md-4">

                <!-- student name and / or ID -->
                <div class="row">

                    <div class="col-md-7">
                        <h4>
                            <span class="glyphicon glyphicon-pencil"> </span>
                            <span id="studentName">No Student Selected</span>
                        </h4>
                    </div>
                    <div class="col-md-5">
                        <h4>ID <span id="studentId">--</span></h4>
                    </div>
                </div>
                <!-- graded / remaining counters -->
                <p>Graded: <span id="graded">0</span> Remaining: <span id="remaining">0</span></p>
                <!-- save & finish button -->
                <a class="btn btn-success col-md-12" id="finishButton" style="display: none;">
                    <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>Save & Finish
                </a>
                <!-- student table -->
                @include('grade.student_table')
                        <!-- timing and data -->
                <h4><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Statistics</h4>

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
        // "students" is a set of student objects - decompose?
        var students = <?= json_encode($students) ?>;
        var elementComments = <?= json_encode($studentElementComments) ?>;
        var elementScores = <?= json_encode($studentElementScores) ?>;
        var questionScores = <?= json_encode($studentQuestionScores) ?>;
        var stockComments = <?= json_encode($stockComments) ?>;
        var studentComments = [];
        var activeStudent = null;
        var customScoring = true;
        var examGrades = [];

        console.log(elementComments);
        updateExamGrades();

        // Set valenceCutoffs for comments. These represent the max value for each valence group.
        // Magic numbers for now, but these may be a user option later on.
        //var maxSliderValue = $sliders[0].slider('getAttribute', 'max');
        var valenceCutoffs = [0, 3.25, 6.75, 10];

        /* initialize Sliders */
        var $sliders = $('input.slider').slider({
            tooltip: 'show'
        });

        /*
         * GENERAL FUNCTIONS
         */

        // Returns which valence group (int) a given score belongs to by comparing to valenceCutoffs[]
        function getValence(score) {
            var valence = 0;
            for (var j = valenceCutoffs.length - 2; j >= 0; j--) {
                if (score > valenceCutoffs[j]) {
                    valence = j + 1;
                    break;
                }
            }
            return valence;
        }

        // examGrades[] keeps a persistent total of the exam score for each student
        function updateExamGrades() {
            for (var i = 0; i < questionScores.length; i++) {
                var totalScore = null;
                questionScores[i].forEach(function (gradeEntry) {
                    if (gradeEntry !== null && gradeEntry >= 0) {
                        if (totalScore === null) {
                            totalScore = 0;
                        }
                        totalScore += gradeEntry;
                    }
                });
                examGrades[i] = totalScore.toPrecision(3);
            }
        }


        // sets the studentName and studentId fields
        function setNameAndId() {
            var student = students[activeStudent];
            var name = student.last_name + ", " + student.first_name;
            var id = student.student_identifier;
            $("#studentName").text(name);
            $("#studentId").text(id);
        }

        // update the "graded: xx remaining: xx" counters
        // also displays the "Save & Finish" button when remaining == 0
        function updateGradedRemainingCounter() {
            var total = examGrades.length;
            var graded = examsGraded();
            var remaining = total - graded;
            $("#graded").text(graded);
            $("#remaining").text(remaining);
            if (remaining === 0) {
                $('#finishButton').show();
            }
        }

        // returns number of exams graded
        function examsGraded() {
            var graded = 0;
            for (var i = 0; i < examGrades.length; i++) {
                if (examGrades[i] !== null) graded++;
            }
            return graded;
        }

        // set the "grades" column in the student roster
        function updateRosterGradeDisplay() {
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

        function updateStudentDataArea() {
            updateExamGrades();
            updateGradedRemainingCounter();
            updateRosterGradeDisplay();
            setStudentBackgroundColors();
        }

        // sums elements scores and sets question scores
        function updateQuestionScores() {

        }

        // save timers for the active student and update the displays for avg time, total time, and time remaining
        function saveTimers() {
            if (activeStudent === null) return;
        }

        // loads the timers for the active student. Called when loading a student
        function loadTimers() {
            if (activeStudent === null) return;
        }

        /*
         *
         * ONLOAD AREA
         *
         */

        $(document).ready(function () {

            updateStudentDataArea();

            /* Handle Slider movement */
            $('input.slider').on('slideStop', function (slideEvt) {

                // update element score
                var elementNumber = $(this).closest('[id^="element"]').attr('data-element-index');
                var oldScore = elementScores[activeStudent][elementNumber];
                var newScore = slideEvt.value;

                // TODO: save element score to server - return on failure
                elementScores[activeStudent][elementNumber] = newScore;

                // update and save question scores - if using bell curve scoring
                if (!customScoring) {
                    updateQuestionScores();
                }

                // update comment text -- only change the text if the score has changed valence regions
                var $parent = $(this).parents('[id^="element"]');
                var $elementComment = $($parent).find('textArea');
                if (getValence(newScore) != getValence(oldScore)) {
                    var stockResponse = stockComments[elementNumber][getValence(newScore)];
                    $($elementComment).val(stockResponse);
                    // TODO: save new  comment text to data structure & server
                }

                // update exam scores and student data area
                updateStudentDataArea();
                saveTimers();
            });

            // Handle question score inputs. When focus is lost, store values, update grades and save timers.
            $('.questionScore').change(function () {
                var qNumber = $(this).attr('data-number');
                questionScores[activeStudent][qNumber - 1] = parseFloat($(this).val());
                updateStudentDataArea();
                // TODO: save score to server
                saveTimers();
            });


            //  Handle changes to the comment TextArea when focus is lost. Saves data and timers.
            $('[name^="comment"]').focusout(function () {
                // TODO: when comment textArea loses focus, save to data structure and DB
                saveTimers();
            });

            /*
            * A student is selected from the roster - DO LOTS OF STUFF
            */

            $("[id^='studentListItem']").click(function () {
                saveTimers();
                $('#selectPrompt').hide();
                $('#questionArea').show("fast");

                // set the active student
                activeStudent = $(this).attr("data-index");
                setNameAndId();
                loadTimers();

                // set question scores
                $("[id^='questionScore']").each(function (index) {
                    var score = questionScores[activeStudent][index];
                    $(this).val(score);
                });

                // set slider values
                $.each($sliders, function (index, item) {
                    var score = elementScores[activeStudent][index];
                    item.slider('setValue', score);
                });

                // set comments
                $('[name^="commentQ"]').each( function(index) {
                    var thisComment = elementComments[activeStudent][index];
                    $(this).val(thisComment);
                });

            });

            // finish & save button routes to reports
            $('#finishButton').click(function () {

            });

            return false;
        });
    </script>
@endsection
