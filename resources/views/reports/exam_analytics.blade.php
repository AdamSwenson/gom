@extends('layouts.master')

@section('pageTitle', 'Student Controls')
@section('description', 'Email or review student feedback')

@section('cssLinks')
@endsection

@section('body')

    <div class="container">

        <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Analytics: {{ $exam->getTerm() }}
            {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
        <div>
            @foreach($students as $student)

            @endforeach
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


