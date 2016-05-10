<!-- the grade exam tool -->
@extends('layouts.master')

@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'Grade an exam')
@section('otherCss')
    {{--<link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css" >--}}
    <link href="{{ asset('css/grade-package.css') }}"  rel="stylesheet" type="text/css" >
@endsection

@section('body')
    <div class="row">
        <!-- Left column holds questions and sliders -->
        <div class="col-md-8" style="width-max: 700px;">
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
                            <a id="tabQuestion{{ $qNumber }}"
                               href="#panelQuestion{{ $qNumber }}"
                               title="Grade question {{ $qNumber }}"
                               data-toggle="tab">
                                Q{{ $qNumber }}</a></li>
                    @endforeach
                </ul>
                <!-- question panel -->
                <div id="questionPanel"
                     class="panel panel-default questionPanel">
                    <div class="panel-body">
                        <div class="tab-content">
                            <?php $elementIndex = 0; ?>
                            @foreach($questionAssignments as $qAssignment)
                                <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                                <div id="panelQuestion{{ $qNumber }}"
                                     data-question-number="{{ $qNumber }}"
                                     class="tab-pane fade
                                            <?php if ($qNumber === 1) {
                                    echo "in active";
                                } ?>">
                                    {{--<div class="form-horizontal" role="form">--}}
                                    <div class="row">
                                        <div class="col-xs-7">
                                            <!-- question Name -->
                                            <h4 id="questionName">Question #{{ $qNumber }}:
                                                "{{ $qAssignment->getQuestionName() }}"</h4>
                                        </div>
                                        <!-- question Score -->
                                        <div class="col-xs-2">
                                            @include('grade.partials.letter_grade_button')
                                        </div>
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label class="col-xs-1 control-label"
                                                       style="padding-right: 2px; padding-left: 0px;"
                                                       for="questionScore{{ $qNumber }}">
                                                    Score:</label>

                                                <div class="col-xs-1" style="padding: 0px;">
                                                    <input class="form-control pull-right" type="number" min="0"
                                                           max="{{ $maxQuestionScores[$qNumber] }}"
                                                           style="width: 4.5em; padding-right: 2px;"
                                                           data-number="{{ $qNumber }}"
                                                           data-question-assignment-id="{{ $qAssignment->getId() }}"
                                                           id="questionScore{{ $qNumber }}"/>
                                                </div>
                                                <div class="col-xs-1 control-label" style="text-align: left;">
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
                                        @include('grade.partials.element_panel')
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
        <div class="col-md-4" style="max-width: 550px; min-width: 340px;">
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
        var myvar = "adding new errors";
        var stockComments = <?= json_encode($stockComments) ?>;
{{--        JSON.parse('{!!--}}
        var elementComments = <?= json_encode($studentElementComments) ?>;
        var elementScores = <?= json_encode($studentElementScores) ?>;
        var questionScores = <?= json_encode($studentQuestionScores) ?>;
        var examGradingTimes = <?= json_encode($examGradingTimes) ?>;
        var examGrades = <?= json_encode($studentGrades) ?>;

        var numQuestions = {{  count( $questionAssignments ) }};
        // for setting 'Grade' tab as active
        var activeTab = 'navGrade';

        </script>

<script type="text/javascript" src="{{ asset('js/grade-exam-package.js') }}"></script>

@endsection
