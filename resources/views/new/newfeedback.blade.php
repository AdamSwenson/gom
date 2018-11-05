<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Your feedback</title>

    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset("css/common-package.css")}}">
    <link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        /*.feedback-panel{*/
            /*margin: 5%;*/
        /*}*/
    </style>
</head>

<body>
<div class="main-area">

    <div id="app"></div>

    <input type="hidden" id="routeRoot" data="{{ url('') }}"/>
    <input type="hidden" id="examId" data="{{ $examId }}"/>
    <input type="hidden" id="exam" data="{{ $exam }}"/>
    <input type="hidden" id="items" data="{{ collect($itemObjects)->toJson() }}"/>
    <input type="hidden" id="order" data="{{ collect($itemOrder)->toJson() }}"/>
    <input type="hidden" id="scores" data="{{ collect($scores)->toJson() }}"/>
    <input type="hidden" id="students" data="{{ $student }}"/>
    <input type="hidden" id="letterGrade" data="{{ $letterGrade }}"/>
    <input type="hidden" id="totalScore" data="{{ $totalScore }}"/>
    <input type="hidden" id="averageTotalScore" data="{{ $avgTotalScore }}"/>

</div>

<script type="text/javascript">
    window.routeRoot = document.getElementById( 'routeRoot' ).getAttribute( 'data' );
    window.examId = document.getElementById( 'examId' ).getAttribute( 'data' );
</script>
<script src="{{ asset('/js/dev/newest-public-feedback-package.js') }}"></script>

</body>
</html>