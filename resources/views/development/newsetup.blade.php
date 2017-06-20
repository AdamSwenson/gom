<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="stylesheet" href="{{ asset("css/common-package.css")}}">
    <link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="container-fluid">
    <div id="app"></div>

    {{ method_field('PUT') }}

    {{ method_field('PATCH') }}


    {{ method_field('DELETE') }}
    <input type="hidden" id="routeRoot" data="{{ url('') }}"/>


</div>
<input type="hidden" id="loadedExam" data='{!! isset($exam) ? json_encode($exam, JSON_FORCE_OBJECT) : '' !!}'/>
<input type="hidden" id="loadedItems" data='{!! isset($items) ? json_encode($items, JSON_FORCE_OBJECT) : '' !!}'/>
{{--<div id="loadedExam" data="{!!  json_encode($exam, JSON_FORCE_OBJECT) !!}" />--}}
<script type="text/javascript">
    var routeRoot = document.getElementById( 'routeRoot' ).getAttribute( 'data' );
</script>
<script src="{{ asset('/js/dev/new-setup-package.js') }}"></script>
</body>
</html>