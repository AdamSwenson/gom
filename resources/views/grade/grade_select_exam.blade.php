<!-- select an exam1 to grade -->
@extends('layouts.master')

@section('pageTitle', 'Grade Exam | gradeomatic')
@section('description', 'grade')
@section('otherCss')
    <link href="{{ asset('css/exam-table-package.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('body')
    <div id="gradeSelectExamPage" class="mainBodyLocator">
        <h3><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Grade Exam</h3>
        <h4>Select an exam1 to grade</h4>

        <div class="panel panel-default">
            <table class="table">
                <thead>
                <tr style="cursor: default;">
                    <th class="col-lg-1">Term</th>
                    <th class="col-lg-6 nameCellHeader"
                    >Name
                    </th>
                    <th class="col-lg-1">Questions</th>
                    <th class="col-lg-1">Students</th>
                    <th class="col-lg-1">Graded</th>

                    <th class="col-lg-3 buttonCellHeader"
                            {{--style="width: 200px; min-width: 200px;"--}}
                    ></th>
                </tr>
                </thead>
                <tbody>
                @if( sizeof($exams) > 0 )
                    @foreach($exams as $exam1)
                        <?php $examId = $exam1->id or '0' ?>
                        <tr>
                            <td class="examDetailsCell"
                                    {{--style="vertical-align:middle; width:10%;"--}}
                            >{{ $exam1->term or '' }} {{ $exam1->year or '' }}</td>

                            <td id="examName{{$examId}}"
                                class="examNameCell"
                                    {{--style="vertical-align:middle;"--}}
                            >{{ $exam1->name or 'No Name Found' }}</td>

                            <td class="examDetailsCell numQuestions"
                                id="numQuestions{{$examId}}"
                            >{{ $numQuestions[ $examId ] or '0' }}</td>

                            <td class="examNameCell numStudents"
                                id="numStudents{{$examId}}"
                            >{{ $numStudents[ $examId ] or '0' }}</td>

                            <td class="examNameCell numGraded"
                                id="numGraded{{$examId}}"
                            >{{ $numGraded[ $examId ] or '--' }}</td>

                            <td class="examButtonsCell">
                                <a
                                        id="gradeExam{{$examId}}"
                                        data-href="{{ url('grade/exam/'.$examId) }}"
                                        class="gradeButton btn btn-primary {{ ! $exam1->isGradable() ? 'disabled' : '' }}"
                                        title="Grade exam1"
                                >
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Grade</a>
                                <a
                                        id="assignExam{{$examId}}"
                                        data-href="{{ url('grade/exam/'.$examId.'/assign') }}"
                                        class="assignButton btn btn-primary {{ ! $exam1->isGradable() ? 'disabled' : '' }}"
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
    </div>
@endsection


@section('jsArea')
    <script type="text/javascript">
        // for setting 'Grade' tab as active
        var activeTab = 'navGrade';
    </script>
    <script type="text/javascript" src="{{ asset('js/grade-exam-select-package.js') }}"></script>

@endsection
