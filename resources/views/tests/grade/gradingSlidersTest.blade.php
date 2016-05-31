<?php
use App\Element;
use App\Exam;
use App\QuestionAssignment;
use App\Student;

$testedScriptPath = asset('js/grade-exam-package.js');
$testingScriptPath = '';

$exam = factory(Exam::class)->make();

$students = factory(Student::class, 5)->make();
$questionAssignments = QuestionAssignment::where('exam_id', 2)->get();

$maxQuestionScores =
        [
                1 => (float) 100,
                2 => (float) 100,
                3 => (float) 100,
                4 => (float) 100,
                5 => (float) 100
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
                0  =>
                        [
                                0 => 'comment101BodyText',
                                1 => 'comment102BodyText',
                                2 => 'comment103BodyText',
                                3 => 'comment104BodyText'
                        ],
                1  =>
                        [
                                0 => 'comment105BodyText',
                                1 => 'comment106BodyText',
                                2 => 'comment107BodyText',
                                3 => 'comment108BodyText'
                        ],
                2  =>
                        [
                                0 => 'comment109BodyText',
                                1 => 'comment110BodyText',
                                2 => 'comment111BodyText',
                                3 => 'comment112BodyText'
                        ],
                3  =>
                        [
                                0 => 'comment113BodyText',
                                1 => 'comment114BodyText',
                                2 => 'comment115BodyText',
                                3 => 'comment116BodyText'
                        ],
                4  =>
                        [
                                0 => 'comment117BodyText',
                                1 => 'comment118BodyText',
                                2 => 'comment119BodyText',
                                3 => 'comment120BodyText'
                        ],
                5  =>
                        [
                                0 => 'comment121BodyText',
                                1 => 'comment122BodyText',
                                2 => 'comment123BodyText',
                                3 => 'comment124BodyText'
                        ],
                6  =>
                        [
                                0 => 'comment125BodyText',
                                1 => 'comment126BodyText',
                                2 => 'comment127BodyText',
                                3 => 'comment128BodyText'
                        ],
                7  =>
                        [
                                0 => 'comment129BodyText',
                                1 => 'comment130BodyText',
                                2 => 'comment131BodyText',
                                3 => 'comment132BodyText'
                        ],
                8  =>
                        [
                                0 => 'comment133BodyText',
                                1 => 'comment134BodyText',
                                2 => 'comment135BodyText',
                                3 => 'comment136BodyText'
                        ],
                9  =>
                        [
                                0 => 'comment137BodyText',
                                1 => 'comment138BodyText',
                                2 => 'comment139BodyText',
                                3 => 'comment140BodyText'
                        ],
                10 =>
                        [
                                0 => 'comment141BodyText',
                                1 => 'comment142BodyText',
                                2 => 'comment143BodyText',
                                3 => 'comment144BodyText'
                        ],
                11 =>
                        [
                                0 => 'comment145BodyText',
                                1 => 'comment146BodyText',
                                2 => 'comment147BodyText',
                                3 => 'comment148BodyText'
                        ],
                12 =>
                        [
                                0 => 'comment149BodyText',
                                1 => 'comment150BodyText',
                                2 => 'comment151BodyText',
                                3 => 'comment152BodyText'
                        ],
                13 =>
                        [
                                0 => 'comment153BodyText',
                                1 => 'comment154BodyText',
                                2 => 'comment155BodyText',
                                3 => 'comment156BodyText'
                        ],
                14 =>
                        [
                                0 => 'comment157BodyText',
                                1 => 'comment158BodyText',
                                2 => 'comment159BodyText',
                                3 => 'comment160BodyText'
                        ],
                15 =>
                        [
                                0 => 'comment161BodyText',
                                1 => 'comment162BodyText',
                                2 => 'comment163BodyText',
                                3 => 'comment164BodyText'
                        ],
                16 =>
                        [
                                0 => 'comment165BodyText',
                                1 => 'comment166BodyText',
                                2 => 'comment167BodyText',
                                3 => 'comment168BodyText'
                        ],
                17 =>
                        [
                                0 => 'comment169BodyText',
                                1 => 'comment170BodyText',
                                2 => 'comment171BodyText',
                                3 => 'comment172BodyText'
                        ],
                18 =>
                        [
                                0 => 'comment173BodyText',
                                1 => 'comment174BodyText',
                                2 => 'comment175BodyText',
                                3 => 'comment176BodyText'
                        ],
                19 =>
                        [
                                0 => 'comment177BodyText',
                                1 => 'comment178BodyText',
                                2 => 'comment179BodyText',
                                3 => 'comment180BodyText'
                        ],
                20 => [
                        0 => 'comment181BodyText',
                        1 => 'comment182BodyText',
                        2 => 'comment183BodyText',
                        3 => 'comment184BodyText'
                ],
                21 => [
                        0 => 'comment185BodyText',
                        1 => 'comment186BodyText',
                        2 => 'comment187BodyText',
                        3 => 'comment188BodyText'
                ],
                22 => [
                        0 => 'comment189BodyText',
                        1 => 'comment190BodyText',
                        2 => 'comment191BodyText',
                        3 => 'comment192BodyText'
                ],
                23 => [
                        0 => 'comment193BodyText',
                        1 => 'comment194BodyText',
                        2 => 'comment195BodyText',
                        3 => 'comment196BodyText'
                ],
                24 => [
                        0 => 'comment197BodyText',
                        1 => 'comment198BodyText',
                        2 => 'comment199BodyText',
                        3 => 'comment200BodyText'
                ]
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
                        0  => null,
                        1  => null,
                        2  => null,
                        3  => null,
                        4  => null,
                        5  => null,
                        6  => null,
                        7  => null,
                        8  => null,
                        9  => null,
                        10 => null,
                        11 => null,
                        12 => null,
                        13 => null,
                        14 => null,
                        15 => null,
                        16 => null,
                        17 => null,
                        18 => null,
                        19 => null,
                        20 => null,
                        21 => null,
                        22 => null,
                        23 => null,
                        24 => null
                ),
        1 =>
                array(
                        0  => null,
                        1  => null,
                        2  => null,
                        3  => null,
                        4  => null,
                        5  => null,
                        6  => null,
                        7  => null,
                        8  => null,
                        9  => null,
                        10 => null,
                        11 => null,
                        12 => null,
                        13 => null,
                        14 => null,
                        15 => null,
                        16 => null,
                        17 => null,
                        18 => null,
                        19 => null,
                        20 => null,
                        21 => null,
                        22 => null,
                        23 => null,
                        24 => null
                ),
        2 =>
                array(
                        0  => null,
                        1  => null,
                        2  => null,
                        3  => null,
                        4  => null,
                        5  => null,
                        6  => null,
                        7  => null,
                        8  => null,
                        9  => null,
                        10 => null,
                        11 => null,
                        12 => null,
                        13 => null,
                        14 => null,
                        15 => null,
                        16 => null,
                        17 => null,
                        18 => null,
                        19 => null,
                        20 => null,
                        21 => null,
                        22 => null,
                        23 => null,
                        24 => null
                ),
        3 =>
                array(
                        0  => null,
                        1  => null,
                        2  => null,
                        3  => null,
                        4  => null,
                        5  => null,
                        6  => null,
                        7  => null,
                        8  => null,
                        9  => null,
                        10 => null,
                        11 => null,
                        12 => null,
                        13 => null,
                        14 => null,
                        15 => null,
                        16 => null,
                        17 => null,
                        18 => null,
                        19 => null,
                        20 => null,
                        21 => null,
                        22 => null,
                        23 => null,
                        24 => null
                ),
        4 =>
                array(
                        0  => null,
                        1  => null,
                        2  => null,
                        3  => null,
                        4  => null,
                        5  => null,
                        6  => null,
                        7  => null,
                        8  => null,
                        9  => null,
                        10 => null,
                        11 => null,
                        12 => null,
                        13 => null,
                        14 => null,
                        15 => null,
                        16 => null,
                        17 => null,
                        18 => null,
                        19 => null,
                        20 => null,
                        21 => null,
                        22 => null,
                        23 => null,
                        24 => null
                ),
];
$studentElementComments =
        [
                0 =>
                        array(
                                0  => '',
                                1  => '',
                                2  => '',
                                3  => '',
                                4  => '',
                                5  => '',
                                6  => '',
                                7  => '',
                                8  => '',
                                9  => '',
                                10 => '',
                                11 => '',
                                12 => '',
                                13 => '',
                                14 => '',
                                15 => '',
                                16 => '',
                                17 => '',
                                18 => '',
                                19 => '',
                                20 => '',
                                21 => '',
                                22 => '',
                                23 => '',
                                24 => ''
                        ),
                1 => array(
                        0  => '',
                        1  => '',
                        2  => '',
                        3  => '',
                        4  => '',
                        5  => '',
                        6  => '',
                        7  => '',
                        8  => '',
                        9  => '',
                        10 => '',
                        11 => '',
                        12 => '',
                        13 => '',
                        14 => '',
                        15 => '',
                        16 => '',
                        17 => '',
                        18 => '',
                        19 => '',
                        20 => '',
                        21 => '',
                        22 => '',
                        23 => '',
                        24 => ''
                ),
                2 =>
                        array(
                                0  => '',
                                1  => '',
                                2  => '',
                                3  => '',
                                4  => '',
                                5  => '',
                                6  => '',
                                7  => '',
                                8  => '',
                                9  => '',
                                10 => '',
                                11 => '',
                                12 => '',
                                13 => '',
                                14 => '',
                                15 => '',
                                16 => '',
                                17 => '',
                                18 => '',
                                19 => '',
                                20 => '',
                                21 => '',
                                22 => '',
                                23 => '',
                                24 => ''
                        ),
                3 =>
                        array(
                                0  => '',
                                1  => '',
                                2  => '',
                                3  => '',
                                4  => '',
                                5  => '',
                                6  => '',
                                7  => '',
                                8  => '',
                                9  => '',
                                10 => '',
                                11 => '',
                                12 => '',
                                13 => '',
                                14 => '',
                                15 => '',
                                16 => '',
                                17 => '',
                                18 => '',
                                19 => '',
                                20 => '',
                                21 => '',
                                22 => '',
                                23 => '',
                                24 => ''
                        ),
                4 =>
                        array(
                                0  => '',
                                1  => '',
                                2  => '',
                                3  => '',
                                4  => '',
                                5  => '',
                                6  => '',
                                7  => '',
                                8  => '',
                                9  => '',
                                10 => '',
                                11 => '',
                                12 => '',
                                13 => '',
                                14 => '',
                                15 => '',
                                16 => '',
                                17 => '',
                                18 => '',
                                19 => '',
                                20 => '',
                                21 => '',
                                22 => '',
                                23 => '',
                                24 => ''
                        ),
        ];
