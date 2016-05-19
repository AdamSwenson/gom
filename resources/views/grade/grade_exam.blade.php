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
                    examGrades: JSON.parse( '{!! $studentGrades !!}' ),
                    numQuestions: '{{  count( $questionAssignments ) }}'
                };

        window.console.log( data );
        var activeTab = 'navGrade';

    </script>

    <script type="text/javascript" src="{{ asset('js/grade-exam-package.js') }}"></script>
    <script>
        //    if(typeof $ == 'undefined'){
        //        alert('s1');
        //    }
        //    if(typeof jQuery == 'undefined'){
        //        alert('s2');
        //    }
        //    if(typeof $ != 'undefined'){
        //        alert('j1');
        //    }
        //    if(typeof jQuery != 'undefined'){
        //        alert('j2');
        //    }
    </script>
@endsection
