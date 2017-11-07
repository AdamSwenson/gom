<?php
use App\Element;
use App\Exam;
use App\QuestionAssignment;
use App\Student;
use Illuminate\Support\Facades\Auth;

$testedScriptPath = '';
//$testedScriptPath = asset('js/grade-exam1-package.js');
$testingScriptPath = '';
$navTab = 'gradeNav';
Auth::loginUsingId(1);
$exam1 = factory(Exam::class)->make();

$students = factory(Student::class, 5)->make();
$questionAssignments = QuestionAssignment::where('exam_id', 2)->get();

$maxQuestionScores =
        [
                1 => (float) 100,
                2 => (float) 100,
        ];
$allElements =
        [
                0 => Element::all()->take(5),

                1 => Element::all()->take(5),
                2 => Element::all()->take(5),
                3 => Element::all()->take(5),
                4 => Element::all()->take(5),
        ];
$stockComments =
        [
                0 =>
                        [
                                0 => 'comment101BodyText',
                                1 => 'comment102BodyText',
                                2 => 'comment103BodyText',
                                3 => 'comment104BodyText'
                        ],
                1 =>
                        [
                                0 => 'comment105BodyText',
                                1 => 'comment106BodyText',
                                2 => 'comment107BodyText',
                                3 => 'comment108BodyText'
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
$elements = factory(Element::class, 2)->create();


?>
@extends('tests.qunit')

@section('fixture')
    @include('grade.partials.element_panel')
@endsection

@section('jsScripts')
    @include('grade.partials.element_panel')
    <script type="text/javascript" src="{{ asset('js/grade-exam1-data.js') }}" data-cover></script>

    <!--<script type="text/javascript" src="../../src/www/inc/js/examSetup.js" data-cover></script>-->
    <script>
        var activeTab = 'gradeNav';
        var data = new Data();
        data.loadStockComments({!! $stockComments !!});
        data.loadElementComments( {!! $studentElementComments !!});
        data.loadElementScores({!! $studentElementScores !!});
        data.loadQuestionScores( {!! $studentQuestionScores !!});
        data.loadGradingTimes( {!!  $examGradingTimes !!} );
        data.loadExamGrades({!! $studentGrades !!} );
        data.loadNumberQuestions({!! $numQuestions !!});

    </script>
    <script type="text/javascript" src="{{ asset('js/grade-exam1-package.js') }}" data-cover></script>
    <!-- Your tests file goes here -->
    <script>
        test( 'select student | ', function () {
            expect( 1 );
            var display = $( '#questionArea' ).attr( 'display' );
            equal( display, 'none', "questionArea is hidden" );
//        fillSelects("term_select", 'term', this.terms);
//        equal($("#term_select").attr("data"), "term", "term select added to page for testing");
//        var options = document.getElementById('term_select').options;
//        $("#term_select option").each(function(i){
//            equal($(this).attr("data"), 'term', 'correct data attribute loaded');
//            equal($(this).val(), "Term"+ i,  "Correct value loaded");
//        })
        } );

    </script>
    {{--<script type="text/javascript" src="../js/examsetupTesting.js"></script>--}}
@endsection