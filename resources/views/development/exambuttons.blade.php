<html>

<head>
    @include('layouts.css.css_bootstrap')
    <link href="{{asset('exams')}}" rel="stylesheet">
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
                @foreach($exams as $exam1)
                    {{--<div class="row">--}}
                    {{--<div class="col-lg-3 col-xs-4">--}}
                    <tr>
                        <td>
                            <exam1-release-toggle
                                    exam1-id="{{ $exam1->id }}"
                                    released="{{ $exam1->isReleased() }}"
                            ></exam1-release-toggle>
                            {{--</div>--}}
                        </td>
                        <td>
                            {{--<div class="col-xs-4">--}}
                            <exam1-buttons-dropdown
                                    exam1-id="{{ $exam1->id }}"
                                    base-url="{!! url() !!}"></exam1-buttons-dropdown>
                            {{--</div>--}}
                        </td>
                        {{--<div class="col-lg-5"></div>--}}
                        {{--<div class="col-lg-3">--}}
                        {{--<exam1-release-toggle--}}
                        {{--exam1-id="{{ $exam1->id }}"--}}
                        {{--released="{{ $exam1->isReleased() }}"--}}
                        {{--></exam1-release-toggle>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-4">--}}
                        {{--<exam1-buttons--}}
                        {{--exam1-id="{{ $exam1->id }}"--}}
                        {{--base-url="{!! url() !!}"--}}
                        {{--released="{{ $exam1->isReleased() }}"--}}
                        {{--></exam1-buttons>--}}
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
<script type="text/javascript" src="{{ asset('Item') }}"></script>
</body>
</html>
