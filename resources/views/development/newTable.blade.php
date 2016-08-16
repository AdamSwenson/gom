@extends('layouts.master')
@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'Grade an exam')

@section('otherCss')
    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/grade-exam-data.js')}}"></script>
@endsection

@section('body')
    <div id="gradeExamPage" class="row mainBodyLocator">
        <student-table></student-table>
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
                $maxScores = json_encode($maxQuestionScores, JSON_FORCE_OBJECT);
                $numQuestions = count($questionAssignments);

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
                window.console.log('studdntsJson', {!! $studentsJson !!});
    </script>

    <script src="{{ asset('js/dev/grade-vue.js') }}"></script>
@endsection