<?php
//$navTab = 'gradeNav';
//Auth::loginUsingId(1);
//$exam = factory(\App\Exam::class)->create();

//$students = factory(\App\Student::class, 5)->make();
//$questionAssignments = \App\QuestionAssignment::where('exam_id', 2)->get();
//$elements = factory(\App\Element::class, 5)->create();
//$numElements = 5;
//$numQuestions = count($questionAssignments);
//
//$grades = [];
//foreach ( $letterGrades as $g )
//{
//    $grades[] = ['displayValue' => $g['display_value'], 'calcValue' => $g['calc_value']];
//}
//
//$maxQuestionScores =
//        [
//                0 => (float) 100,
//                1 => (float) 100,
//                2 => (float) 100,
//        ];
//
//$allElements = [];
//for ( $j = 0; $j < $numQuestions; $j++ )
//{
//    $allElements[ $j ] = [];
//
//    for ( $i = 0; $i < $numElements; $i++ )
//    {
//        $allElements[ $j ][ $i ] = factory(App\Element::class)->create();
//    }
//}
//$stockComments =
//        [
//                0 =>
//                        [
//                                0 => 'e0 missing',
//                                1 => 'e0 poor',
//                                2 => 'e0 fair',
//                                3 => 'e0 excellent'
//                        ],
//                1 =>
//                        [
//                                0 => 'e1 missing',
//                                1 => 'e1 poor',
//                                2 => 'e1 fair',
//                                3 => 'e1 excellent'
//                        ],
//        ];
//$examGradingTimes =
//        array(
//                0 => 0,
//                1 => 0,
//                2 => 0,
//                3 => 0,
//                4 => 0
//        );
//$studentElementScores = [
//        0 =>
//                array(
//                        0 => null,
//                        1 => null
//                ),
//        1 =>
//                array(
//                        0 => null,
//                        1 => null,
//                        2 => null,
//                ),
//];
//$studentElementComments =
//        [
//                0 =>
//                        array(
//                                0 => '',
//                                1 => '',
//                                2 => '',
//                        ),
//                1 => array(
//                        0 => '',
//                        1 => '',
//                        2 => ''
//                )
//        ];
//$studentQuestionScores = [
//        0 => array(
//                0 => null,
//                1 => null,
//                2 => null,
//        ),
//        1 =>
//                array(
//                        0 => null,
//                        1 => null,
//                        2 => null,
//                ),
//];
//$studentGrades = array(
//        0 => 'Letter grade',
//        1 => 'Letter grade',
//        2 => 'Letter grade',
//);
//
//$stockComments = json_encode($stockComments, JSON_FORCE_OBJECT);
//$studentElementComments = json_encode($studentElementComments, JSON_FORCE_OBJECT);
//$studentElementScores = json_encode($studentElementScores, JSON_FORCE_OBJECT);
//$studentQuestionScores = json_encode($studentQuestionScores, JSON_FORCE_OBJECT);
//$examGradingTimes = json_encode($examGradingTimes, JSON_FORCE_OBJECT);
//$studentGrades = json_encode($studentGrades, JSON_FORCE_OBJECT);
//
//
//$maxQuestionScores = json_encode($maxQuestionScores, JSON_FORCE_OBJECT);
//
//$qNumber = 1;
//$eNumber = 1;
//$elementIndex = 1;
//$letterGrades = App\Repositories\Grade\GradeFactory::$grades;
//$grades = [];
//foreach ( $letterGrades as $g )
//{
//    $grades[] = ['displayValue' => $g['display_value'], 'calcValue' => $g['calc_value']];
//}
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
    New
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
                @include('development.partials.question_panel')
            </div>
        </div>

        <!-- Right column holds Roster and Time info -->
        <div id="rosterAndDashboardColumn"
             class="col-md-4 rosterAndDashboardColumn">

            <!-- student name and ID -->
            <form class="form-horizontal">
                <current-student-area></current-student-area>
            </form>

            <!-- graded / remaining counters -->
            <dashboard-counts finished-link="{{ url('grade/') }}"></dashboard-counts>

            <!-- student table shows the student roster -->
        @include('development.partials.student_table')

        <!-- statistics area holds time info -->
            <dashboard-timer></dashboard-timer>

        </div>
    </div>

    {{--<div id="gradeExamPage">--}}
    {{--<div class="row currentStudent">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<current-student-area></current-student-area>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}


    {{--<div class="row elementInput">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<element-input :element-number="1"--}}
    {{--:element-index="1"--}}
    {{--element-id="1"--}}
    {{--element-name="testname"--}}
    {{--:question-number="1"></element-input>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}

    {{--<div class="row studentRoster">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<table>--}}
    {{--<tr is="student-list-item"--}}
    {{--:student-index="0"--}}
    {{--first-name="Jill"--}}
    {{--last-name="Jillenson"--}}
    {{--student-identifier="123456789"--}}
    {{--student-id="1"--}}
    {{--></tr>--}}
    {{--<tr is="student-list-item"--}}
    {{--:student-index="1"--}}
    {{--first-name="Sue"--}}
    {{--last-name="Suenson"--}}
    {{--student-identifier="0123456789"--}}
    {{--student-id="2"--}}
    {{--></tr>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}


    {{--<div class="row questionScore">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<question-score--}}
    {{--v-ref:test-object--}}
    {{--:question-index="0"--}}
    {{--question-number="1"></question-score>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}

    {{--<div class="row letterGrade">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<letter-grade-button--}}
    {{--:question-index="0"--}}
    {{--question-number="1"--}}
    {{--:grades="{{ $grades }}"></letter-grade-button>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}

    {{--<div class="row dashboard">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<dashboard-timer></dashboard-timer>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}

    {{--<div class="row dashboard">--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--<div class="col-lg-8">--}}
    {{--<dashboard-counts></dashboard-counts>--}}
    {{--</div>--}}
    {{--<div class="col-lg-2"></div>--}}
    {{--</div>--}}

    {{--</div>--}}
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
                $maxScores = json_encode($maxQuestionScores, JSON_FORCE_OBJECT);
                $numQuestions = count($questionAssignments);

//                $st = [];
//                foreach ( $students as $student )
//                {
//                    $st[] = [
//                            'studentId'         => $student->getId(),
//                            'studentIdentifier' => $student->getStudentId(),
//                            'firstName'         => $student->getStudentFName(),
//                            'lastName'          => $student->getStudentLName()
//                    ];
//                }
//                $studentJson = json_encode($st, JSON_FORCE_OBJECT);
                ?>

        var activeTab = 'navGrade';

        //        var activeTab = 'gradeNav';
        var store = new Data();
        store.activeStudent = 0;
        store.setExamId({!! $exam->id !!});
        store.loadStockComments({!! $stockComments !!});
        store.loadElementComments( {!! $studentElementComments !!});
        store.loadElementScores({!! $studentElementScores !!});
        store.loadQuestionScores( {!! $studentQuestionScores !!});
        store.loadGradingTimes( {!!  $examGradingTimes !!} );
        store.loadExamGrades({!! $studentGrades !!} );
        store.loadNumberQuestions({!! $numQuestions !!});
        store.loadMaxQuestionScores({!! $maxScores !!});
        store.loadStudents({!! $studentsJson !!});
        store.loadQuestions({!! $questionsJson !!})
    </script>

    <script src="{{ asset('js/dev/grade-vue.js') }}"></script>
@endsection