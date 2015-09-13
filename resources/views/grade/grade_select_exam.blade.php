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
        <h4><?php if (sizeof($exams) == 0)
                $subtitle = 'No exams found';
            else
                $subtitle = 'Select an exam to grade';
            echo($subtitle)?>
        </h4>

        <div class="well-lg" <?php if (sizeof($exams) == 0) echo('style="display:none;"');?>>
            <div class="panel panel-default">
                <table class="table">
                    <thead>
                    <tr class="row" style="cursor: default;">
                        <th class="col-md-1">Term</th>
                        <th class="col-md-8">Name</th>
                        <th class="col-md-1">Questions</th>
                        <th class="col-md-1">Students</th>
                        <th class="col-md-1">Graded</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        <?php $examId = $exam->getId() ?>
                        <tr class="row" style="cursor: pointer;" data-href="{{ url('grade/exam/'.$exam->getId()) }}">
                            <td class="col-md-1" style="width:10%;">{{ $exam->getYear() }} {{ $exam->getTerm() }}</td>
                            <td class="col-md-8">{{ $exam->getName() }}</td>
                            <td class="col-md-1">{{ $numQuestions[ $examId ] or '0' }}</td>
                            <td class="col-md-1">{{ $numStudents[ $examId ] or '0' }}</td>
                            <td class="col-md-1">{{ $numGraded[ $examId ] or '0' }}</td>
                        </tr>
                    @endforeach
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

