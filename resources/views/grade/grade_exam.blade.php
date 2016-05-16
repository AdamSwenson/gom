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
        <div class="col-md-8 questionAndSliderColumn"
                {{--style="width-max: 700px;"--}}
        >
            <h3 data-exam-id="{{ $exam->getId() }}"><span class="glyphicon glyphicon-list-alt"
                                                          aria-hidden="true"></span>
                {{ $exam->getTerm() }}, {{ $exam->getYear() }} "{{ $exam->getName() }}" </h3>

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
        <div class="col-md-4 rosterAndDashboardColumn"
                {{--style="max-width: 550px; min-width: 340px;"--}}
        >
            <!-- student name and ID -->
            <form class="form-horizontal">
                <div class="form-group activeStudentInput">
                    <div class="col-xs-7" style="padding-right: 0px;">
                        <label for="activeStudentName">
                            <span id="nameVisibilityControl"
                                  class="glyphicon glyphicon-pencil"
                                  title="Click to hide student names"
                                  style="cursor: pointer;"
                            > </span>
                        </label>
                        <input id="activeStudentName"
                               class="typeahead full-width"
                               type="text"
                               placeholder="No Student Selected"
                               style="width: 160px;">
                    </div>
                    <div class="col-xs-5" style="padding-right: 0px;">
                        <label for="activeStudentIdentifier">ID</label>
                        <input class="typeahead full-width"
                               type="text"
                               id="activeStudentIdentifier"
                               placeholder="--"
                               style="width: 90px;"
                        >
                    </div>
                </div>
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
        {{--var myvar = "adding new errors";--}}


        {{--var stockComments = JSON.parse( '{!! json_encode($stockComments, JSON_FORCE_OBJECT) !!}' );--}}
        {{--window.console.log( 'stock', stockComments );--}}

        {{--var elementComments = JSON.parse( '{!! json_encode($studentElementComments, JSON_FORCE_OBJECT) !!}' );--}}
        {{--window.console.log( 'elcom', elementComments );--}}

        {{--var elementScores = JSON.parse( '{!! json_encode($studentElementScores, JSON_FORCE_OBJECT) !!}' );--}}
        {{--window.console.log( 'elscore', elementScores );--}}

        {{--var questionScores = JSON.parse( '{!! json_encode($studentQuestionScores, JSON_FORCE_OBJECT) !!}' );--}}
        {{--window.console.log( 'qscore', questionScores );--}}

        {{--var examGradingTimes = JSON.parse( '{!! json_encode($examGradingTimes, JSON_FORCE_OBJECT) !!}' );--}}
        {{--window.console.log( 'gt', examGradingTimes );--}}

        {{--var examGrades = JSON.parse( '{!! json_encode($studentGrades, JSON_FORCE_OBJECT) !!}' );--}}
        {{--window.console.log( 'grades', examGrades );--}}

        {{--var numQuestions = '{{  count( $questionAssignments ) }}';--}}
        {{--// for setting 'Grade' tab as active--}}



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

        window.console.log(data);
        var activeTab = 'navGrade';

    </script>

    <script type="text/javascript" src="{{ asset('js/grade-exam-package.js') }}"></script>

@endsection
