@extends('layouts.master')

@section('pageTitle', 'Student Controls')
@section('description', 'Email or review student feedback')

@section('cssLinks')
@endsection

@section('body')

    <div class="container">

        <h3><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Student Controls:
            {{ $exam->getTerm() }} {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>


        <div class="well-lg">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="col-md-4">Name</th>
                    <th class="col-md-4">Email</th>
                    <th class="col-md-1">Id</th>
                    <th class="col-md-3"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td style="vertical-align:middle">{{ $student->last_name }}, {{ $student->first_name }}</td>
                        <td style="vertical-align:middle">{{ $student->getEmail() }}</td>
                        <td style="vertical-align:middle">{{ $student->getStudentId()}}</td>
                        <td style="text-align: right;">
                            <a class="btn btn-default">
                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                 <span id="sendMsg">Email</span>
                            </a>
                            <a class="btn btn-primary">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                 <span>Review</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

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


