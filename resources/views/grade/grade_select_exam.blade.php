@extends('layouts.master')

@section('pageTitle', 'Grade Exam')
@section('description', 'Choose an exam to grade')
@section('cssLinks')

@endsection

@section('body')

        <!-- style exam names with year and term -->
<style type="text/css">
    .exam-name {
        display: inline-block;
        width: 110px;
    }
</style>

<div class="container">

    <h2>Select Exam</h2>

    <div class="col-md-8">
        @foreach($exams as $exam)
            <div class="row">
                <form method="GET" action="{{ url('grade/exam/'. $exam->getId()) }}"
                      accept-charset="UTF-8">
                    <button type="submit"
                            class="list-group-item"><span class="exam-name">{{ $exam->getYear() }}, {{ $exam->getTerm() }}
                        </span>| {{ $exam->getName() }}</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection


@section('jsArea')


@endsection

