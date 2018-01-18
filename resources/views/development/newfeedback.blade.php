<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset("css/common-package.css")}}">
    <link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="main-area">

    <div id="app"></div>

    {{ method_field('PUT') }}

    {{ method_field('PATCH') }}

    {{ method_field('DELETE') }}

    <input type="hidden" id="routeRoot" data="{{ url('') }}"/>

    <input type="hidden" id="examId" data="{{ $exam->id }}"/>

    <input type="hidden" id="exam" data="{{ $exam->toJson() }}"/>
    <input type="hidden" id="student" data="{{ $student->toJson() }}"/>

    <input type="hidden" id="items" data="{{ collect($itemObjects)->toJson() }}"/>
    <input type="hidden" id="order" data="{{ collect($itemOrder)->toJson() }}"/>


    <input type="hidden" id="scores" data="{{ $scores->toJson() }}"/>

</div>

<script type="text/javascript">
    window.routeRoot = document.getElementById( 'routeRoot' ).getAttribute( 'data' );
    window.examId = document.getElementById( 'examId' ).getAttribute( 'data' );
</script>
<script src="{{ asset('/js/dev/newest-public-feedback-package.js') }}"></script>
{{--<script src="http://localhost:35729/livereload.js"></script>--}}

</body>
</html>