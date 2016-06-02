<!-- the grade exam tool -->
@extends('layouts.master')

@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'Grade an exam')

@section('otherCss')
    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">

@endsection

@section('body')
    <div class="row">
        <!-- Left column holds questions and sliders -->
        <div id="questionAndSliderColumn"
             class="col-md-8 questionAndSliderColumn">

            <h3 data-exam-id="{{ $exam->getId() }}">
                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                {{ $exam->getTerm() }}, {{ $exam->getYear() }} "{{ $exam->getName() }}"
            </h3>

            <h4 id="selectPrompt">Select a student to begin grading</h4>

            <div id="questionArea"
                 class="startHidden">
                <!-- Create one Question Tab for each question -->
                <ul class="nav nav-pills nav-justified">
                    @foreach($questionAssignments as $qAssignment)
                        <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                        <li class='<?php echo $qNumber == 1 ? 'active' : ''; ?>'
                            role="presentation">
                            <a id="tabQuestion{{ $qNumber }}"
                               href="#panelQuestion{{ $qNumber }}"
                               title="Grade question {{ $qNumber }}"
                               data-toggle="tab">
                                Q{{ $qNumber }}</a>
                        </li>
                    @endforeach
                </ul>

                <!-- question panel -->
                @include('grade.partials.question_panel')
            </div>
        </div>

        <!-- Right column holds Roster and Time info -->
        <div id="rosterAndDashboardColumn"
             class="col-md-4 rosterAndDashboardColumn">

            <!-- student name and ID -->
            <form class="form-horizontal">
                @include('grade.partials.active_student_area')
            </form>

            <!-- graded / remaining counters -->
            <p>Graded: <span id="graded">0</span> Remaining: <span id="remaining">0</span></p>

            <!-- save & finish button -->
            <a id="finishButton"
               class="btn btn-success col-lg-12 startHidden"
               href="{{ url('grade/') }}">
                <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>Save & Finish
            </a>

            <!-- student table shows the student roster -->
        @include('grade.partials.student_table')

        <!-- statistics area holds time info -->
            @include('grade.partials.statistics_table')
        </div>
    </div>

@endsection


