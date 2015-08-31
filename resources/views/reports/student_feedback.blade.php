@extends('layouts.master')

@section('pageTitle', 'Student Feedback')
@section('description', "Review feedback for the student")

@section('cssLinks')
@endsection

@section('body')

    <div class="container">


        <h3>
            <div class="row">
                <div class="col-md-3">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ $student->last_name }},
                {{ $student->first_name }}
                </div>
                <div class="col-md-3">
                ID {{ $student->getStudentId() }}
                </div>
                <div class="col-md-6"></div>
            </div>
        </h3>
        <h4>{{ $exam->getTerm() }} {{ $exam->getYear() }} "{{ $exam->getName() }}"</h4>
        <hr>
        <div>
            student feedback goes here.
        </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')

    <script type="text/javascript">

        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');

    </script>

@endsection


