@extends('layouts.master')

@section('pageTitle', 'Grade Exam')
@section('description', 'Grade an exam')
@section('cssLinks')

@endsection

@section('body')
    <div class="container">
        <div class="row">
            <!-- Left column holds questions and sliders -->
            <div class="col-md-8">
                <h3 data-exam-id="{{ $exam->getId() }}"><span class="glyphicon glyphicon-list-alt"
                                                              aria-hidden="true"></span>
                    {{ $exam->getTerm() }}, {{ $exam->getYear() }} "{{ $exam->getName() }}" </h3>
                <h4 id="selectPrompt">Select a student to begin grading</h4>

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
                                                           data-question-assignment-id="{{ $qAssignment->getId() }}"
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
                            <span id="activeStudentName">No Student Selected</span>
                        </h4>
                    </div>
                    <div class="col-md-5">
                        <h4>ID <span id="activeStudentIdentifier">--</span></h4>
                    </div>
                </div>
                <!-- graded / remaining counters -->
                <p>Graded: <span id="graded">0</span> Remaining: <span id="remaining">0</span></p>
                <!-- save & finish button -->
                <a class="btn btn-success col-md-12" href="{{ url('report/') }}" id="finishButton" style="display: none;">
                    <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>Save & Finish
                </a>
                <!-- student table -->
                @include('grade.student_table')
                        <!-- timing and data -->
                @include('grade.statistics_table')
            </div>
        </div>
    </div>
@endsection


