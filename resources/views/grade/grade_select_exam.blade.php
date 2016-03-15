<!-- select an exam to grade -->
@extends('layouts.master')

@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'grade')
@section('otherCss')
    <link href="{{ asset('css/exam-table-package.css') }}"  rel="stylesheet" type="text/css" >
@endsection

@section('body')
    {{--<style>--}}
        {{--.table th {--}}
            {{--border: none;--}}
        {{--}--}}

        {{--.panel {--}}
            {{--border: none;--}}
        {{--}--}}
    {{--</style>--}}

    <h3><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Grade Exam</h3>
    <h4>Select an exam to grade</h4>

    <div class="panel panel-default">
        <table class="table">
            <thead>
            <tr style="cursor: default;">
                <th class="col-lg-1">Term</th>
                <th class="col-lg-6 nameCellHeader"
                    {{--style="min-width: 200px;"--}}
                >Name</th>
                <th class="col-lg-1">Questions</th>
                <th class="col-lg-1">Students</th>
                <th class="col-lg-3 buttonCellHeader"
                    {{--style="width: 200px; min-width: 200px;"--}}
                ></th>
            </tr>
            </thead>
            <tbody>
            @if( sizeof($exams) > 0 )
                @foreach($exams as $exam)
                    <?php $examId = $exam->id or '0' ?>
                    <tr>
                        <td class="examDetailsCell"
                            {{--style="vertical-align:middle; width:10%;"--}}
                        >{{ $exam->year or '' }} {{ $exam->term or '' }}</td>
                        <td class="examNameCell"
                            {{--style="vertical-align:middle;"--}}
                        >{{ $exam->name or 'No Name Found' }}</td>
                        <td class="examDetailsCell"
                            {{--style="vertical-align:middle;"--}}
                            id="numQuestions"
                        >{{ $numQuestions[ $examId ] or '0' }}</td>
                        <td class="examNameCell"
                                {{--style="vertical-align:middle;"--}}
                            id="numStudents"
                        >{{ $numStudents[ $examId ] or '0' }}</td>
                        <td class="examButtonsCell"
                            {{--style="text-align: right"--}}
                        >
                            <a
                                    data-href="{{ url('grade/exam/'.$examId) }}"
                                    class="btn btn-primary"
                                    title="Grade exam"
                            >
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Grade</a>
                            <a
                                    data-href="{{ url('grade/exam/'.$examId.'/assign') }}"
                                    class="btn btn-primary"
                                    title="Assign letter grades"
                            >
                                <span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Assign</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="examDetailsCell"
                        {{--style="vertical-align:middle; width: 10%;"--}}
                    ></td>
                    <td class="examNameCell"
                        {{--style="vertical-align:middle"--}}
                    ><i>No Exams Found</i></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection


@section('jsArea')
    <script type="text/javascript">
        // for setting 'Grade' tab as active
        var activeTab = 'navGrade';
</script>
    <script type="text/javascript" src="{{ asset('js/grade-exam-select-package.js') }}"></script>

@endsection