@section('jsArea')

    <script type="text/javascript">
                <?php
                $stockComments = json_encode($stockComments, JSON_FORCE_OBJECT);
                $studentElementComments = json_encode($studentElementComments, JSON_FORCE_OBJECT);
                $studentElementScores = json_encode($studentElementScores, JSON_FORCE_OBJECT);
                $studentQuestionScores = json_encode($studentQuestionScores, JSON_FORCE_OBJECT);
                $examGradingTimes = json_encode($examGradingTimes, JSON_FORCE_OBJECT);
                $studentGrades = json_encode($studentGrades, JSON_FORCE_OBJECT);
                $numQuestions = count($questionAssignments);
                ?>

        var data = {
                    stockComments: JSON.parse( '{!! $stockComments !!}' ),
                    elementComments: JSON.parse( '{!! $studentElementComments !!}' ),
                    elementScores: JSON.parse( '{!! $studentElementScores !!}' ),
                    questionScores: JSON.parse( '{!! $studentQuestionScores !!}' ),
                    examGradingTimes: JSON.parse( '{!!  $examGradingTimes !!}' ),

                    /**
                     * examGrades[] keeps a persistent total of the exam score for each student.
                     * Exams without grades have a value of -1, because dealing with null and NaN
                     * is unpredictable across js and PHP.
                     * This shouldn't be an issue, as the DB has no notion of exam grades, they're
                     * only used here as a shorthand to store and quickly find information about
                     * the exam state.
                     */
                     examGrades: JSON.parse( '{!! $studentGrades !!}' ),
                     numQuestions: '{{  count( $questionAssignments ) }}',
                     /**
                     * Stores a student's score on a particular element
                     * @param activeStudent
                     * @param elementIndex
                     * @param score
                     */
                    storeElementScore: function ( activeStudent, elementIndex, score ) {
                        this.elementScores[ activeStudent ][ elementIndex ] = score;
                    },

                    /**
                     * Retrieves element score for a student
                     * Original: data.elementScores[ Roster.activeStudent ][ index ];
                     * @param activeStudent
                     * @param elementIndex
                     * @returns {*}
                     */
                    getElementScore: function ( activeStudent, elementIndex ) {
                        return this.elementScores[ activeStudent ][ elementIndex ];
                    },


                    /**
                     * Store the comment text for an element.
                     *
                     * If on the first slider move, the incoming commentText
                     * will be an empty string. That's okay. The initial value
                     * of the comment in the data object is an empty string.
                     * So we save it anyway. The stock comment will be
                     * retrieved on the call to getCommentText.
                     *
                     @param activeStudent
                     * @param elementIndex
                     * @param commentText
                     */
                    storeCommentText: function ( activeStudent, elementIndex, commentText ) {
                        this.elementComments[ activeStudent ][ elementIndex ] = commentText;
                    },


                    /**
                     * Retrieve comment text for a student.
                     * If no customized text is set, then return stockComment.
                     *
                     * Original: data.elementComments[ Roster.activeStudent ][ index ];
                     * @param activeStudent
                     * @param elementIndex
                     * @returns {*}
                     */
                    getCommentText: function ( activeStudent, elementIndex, valence ) {
                        var comment = this.elementComments[ activeStudent ][ elementIndex ];
                        if ( comment == "" ) {
                            return this.stockComments[ elementIndex ][ valence ];
                        }

                        return comment;
                    },


                    /**
                     * Saves a question score for the student
                     * Original: data.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
                     * @param activeStudent
                     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
                     * @param score
                     */
                    storeQuestionScore: function ( activeStudent, questionIndex, score ) {
                        this.questionScores[ activeStudent ][ questionIndex ] = score;

                    },

                    /**
                     * Returns student score for question
                     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
                     * @param activeStudent
                     * @param questionIndex
                     */
                    getQuestionScore: function ( activeStudent, questionIndex ) {
                        return this.questionScores[ activeStudent ][ questionIndex ];
                    },


                    /**
                     * Stores a new time for the student.
                     * Overwrites any existing value.
                     * Original: data.examGradingTimes[ Roster.activeStudent ];
                     */
                    storeStudentGradingTime: function ( activeStudent, activeStudentTime ) {
                        this.examGradingTimes[ activeStudent ] = activeStudentTime;
                    },

                    /**
                     * Increases the stored time for a student by the specified
                     * amount.
                     * Original: data.examGradingTimes[ Roster.activeStudent ];
                     */
                    increaseStudentGradingTime: function ( activeStudent, timeToAdd ) {
                        this.examGradingTimes[ activeStudent ] += timeToAdd;
                    },


                    /**
                     * Original: data.examGradingTimes[ Roster.activeStudent ]
                     * @param activeStudent
                     * @returns {*}
                     */
                    getStudentGradingTime: function ( activeStudent ) {
                        return this.examGradingTimes[ activeStudent ];
                    },


                    /**
                     * Updates the stored total exam score for the student
                     * The first time it runs, it will set the total score to 0
                     * if no questions have been graded.
                     *
                     * Previous version:
                     *
                     *
                     for ( var i = 0; i < data.questionScores.length; i ++ ) {
                    var totalScore = null;
                    data.questionScores[ i ].forEach( function ( gradeEntry ) {
                        if ( gradeEntry !== null && gradeEntry >= 0 ) {
                            if ( totalScore === null ) {
                                totalScore = 0;
                            }
                            totalScore += parseFloat( gradeEntry );
                        }
                    } );
                    if ( totalScore != null ) {
                        data.examGrades[ i ] = totalScore.toPrecision( 3 );
                    }
                    else {
                        data.examGrades[ i ] = - 1;
                    }
                     */
                    updateExamGrade: function ( activeStudent ) {
                        var totalScore = null;
                        for ( var i = 0; i < Object.keys( this.questionScores[ activeStudent ] ).length; i ++ ) {
                            var v = this.questionScores[ activeStudent ][ i ];
                            if ( v != null ) {
                                //at least one question score is non-null
                                //so the total score should be at least 0
                                //first we check whether the totalScore is still null
                                //and set it to 0 if not
                                if ( totalScore === null ) {
                                    totalScore = 0;
                                }
                                //now we can add the question values to it
                                totalScore += parseFloat( v );
                            }
                        }
                        if ( totalScore != null && totalScore >= 0 ) {
                            this.examGrades[ activeStudent ] = totalScore.toPrecision( 3 );
                        } else {
                            this.examGrades[ activeStudent ] = - 1;
                        }
                    },


                    /**
                     * Returns true if at least one question has received
                     * a score for the student.
                     */
                    isGraded: function ( activeStudent ) {
                        this.updateExamGrade( activeStudent )
                        if ( this.examGrades[ activeStudent ] != "Letter grade" && this.examGrades[ activeStudent ] >= 0 ) {
                            return true;
                        }
                        return false;
                    },


                    /**
                     * Returns the number of exams that have been graded
                     */
                    getNumberGraded: function () {
                        var graded = 0;
                        if ( typeof this.examGrades != 'undefined' ) {
                            for ( var i = 0; i < Object.keys( this.examGrades ).length; i ++ ) {
                                this.updateExamGrade( i );
                                //this will be the string 'letter grade' if
                                //no grade has been entered. Thus we check
                                //whether it is a number 0 or greater
                                if ( this.examGrades[ i ] >= 0 ) graded ++;
                            }
                        }
                        return graded;
                    },

                    /**
                     * Returns the total number of exams
                     *
                     * TODO Store this value after first run
                     *
                     * @returns {number|Number}
                     */
                    getTotalExams: function () {
                        if ( typeof this.examGrades == 'undefined' ) {
                            var total = 0;
                        } else {
                            var total = Object.keys( this.examGrades ).length;
                        }

                        return total;
                    }


                };

        window.console.log( data );
        var activeTab = 'navGrade';

    </script>

    <script type="text/javascript" src="{{ asset('js/grade-exam-package.js') }}"></script>

@endsection
