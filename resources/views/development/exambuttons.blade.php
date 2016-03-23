<html>

<head>
    @include('layouts.css.css_bootstrap')
    <link href="{{asset('css/exam-button-package.css')}}" rel="stylesheet">
    {{--<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">--}}
    {{--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>--}}
    <style>
        .confirmRelease {
            width: 200px;
        }
    </style>
</head>
<body>
<div class="container">
    <div id="app">
        <table>
            @if ( sizeof($exams) > 0 )
                @foreach($exams as $exam)
                    {{--<div class="row">--}}
                    {{--<div class="col-lg-3 col-xs-4">--}}
                    <tr>
                        <td>
                            <exam-release-toggle
                                    exam-id="{{ $exam->id }}"
                                    released="{{ $exam->isReleased() }}"
                            ></exam-release-toggle>
                            {{--</div>--}}
                        </td>
                        <td>
                            {{--<div class="col-xs-4">--}}
                            <exam-buttons-dropdown
                                    exam-id="{{ $exam->id }}"
                                    base-url="{!! url() !!}"></exam-buttons-dropdown>
                            {{--</div>--}}
                        </td>
                        {{--<div class="col-lg-5"></div>--}}
                        {{--<div class="col-lg-3">--}}
                        {{--<exam-release-toggle--}}
                        {{--exam-id="{{ $exam->id }}"--}}
                        {{--released="{{ $exam->isReleased() }}"--}}
                        {{--></exam-release-toggle>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-4">--}}
                        {{--<exam-buttons--}}
                        {{--exam-id="{{ $exam->id }}"--}}
                        {{--base-url="{!! url() !!}"--}}
                        {{--released="{{ $exam->isReleased() }}"--}}
                        {{--></exam-buttons>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </tr>
                @endforeach
        </table>
        @endif
    </div>
</div>

<script>
    var baseUrl = '{!! url() !!}';
</script>
<script type="text/javascript" src="{{ asset('js/dev-exam-buttons.js') }}"></script>
</body>
</html>