$studentQuestionScores = [
        0 => array(
                0 => null,
                1 => null,
                2 => null,
                3 => null,
                4 => null
        ),
        1 =>
                array(
                        0 => null,
                        1 => null,
                        2 => null,
                        3 => null,
                        4 => null
                ),
        2 =>
                array(
                        0 => null,
                        1 => null,
                        2 => null,
                        3 => null,
                        4 => null
                ),
        3 =>
                array(
                        0 => null,
                        1 => null,
                        2 => null,
                        3 => null,
                        4 => null
                ),
        4 =>
                array(
                        0 => null,
                        1 => null,
                        2 => null,
                        3 => null,
                        4 => null
                ),
];
$studentGrades = array(
        0 => 'Letter grade',
        1 => 'Letter grade',
        2 => 'Letter grade',
        3 => 'Letter grade',
        4 => 'Letter grade'
);
//
//                                             $data = ['exam'                   => $exam,
//                                                    'students'               => $students,
//                                                    'questionAssignments'    => $questionAssignments,
//                                                    'maxQuestionScores'      => $maxQuestionScores,
//                                                    'allElements'            => $allElements,
//                                                    'stockComments'          => $stockComments,
//                                                    'examGradingTimes'       => $examGradingTimes,
//                                                    'studentElementScores'   => $studentElementScores,
//                                                    'studentElementComments' => $studentElementComments,
//                                                    'studentQuestionScores'  => $studentQuestionScores,
//                                                    'studentGrades'          => $studentGrades,
//                                            ];
?>
@extends('tests.qunit');

@section('fixture')
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
    {{--@include('grade.partials.student_table')--}}

    <!-- statistics area holds time info -->
        {{--@include('grade.partials.statistics_table')--}}
    </div>
    </div>

@endsection

{{--<script type="text/javascript" src="../../js/grade-exam-package.js" data-cover></script>--}}
<!--<script type="text/javascript" src="../../src/www/inc/js/examSetup.js" data-cover></script>-->
<!-- Your tests file goes here -->
<!--<script type="text/javascript" src="../js/examsetupTesting.js"></script>-->
