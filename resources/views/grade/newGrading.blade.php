<?php
$grades = App\Repositories\Grade\GradeFactory::gradeJson();
?>

@extends('layouts.master')
@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'Grade an exam')

@section('otherCss')
    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/grade-exam-data.js')}}"></script>
@endsection

@section('body')
    <div id="gradeExamPage" class="row mainBodyLocator">
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
                @include('grade.new.partials.question_panel')
            </div>
        </div>

        <!-- Right column holds Roster and Time info -->
        <div id="rosterAndDashboardColumn"
             class="col-md-4 rosterAndDashboardColumn">

            <!-- student name and ID -->
            <current-student-area></current-student-area>

            <!-- graded / remaining counters -->
            <dashboard-counts finished-link="{{ url('grade/') }}"></dashboard-counts>

            <!-- student table shows the student roster -->
            <div class="panel panel-default">
                <student-table></student-table>
            </div>

            <!-- statistics area holds time info -->
            <dashboard-timer></dashboard-timer>

        </div>
    </div>

@endsection

@section('jsArea')
    {{--<script src="{{ asset('/js/dev/new-data-package.js')}}"></script>--}}

    <script type="text/javascript">
                <?php
                $studentElementComments = json_encode($studentElementComments, JSON_FORCE_OBJECT);
                $studentElementScores = json_encode($studentElementScores, JSON_FORCE_OBJECT);
                $studentQuestionScores = json_encode($studentQuestionScores, JSON_FORCE_OBJECT);
                $examGradingTimes = json_encode($examGradingTimes, JSON_FORCE_OBJECT);
                $studentGrades = json_encode($studentGrades, JSON_FORCE_OBJECT);
                $maxScores = json_encode($maxQuestionScores, JSON_FORCE_OBJECT);
                $numQuestions = count($questionAssignments);
                ?>

        var activeTab = 'navGrade';
//                GOM.store.activeStudent = 0;
        var store = new Data();
                store.activeStudent = 0;
//                var store = GOM.store;

        store.setExamId({!! $exam->id !!});
        store.loadStockComments({!! $stockCommentsJson !!});
        store.loadElementComments( {!! $studentElementComments !!});
        store.loadElementScores({!! $studentElementScores !!});
        store.loadQuestionScores( {!! $studentQuestionScores !!});
        store.loadGradingTimes( {!!  $examGradingTimes !!} );
        store.loadExamGrades({!! $studentGrades !!} );
        store.loadNumberQuestions({!! $numQuestions !!});
        store.loadMaxQuestionScores({!! $maxScores !!});
        store.loadStudents({!! $studentsJson !!});
        store.loadQuestions({!! $questionsJson !!})
        store.loadGrades({!! $gradesJson !!})
    </script>

    <script src="{{ asset('js/dev/grade-vue.js') }}"></script>
@endsection