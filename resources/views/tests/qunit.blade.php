<!DOCTYPE html>
<html>
<head>
    <title>Scripts Test Suite</title>
    <link rel="stylesheet" href="{{asset('css/testing/qunit-1.15.0.css')}}" type="text/css" media="screen">
    <script type="text/javascript" src="{{asset('js/testing/js-test-suite.js')}}" data-cover-flags="debug"></script>

    {{--<script type="text/javascript" src="../unitTestHelpers/jquery-1.11.1.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/jquery-ui.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/jquery.tmpl.min.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/qunit-1.15.0.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/json2.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/jquery.mockjax.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/jquery.cookie.js"></script>--}}
    {{--<script type="text/javascript" src="../unitTestHelpers/blanket.js" data-cover-flags="debug"></script>--}}

    <!--Tested scripts-->
    <script type="text/javascript" src="{{ $testedScriptPath }}" data-cover></script>
    <!-- Your tests file goes here -->
    <script type="text/javascript" src="{{ $testingScriptPath }}"></script>


</head>
<body>
<h1 id="qunit-header">Unit tests for {{ $testedScriptPath }}</h1>

<h2 id="qunit-banner"></h2>

<div id="qunit-testrunner-toolbar"></div>
<h2 id="qunit-userAgent"></h2>
<ol id="qunit-tests"></ol>
<div id="qunit-fixture">
    @yield('fixture')
</div>
<div id="show"></div>

<div id="moreScripts">
    @yield('jsScripts')
</div>
</body>
</html>