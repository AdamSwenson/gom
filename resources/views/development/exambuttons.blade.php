<html>

<head>
    @include('layouts.css.css_bootstrap')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">

    {{--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>--}}
</head>
<body>
<div id="app">
    {{--{{ dd($exams) }}--}}
    @if ( sizeof($exams) > 0 )
        @foreach($exams as $exam)
            <div class="row">
                <div class="col-lg-12">
                    <exam-buttons
                            exam-id="{{ $exam->id }}"
                            base-url="{!! url() !!}"
                            released="{{ $exam->isReleased() }}"
                    ></exam-buttons>
                </div>
            </div>
        @endforeach


    @endif

</div>


<script type="text/javascript" src="{{ asset('js/dev-exam-buttons.js') }}"></script>
</body>
</html>