@section('jsArea')
    <script type='text/javascript' src="{{ asset('inc/js/bootstrap-slider.js') }}"></script>
    <script type="text/javascript">

        var elementComments = <?= json_encode($studentElementComments) ?>;
        var elementScores = <?= json_encode($studentElementScores) ?>;
        var questionScores = <?= json_encode($studentQuestionScores) ?>;
        var stockComments = <?= json_encode($stockComments) ?>;
        var examGradingTimes = <?= json_encode($examGradingTimes) ?>;
        var numStudents = {{ count($students) }};
        var numQuestions = {{ count($questionAssignments) }};
        var examGrades = [];
        var activeStudent = null;
        var standardScoring = true;
        var sortAsc = true;
        var timer;
        var timerPaused = true;
        var activeStudentTime;

        updateExamGrades();

        /*
         * Set valenceCutoffs for comments.
         * These represent the maximum value for each valence group.
         * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
         *
         */
        var valenceCutoffs = [0, 3.25, 6.75, 10];
        var valenceLabels = ["Missing", "Poor", "Fair", "Excellent"];
        var valenceLabelPositions = [0, 33, 67, 100];
        var sliderStep = .25;

        /* initialize Sliders */
        var $sliders = $('input.slider').slider({
            tooltip: 'show',
            value: 0,
            step: sliderStep,
            ticks: valenceCutoffs,
            ticks_labels: valenceLabels,
            ticks_position: valenceLabels
        });

        // set 'Grade' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navGrade').attr('class','active');

        /*
         * GENERAL FUNCTIONS
         */

        // Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
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

        // examGrades[] keeps a persistent total of the exam score for each student.
        // Exams without grades have a value of -1, because dealing with null and NaN is annoying.
        // This shouldn't be an issue, as the DB has no notion of exam grades, they're only used here as a shorthand
        // to store and quickly find information about the exam state.
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
                if (totalScore !== null) examGrades[i] = totalScore.toPrecision(3);
                else {
                    examGrades[i] = -1;
                }
            }
        }

        // returns: # of exams graded
        function examsGraded() {
            var graded = 0;
            for (var i = 0; i < examGrades.length; i++) {
                if (examGrades[i] >= 0) graded++;
            }
            return graded;
        }

        // updates a comment locally and saves to server
        function updateAndSaveComment($comment) {
            $comment.removeAttr('readonly');
            var eleIndex = $comment.parents('[id^="element"]').attr('data-element-index');
            var elementId = $comment.parents('[id^="element"]').attr('data-element-id');
            var score = elementScores[activeStudent][eleIndex];
            elementComments[activeStudent][eleIndex] = $comment.val();

            createGradeRequest('element_id', elementId, score, $comment.val());
        }

        /* Creates a key/value array GradeRequest to upload.
         * Params: dataType: the label for thing to be modified
         *      elementId: question or element ID to receive the update
         *      score: the score for the question or element
         *      comment: text of the comment to update. Null unless modifying an element comment.
         * Requests will only include non-null scores and comments
         */
        function createGradeRequest(dataType, dataId, score, comment) {
            var gradeRequest = {};

            gradeRequest[dataType] = dataId;
            if (score !== null) {
                gradeRequest['score'] = score;
            }
            if (comment !== null) {
                gradeRequest['comment_text'] = comment;
            }
            gradeRequest['student_id'] = getActiveStudentId();

            saveDataWithTime(gradeRequest);
        }

        // add time info to the gradeRequest and pass to server
        function saveDataWithTime(gradeRequest) {
            if (!gradeRequest) {
                gradeRequest = {};
                gradeRequest['student_id'] = getActiveStudentId();
            }
            gradeRequest['time'] = examGradingTimes[activeStudent];
            var examId = $('h3').attr('data-exam-id');

            $.ajax({
                url: examId,
                data: gradeRequest,
                type: 'POST',
                success: function() {
                    //console.log('success! ');
                },
                error: function( ) {
                    alert( "Sorry, there was a problem saving this exam!\nPlease try again." );
                }
            });
        }

        function getActiveStudentId() {
            if (activeStudent === null) { return null; }
            else return $('#studentListItem' + activeStudent).attr('data-sid');
        }

        // sets the activeStudentName and studentId fields
        function setSelectedNameAndId() {
            var $student = $('#studentListItem' + activeStudent);
            var name = $student.attr('data-lName') + ", " + $student.attr('data-fName');
            var id = $student.data('student-identifier');
            $("#activeStudentName").text(name);
            $("#activeStudentIdentifier").text(id);
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

        // set the "grades" column in the student roster
        function updateRosterGradeDisplay() {
            for (var i = 0; i < examGrades.length; i++) {
                if (examGrades[i] >= 0) {
                    $('#examGrade' + i).text(examGrades[i]);
                } else {
                    $('#examGrade' + i).text('--');
                }
            }
        }

        // set roster background colors for all students
        // "graded" exams are marked green
        // "ungraded" exams are marked white
        function setStudentBackgroundColors() {
            for (var i = 0; i < examGrades.length; i++) {
                var name = "#studentListItem" + i;
                var item = $('#studentRoster').find(name);
                if (examGrades[i] >= 0) {
                    setRosterBackgroundGraded(item);
                } else {
                    setRosterBackgroundUngraded(item);
                }
            }
        }

        // set student roster background green when an exam has been scored
        function setRosterBackgroundGraded(item) {
            $(item).find('[class^="col"]').css('background-color', '#5cb85c');
            $(item).css('color', 'white');
        }

        // set student roster background white when an exam has reverted to ungraded
        function setRosterBackgroundUngraded(item) {
            $(item).find('[class^="col"]').css('background-color', 'white');
            $(item).css('color', 'black');
        }

        // bulk function updates all the student data fields
        function updateStudentDataArea() {
            updateExamGrades();
            updateGradedRemainingCounter();
            updateRosterGradeDisplay();
            setStudentBackgroundColors();
        }

        // sorts the StudentRoster by the clicked header. Sort order reverses with each press.
        function sortRosterBy(value) {
            var $roster = $('#studentRosterBody');
            $roster.append(
                    $roster.find('[id^="studentListItem"]').sort(function (a, b) {
                        var i = $(a).find('[id^="' + value + '"]');
                        var j = $(b).find('[id^="' + value + '"]');
                        var result;
                        if (value == 'studentName') {
                            result = $(i).text().toUpperCase().localeCompare(
                                    $(j).text().toUpperCase());
                        } else if (value == 'studentIdentifier') {
                            result = parseFloat($(i).text()) - parseFloat($(j).text());
                        } else {
                            var gradeA = examGrades[$(a).attr('data-index')];
                            var gradeB = examGrades[$(b).attr('data-index')];
                            result = gradeA - gradeB;
                        }
                        // flip results if we're sorting in DESC
                        if (!sortAsc) {
                            result *= -1;
                        }
                        return result;
                    })
            );
            sortAsc = !sortAsc;
        }

        // sums elements scores and sets question scores - used for StandardScoring
        function updateStandardScores() {
            //
        }

        // save timer for the active student and update the displays for avg time, total time, and time remaining
        function saveTimer() {
            if (activeStudent === null) return;
            examGradingTimes[activeStudent] = activeStudentTime;
            saveDataWithTime(null);
            updateTimer();
        }

        // loads timer for the active student and sets to running
        function loadTimer() {
            if (activeStudent === null) return;
            clearInterval(timer);
            $('#btnTimerLabel').text('Running');
            $('#btnTimer').attr('class', 'btn btn-success');
            $('#btnTimerIcon').attr('class', 'glyphicon glyphicon-play');
            timerPaused = false;

            // set a new timer to fire every second
            activeStudentTime = examGradingTimes[activeStudent];
            timer = setInterval(function () {
                examGradingTimes[activeStudent] = ++activeStudentTime;
                updateTimer();
            }, 1000);
        }

        // if the timer is paused, enable it
        function resumeTimerIfPaused() {
            if (timerPaused) toggleTimer();
        }

        // toggle timer between running and paused state
        function toggleTimer() {
            if (activeStudent === null) return;
            timerPaused = !timerPaused;
            if (timerPaused) {
                $('#btnTimerLabel').text('Paused');
                $('#btnTimer').attr('class', 'btn btn-warning');
                $('#btnTimerIcon').attr('class', 'glyphicon glyphicon-pause');
                clearInterval(timer);
            } else {
                loadTimer();
            }
        }

        /// Updates the timer for the student and refreshes the display. Called once per second by the timer.
        function updateTimer() {
            var totalTime = 0;
            $.each(examGradingTimes, function (index, value) {
                totalTime += value;
            });
            var avgTime = totalTime / ( (examsGraded() == 0) ? 1 : examsGraded() );
            var estTime = avgTime * numStudents;
            var timeRemaining = estTime - totalTime;

            $('#thisExamTime').text(convertSecondsToHHMMSS(examGradingTimes[activeStudent]));
            $('#avgTime').text(convertSecondsToHHMMSS(avgTime));
            $('#totalTime').text(convertSecondsToHHMMSS(totalTime));
            $('#timeRemaining').text(convertSecondsToHHMMSS(timeRemaining));
        }

        function convertSecondsToHHMMSS(seconds) {
            var date = new Date(null);
            date.setSeconds(seconds);
            if (seconds < 3600) return date.toISOString().substr(14, 5);
            else return date.toISOString().substr(11, 8);
        }

        $(document).ready(function () {

            updateStudentDataArea();
            sortRosterBy('studentName');

            /* When an element slider stops movement, do things */
            $('input.slider').on('slideStop', function (slideEvt) {

                // update element score
                var elementNumber = $(this).closest('[id^="element"]').attr('data-element-index');
                var oldScore = elementScores[activeStudent][elementNumber];
                var newScore = slideEvt.value;

                elementScores[activeStudent][elementNumber] = newScore;

                // update comment text -- only replace text if the score has changed valence regions
                var $parent = $(this).parents('[id^="element"]');
                var $elementComment = $parent.find('textArea');
                if (getValence(newScore) != getValence(oldScore)) {
                    // update comment and save to server
                    var stockResponse = stockComments[elementNumber][getValence(newScore)];
                    $elementComment.val(stockResponse);
                    updateAndSaveComment($elementComment);
                } else {
                    // Jump straight to saving without changing the elementComment
                    var elementId = $(this).closest('[id^="element"]').attr('data-element-id');
                    createGradeRequest('element_id', elementId, newScore, null);
                }

                // If using bell curve scoring, element score affects the total question score.
                // Update question and exam scores
                if (standardScoring) {
                    updateStandardScores();
                }

                // update exam scores and student data area
                updateStudentDataArea();
                resumeTimerIfPaused();
            });

            // Handle question score inputs. When focus is lost, store values, update grades and save timers.
            $('.questionScore').change(function () {
                var qNumber = $(this).attr('data-number');
                var score = parseFloat($(this).val());
                questionScores[activeStudent][qNumber - 1] = score;
                var questionAssId = $(this).attr('data-question-assignment-id');
                if (score >= 0) {
                    createGradeRequest('question_assignment_id', questionAssId, score, null);
                } else {
                    // delete the score
                    var examId = $('h3').attr('data-exam-id');
                    var gradeRequest = {};
                    gradeRequest['questionAssignmentId'] = questionAssId;
                    gradeRequest['studentId'] = getActiveStudentId();
                    $.ajax({
                        url: examId + '/remove',
                        data: gradeRequest,
                        type: 'POST',
                        success: function() {
                            //console.log('success! ');
                        },
                        error: function( ) {
                            alert( "Sorry, there was a problem deleting this score.\nPlease try again." );
                        }
                    });

                }

                updateStudentDataArea();
                //saveTimer();
                resumeTimerIfPaused();
            });


            //  Handle changes to the comment TextArea when focus is lost. Saves data and timers.
            $('[name^="comment"]').focusout(function () {
                if (activeStudent === null) return;
                updateAndSaveComment($(this));
                //saveTimer();
                resumeTimerIfPaused();
            });

            /*
             * A student is selected from the roster - DO LOTS OF STUFF
             */

            $("[id^='studentListItem']").click(function () {
                saveTimer();
                $('#selectPrompt').hide();
                $('#questionArea').show("fast");

                // set the active student
                activeStudent = $(this).attr("data-index");
                setSelectedNameAndId();

                // load the timer area with new values
                loadTimer();

                // set question scores
                $("[id^='questionScore']").each(function (index) {
                    var score = questionScores[activeStudent][index];
                    $(this).val(score);
                });

                // set slider values, if any exist
                if ($sliders) {
                    $.each($sliders, function (index, item) {
                        var score = elementScores[activeStudent][index];
                        item.slider('setValue', score);
                    });
                }

                // set comments
                $('[name^="commentQ"]').each(function (index) {
                    var thisComment = elementComments[activeStudent][index];
                    // if NULL, disable comment text area until a slider is moved.
                    if (elementScores[activeStudent][index] === null) {
                        $(this).prop('readonly', 'true');
                    } else {
                        $(this).val(thisComment);
                    }
                });
            });

            return false;
        });

    </script>
@endsection
