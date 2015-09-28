<!-- the grade exam tool -->
@extends('layouts.master')

@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'Grade an exam')
@section('cssLinks')

@endsection

@section('body')
    <style>


    </style>
    <div class="container">
        <div class="row">
            <!-- Left column holds questions and sliders -->
            <div class="col-md-8">
                <h3 data-exam-id="{{ $exam->getId() }}"><span class="glyphicon glyphicon-list-alt"
                                                              aria-hidden="true"></span>
                    {{ $exam->getTerm() }}, {{ $exam->getYear() }} "{{ $exam->getName() }}" </h3>
                <h4 id="selectPrompt">Select a student to begin grading</h4>

                <div id="questionArea" style="display: none">
                    <!-- Create one Question Tab for each question -->
                    <ul class="nav nav-pills nav-justified">
                        @foreach($questionAssignments as $qAssignment)
                            <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                            <li <?php if ($qNumber == 1) {
                                echo "class='active'";
                            } ?> role="presentation">
                                <a href="#panelQuestion{{ $qNumber }}" title="Grade question {{ $qNumber }}" data-toggle="tab">
                                    Q{{ $qNumber }}</a></li>
                        @endforeach
                    </ul>
                    <!-- question panel -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="tab-content">
                                <?php $elementIndex = 0; ?>
                                @foreach($questionAssignments as $qAssignment)
                                    <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                                    <div id="panelQuestion{{ $qNumber }}" data-question-number="{{ $qNumber }}" class="tab-pane fade
                                            <?php if ($qNumber === 1) {
                                        echo "in active";
                                    } ?>">
                                        {{--<div class="form-horizontal" role="form">--}}
                                        <div class="row">
                                            <div class="col-md-9">
                                                <!-- question Name -->
                                                <h4 id="questionName">Question #{{ $qNumber }}:
                                                    "{{ $qAssignment->getQuestionName() }}"</h4>
                                            </div>
                                            <!-- question Score -->
                                            <form class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <label class="col-md-1 control-label"
                                                           style="padding-right: 2px; padding-left: 0px;"
                                                           for="questionScore{{ $qNumber }}">
                                                        Score:</label>
                                                    <div class="col-md-1" style="padding: 0px;">
                                                        <input class="form-control pull-right" type="number" min="0"
                                                               max="{{ $maxQuestionScores[$qNumber] }}"
                                                               style="width: 4.5em; padding-right: 2px;"
                                                               data-number="{{ $qNumber }}"
                                                               data-question-assignment-id="{{ $qAssignment->getId() }}"
                                                               id="questionScore{{ $qNumber }}"/>
                                                    </div>
                                                    <div class="col-md-1 control-label" style="text-align: left;" >
                                                        <b>/ {{  $maxQuestionScores[$qNumber] }}</b>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- element area holds all sliders and comments for this question -->
                                        <div class="list-group">

                                            {{-- add element panels --}}
                                            <?php $elements = $allElements[$qNumber - 1];
                                            $eNumber = 1;
                                            while ($eNumber <= count($elements) ) { ?>
                                            @include('grade.element_panel')
                                            <?php $elementIndex++; $eNumber++; } ?>

                                            {{-- add some text if no elements for this question --}}
                                            @if( count($elements) == 0 )
                                                <div class="list-group-item" style="background-color: #DDDDDD;">
                                                    <i>No elements for this question</i>
                                                </div>
                                            @endif
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
                            <span class="glyphicon glyphicon-pencil" title="Click to hide student names"
                                  style="cursor: pointer;"
                                  onclick="toggleNameVisibility()"> </span>
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
                <a class="btn btn-success col-md-12" href="{{ url('grade/') }}" id="finishButton"
                   style="display: none;">
                    <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>Save & Finish
                </a>
                <!-- student table shows the student roster -->
                @include('grade.student_table')
                        <!-- statistics area holds time info -->
                @include('grade.statistics_table')
            </div>
        </div>
    </div>
@endsection


