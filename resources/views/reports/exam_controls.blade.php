@extends('layouts.master')

@section('pageTitle', 'Reports')
@section('description', 'Select an exam action')

@section('cssLinks')
@endsection

@section('body')
    <div class="container">
        <h3><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Report & Release</h3>
        <h4>Release grades to students or view data about an exam</h4>

        <div class="well-lg">
            <div class="panel panel-default">
                <table class="table">
                    <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <!-- width will override the column width setting for term info -->
                            <td class="col-md-1" style="vertical-align:middle; width: 10%;">
                                {{ $exam->getTerm() }}
                                {{ $exam->getYear() }}
                            </td>
                            <td class="col-md-8" style="vertical-align:middle">
                                {{ $exam->getName() }}
                            </td>
                            <!-- control buttons -->
                            <td class="col-md-3" style="text-align:right">
                                <a id="{{'releaseExam' . $exam->getId()}}" title="Release Exam" class="btn btn-warning"
                                   onclick="releaseExam({{ $exam->getId()}} )"><span
                                            class="glyphicon glyphicon-lock"
                                            aria-hidden="true"></span> Release Exam</a>
                                <a class="btn btn-primary" title="Exam Analytics"
                                   href="{{url('report/' . $exam->getId() . '/analytics')}}"><span
                                            class="glyphicon glyphicon-stats"
                                            aria-hidden="true"></span> </a>
                                <a class="btn btn-default" title="Student Controls"
                                   href="{{url('report/' . $exam->getId() . '/students')}}"><span
                                            class="glyphicon glyphicon-user" aria-hidden="true"></span> </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')

    <script type="text/javascript">

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

        function releaseExam(examId) {

        }
    </script>


@endsection


