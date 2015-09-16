<!-- select an exam to grade -->
@extends('layouts.master')

@section('pageTitle', 'Grade Exam | GradeOmatic')
@section('description', 'Select an exam for grading')
@section('cssLinks')

@endsection

@section('body')
    <style>
        .table th {
            border: none;
        }

        tr:hover {
            background-color: #E3E3E3;
        }

        thead tr:hover {
            background-color: white;
        }

        .panel {
            border: none;
        }
    </style>
    <div class="container">
        <h3><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Grade Exam</h3>
        <h4>Select an exam to grade</h4>

        <div class="well-lg">
            <div class="panel panel-default">
                <table class="table">
                    <thead>
                    <tr style="cursor: default;">
                        <th class="col-md-1">Term</th>
                        <th class="col-md-9">Name</th>
                        <th class="col-md-1">Questions</th>
                        <th class="col-md-1">Students</th>
                        {{-- <th class="col-md-1">Graded</th> taking this out for now --}}
                    </tr>
                    </thead>
                    <tbody>
                    @if( sizeof($exams) > 0 )
                        @foreach($exams as $exam)
                            <?php $examId = $exam->id or '0' ?>
                            <tr style="cursor: pointer;" data-href="{{ url('grade/exam/'.$examId) }}">
                                <td style="width:10%;">{{ $exam->year or '' }} {{ $exam->term or '' }}</td>
                                <td>{{ $exam->name or 'No Name Found' }}</td>
                                <td>{{ $numQuestions[ $examId ] or '0' }}</td>
                                <td>{{ $numStudents[ $examId ] or '0' }}</td>
                                {{-- <td class="col-md-1">{{ $numGraded[ $examId ] or '0' }}</td> --}}
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="vertical-align:middle; width: 10%;"></td>
                            <td style="vertical-align:middle"><i>No Exams Found</i></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('jsArea')
    <script type="text/javascript">
        // set 'Grade' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navGrade').attr('class', 'active');

        $('tr[data-href]').on("click", function () {
            document.location = $(this).data('href');
        });
    </script>

@endsection