@section('jsArea')

    <link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet">
    <script type='text/javascript' src="{{ asset('inc/js/bootstrap-slider.js') }}"></script>
    <script type="text/javascript">

        var stockComments = <?= json_encode($stockComments) ?>;

        var elementComments = <?= json_encode($studentElementComments) ?>;
        var elementScores = <?= json_encode($studentElementScores) ?>;
        var questionScores = <?= json_encode($studentQuestionScores) ?>;
        var examGradingTimes = <?= json_encode($examGradingTimes) ?>;
        var examGrades = [];

        var numStudents = {{ count($students) }};
        var numQuestions = {{ count($questionAssignments) }};

        var activeStudent = null;
        var standardScoring = false;
        var sortAsc = true;
        var timer;
        var timerPaused = true;
        var studentNamesVisible = true;
        var nameHiddenString = "Name Hidden"; // text to show when student names are invisible
        var noActiveStudentString = "No Student Selected";
        var activeStudentTime;

        updateExamGrades();

        /*
         * Set valenceCutoffs for comments --  these represent the maximum value for each valence group.
         * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
         *
         */
        var valenceCutoffs = [0, 3.25, 6.75, 10];
        var valenceLabels = ["Missing", "Poor", "Fair", "Excellent"];
        var valenceLabelPositions = [0, 33, 67, 100];
        var sliderStep = .25;

        /* initialize Sliders with valenceCutoffs */
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
        $('#navGrade').attr('class', 'active');

        /*
         * GENERAL FUNCTIONS
         */

        // Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
        // i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
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
        // Exams without grades have a value of -1, because dealing with null and NaN is unpredictable across js and PHP.
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
                        totalScore += parseFloat(gradeEntry);
                    }
                });
                if (totalScore != null) examGrades[i] = totalScore.toPrecision(3);
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
        // this is broken out from createGradeRequest() as sometimes only the time will be saved
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
                success: function () {
                    //console.log('success! ');
                },
                error: function () {
                    alert("Sorry, there was a problem saving this exam!\nPlease try again.");
                }
            });
        }

        function getActiveStudentId() {
            if (activeStudent === null) {
                return null;
            }
            else return $('#studentListItem' + activeStudent).attr('data-sid');
        }

        // sets the activeStudentName and studentId fields
        function setSelectedNameAndId() {
            var $student = $('#studentListItem' + activeStudent);
            // only show names if set to visible
            var name = nameHiddenString;
            if (studentNamesVisible) {
                name = $student.attr('data-lName') + ", " + $student.attr('data-fName');
            }
            // if no student has been selected, always display noActiveStudentString
            if (!activeStudent) {
                name = noActiveStudentString;
            }
            var id = $student.data('student-identifier');
            $("#activeStudentName").text(name);
            $("#activeStudentIdentifier").text(id);
        }

        // When the pencil icon is selected, toggle visibility of roster names and selected name area
        function toggleNameVisibility() {
            studentNamesVisible = !studentNamesVisible;
            $('[id^="studentListItem"]').each( function() {
                var nameToDisplay = nameHiddenString;
                if (studentNamesVisible) {
                   nameToDisplay = $(this).attr('data-lName') + ", " + $(this).attr('data-fName');
                }
                $(this).find('[id^="studentName"]').text(nameToDisplay);
            });
            setSelectedNameAndId();
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
                    // the student has no grade (val of -1)
                    $('#examGrade' + i).text('--');
                }
            }
        }

        // set background colors in the student roster
        // "graded" exams are marked green
        // "ungraded" exams are marked white
        function setStudentBackgroundColors() {
            for (var i = 0; i < examGrades.length; i++) {
                var name = "#studentListItem" + i;
                var item = $('#studentRoster').find(name);
                if (examGrades[i] >= 0) {
                    setRosterBackgroundColor(item, '#5cb85c', 'white');
                } else {
                    setRosterBackgroundColor(item, 'white', 'black');
                }
            }
        }

        function setActiveStudentBackgroundColor() {
            if (activeStudent) {
                setStudentBackgroundColors(); // reset prev. selected student to it's color (white or green)
                var item = $('#studentRoster').find('#studentListItem' + activeStudent); // set the activeStudent
                setRosterBackgroundColor(item, '#337ab7', 'white');
            }
        }

        // set color for a student roster row
        function setRosterBackgroundColor(item, backColor, textColor) {
            $(item).find('[class^="col"]').css('background-color', backColor);
            $(item).css('color', textColor);
        }

        // bulk function updates all the dependent data in the roster area.
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
                        if (value == 'studentName' || value == 'studentIdentifier') {
                            result = $(i).text().toUpperCase().localeCompare(
                                    $(j).text().toUpperCase());
                        } else {
                            // sort by exam grade
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

        // sums elements scores and sets question scores - will be used for StandardScoring
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

        // load timer for the active student and sets state to running
        function loadTimer() {
            if (activeStudent === null) return;
            clearInterval(timer);
            $('#btnTimerLabel').text('Running');
            $('#btnTimer').attr('class', 'btn btn-success');
            $('#btnTimerIcon').attr('class', 'glyphicon glyphicon-play');
            timerPaused = false;

            // set a new timer to fire every second. Update examGradingTimes[]
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

        /// Updates the statistics area. Called once per second by the timer.
        function updateTimer() {
            var totalTime = 0;
            $.each(examGradingTimes, function (index, value) {
                totalTime += value;
            });
            var avgTime = totalTime / ( (examsGraded() == 0) ? 1 : examsGraded() );
            var estTime = avgTime * numStudents;
            var timeRemaining = estTime - totalTime;

            if (activeStudent) {
                $('#thisExamTime').text(convertSecondsToHHMMSS(examGradingTimes[activeStudent]));
            }
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
            updateTimer();

            /* When an element slider stops movement, do things */
            $('input.slider').on('slideStop', function (slideEvt) {

                // update the element's score visually and in elementScores[]
                var elementNumber = $(this).closest('[id^="element"]').attr('data-element-index');
                var oldScore = elementScores[activeStudent][elementNumber];
                var newScore = slideEvt.value;

                elementScores[activeStudent][elementNumber] = newScore;

                // update comment text -- only replace text if the score has changed valence regions
                var $parent = $(this).parents('[id^="element"]');
                var $elementComment = $parent.find('textArea');
                if (getValence(newScore) != getValence(oldScore)) {
                    // Score is in a new valence region.
                    // plug in the appropriate comment text and save to DB
                    var stockResponse = stockComments[elementNumber][getValence(newScore)];
                    $elementComment.val(stockResponse);
                    updateAndSaveComment($elementComment);
                } else {
                    // Score is in the same valence region.
                    // Jump straight to saving without changing the elementComment
                    var elementId = $(this).closest('[id^="element"]').attr('data-element-id');
                    createGradeRequest('element_id', elementId, newScore, null);
                }

                // If using bell curve (standardScoring), element score affects the total question score, so update
                if (standardScoring) {
                    updateStandardScores();
                }

                // update exam scores and student data area
                updateStudentDataArea();
                resumeTimerIfPaused();
            });

            // Handle question score inputs. When focus is lost, store values, update grades and save timers.
            $('[id^="questionScore"]').change(function () {
                var qNumber = $(this).attr('data-number');
                var score = parseFloat($(this).val());
                var maxScore = parseFloat($(this).attr('max'));
                if (score > maxScore) {
                    score = maxScore;
                    $(this).val(maxScore);
                }
                questionScores[activeStudent][qNumber - 1] = score;
                var questionAssId = $(this).attr('data-question-assignment-id');

                if (score >= 0) {
                    createGradeRequest('question_assignment_id', questionAssId, score, null);
                } else {
                    // delete the score
                    var examId = $('h3').attr('data-exam-id');
                    var gradeRequest = {};
                    gradeRequest['question_assignment_id'] = questionAssId;
                    gradeRequest['student_id'] = getActiveStudentId();
                    $.ajax({
                        url: examId + '/remove',
                        data: gradeRequest,
                        type: 'POST',
                        success: function () {},
                        error: function(data){
                            // Error...
                            //var errors = $.parseJSON(data.responseText);
                            //console.log(errors);
                            alert('There was a problem deleting this question score');
                        }
                    });

                }

                updateStudentDataArea();
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
                setActiveStudentBackgroundColor();

                // load the timer area with new values
                loadTimer();

                // set question scores
                $("[id^='questionScore']").each(function (index) {
                    var score = questionScores[activeStudent][index];
                    $(this).val(score);
                });

                // set slider values, if any exist
                if ($sliders) {
                    $sliders.each(function (index, item) {
                        var score = elementScores[activeStudent][index];
                        $(item).slider('setValue', score);
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
