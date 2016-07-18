<?php
$navTab = 'gradeNav';
Auth::loginUsingId(1);
$exam = factory(\App\Exam::class)->make();

$students = factory(\App\Student::class, 5)->make();
$questionAssignments = \App\QuestionAssignment::where('exam_id', 2)->get();
$elements = factory(\App\Element::class, 5)->create();
$numElements = 5;

$maxQuestionScores =
        [
                1 => (float) 100,
                2 => (float) 100,
        ];
$allElements = [];
for ( $i = 0; $i < $numElements; $i++ )
{
    $allElements[] = factory(App\Element::class)->create();
}

$stockComments =
        [
                0 =>
                        [
                                0 => 'e0 missing',
                                1 => 'e0 poor',
                                2 => 'e0 fair',
                                3 => 'e0 excellent'
                        ],
                1 =>
                        [
                                0 => 'e1 missing',
                                1 => 'e1 poor',
                                2 => 'e1 fair',
                                3 => 'e1 excellent'
                        ],
        ];
$examGradingTimes =
        array(
                0 => 0,
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0
        );
$studentElementScores = [
        0 =>
                array(
                        0 => null,
                        1 => null
                ),
        1 =>
                array(
                        0 => null,
                        1 => null,
                        2 => null,
                ),
];
$studentElementComments =
        [
                0 =>
                        array(
                                0 => '',
                                1 => '',
                                2 => '',
                        ),
                1 => array(
                        0 => '',
                        1 => '',
                        2 => ''
                )
        ];
$studentQuestionScores = [
        0 => array(
                0 => null,
                1 => null,
                2 => null,
        ),
        1 =>
                array(
                        0 => null,
                        1 => null,
                        2 => null,
                ),
];
$studentGrades = array(
        0 => 'Letter grade',
        1 => 'Letter grade',
        2 => 'Letter grade',
);

$stockComments = json_encode($stockComments, JSON_FORCE_OBJECT);
$studentElementComments = json_encode($studentElementComments, JSON_FORCE_OBJECT);
$studentElementScores = json_encode($studentElementScores, JSON_FORCE_OBJECT);
$studentQuestionScores = json_encode($studentQuestionScores, JSON_FORCE_OBJECT);
$examGradingTimes = json_encode($examGradingTimes, JSON_FORCE_OBJECT);
$studentGrades = json_encode($studentGrades, JSON_FORCE_OBJECT);
$numQuestions = count($questionAssignments);

$qNumber = 1;
$eNumber = 1;
$elementIndex = 1;


?>

@extends('layouts.master')
@section('otherCss')
    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('body')
    <div id="gradeExamPage">
        <div class="row currentStudent">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <current-student-area></current-student-area>
            </div>
            <div class="col-lg-2"></div>
        </div>


        <div class="row elementInput">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <element-input :element-number="1"
                               :element-index="1"
                               element-id="1"
                               element-name="testname"
                               :question-number="1"></element-input>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="row studentRoster">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <table>
                    <tr is="student-list-item"
                        :student-index="0"
                        first-name="Jill"
                        last-name="Jillenson"
                        student-identifier="123456789"
                        student-id="1"
                    ></tr>
                    <tr is="student-list-item"
                        :student-index="1"
                        first-name="Sue"
                        last-name="Suenson"
                        student-identifier="0123456789"
                        student-id="2"
                    ></tr>
                </table>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
@endsection

@section('jsArea')
    <script src="{{asset('js/data.js')}}"></script>

    <script>
        var activeTab = 'gradeNav';
        var store = new Data();
        store.activeStudent = 0;
        store.loadStockComments({!! $stockComments !!});
        store.loadElementComments( {!! $studentElementComments !!});
        store.loadElementScores({!! $studentElementScores !!});
        store.loadQuestionScores( {!! $studentQuestionScores !!});
        store.loadGradingTimes( {!!  $examGradingTimes !!} );
        store.loadExamGrades({!! $studentGrades !!} );
        store.loadNumberQuestions({!! $numQuestions !!});
    </script>

    <script src="{{ asset('js/dev/grade-vue.js') }}"></script>
@endsection