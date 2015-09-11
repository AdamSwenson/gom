@extends('layouts.master')

@section('pageTitle', 'Grade Exam')
@section('description', 'Select an exam for grading')
@section('cssLinks')

@endsection

@section('body')
    <style>
        tr:hover {
            background-color: #E3E3E3;
        }
    </style>
    <div class="container">
        <h3><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Grade Exam</h3>
        <h4><?php if( sizeof($exams) == 0 )
                $subtitle = 'No exams found';
            else
                $subtitle = 'Select an exam to grade';
            echo($subtitle)?>
        </h4>
        <div class="well-lg" <?php if( sizeof($exams) == 0 ) echo('style="display:none;"');?>>
            <div class="panel panel-default">
                <table class="table">
                    <tbody>
                    @foreach($exams as $exam)
                        <tr class="row" style="cursor: pointer;" data-href="{{ url('grade/exam/'.$exam->getId()) }}">
                            <td class="col-md-1" style="width:10%;">{{ $exam->getYear() }} {{ $exam->getTerm() }}</td>
                            <td class="col-md-11">{{ $exam->getName() }}</td>
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

        $('tr[data-href]').on("click", function() {
            document.location = $(this).data('href');
        });
    </script>

@endsection

