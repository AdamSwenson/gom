
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset("css/common-package.css")}}">

    <link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">

</head>

<body>
<div class="container-fluid">
    <div id="app"></div>

    {{ method_field('PUT') }}

    {{ method_field('DELETE') }}
    <input type="hidden" id="routeRoot" data="{{ url('') }}" />

</div>
<script type="text/javascript">
    var routeRoot = document.getElementById('routeRoot').getAttribute('data');
</script>
<script src="{{ asset('/js/dev/new-setup-package.js') }}"></script>
</body>
</html>