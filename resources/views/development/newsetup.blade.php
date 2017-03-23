
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset("css/common-package.css")}}">

    <link rel="stylesheet" href="{{ asset("css/new-setup-package.css")}}">
<style>
    .dashboard{
        border: double;
    }
</style>
</head>

<body>
<div class="container-fluid">
    <div id="app">
            <div id="examEditor">

                <!--<div class="row">-->
                <!--<div class="col-lg-8">-->
                <exam-name></exam-name>

                <exam-properties></exam-properties>

                <div id="examEditorBody"
                     class="row">

                    <div id="itemCol"
                         class="col-lg-9 well well-lg">

                        <div class="itemRow row">
                            <div class="col-lg-12">
                                <card-list></card-list>
                            </div>
                        </div>

                    </div>

                    <div id="infoCol"
                         class="col-lg-3">

                        <div class="row">
                            <div class="col-lg-12">
                                <props-dashboard></props-dashboard>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <tools-dashboard></tools-dashboard>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

    </div>

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