<!-- Analytics page holds visualizations for student performance -->
@extends('layouts.master')

@section('pageTitle', 'Analytics | Grade-O-Matic')
@section('description', 'View information about the exam')

@section('cssLinks')
@endsection

@section('body')

    <div class="container">

        <h3><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Analytics: {{ $exam->getTerm() }}
            {{ $exam->getYear() }} "{{ $exam->getName() }}"</h3>
        <div>
            <?php $i = 1; ?>
            @foreach($meanScores as $meanScore)
                Mean for {{ $i }}: {{ $meanScore  or '0' }}<br>
                StdDeviation for {{ $i }}: {{ $stdDeviations[$i] or 'NA' }}<br>
                <?php $i++; ?>
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


