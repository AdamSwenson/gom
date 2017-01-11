@extends('layouts.master')

@section('body')
    Test template

    <div id="app"></div>
@endsection

@section('jsArea')
{{--    <script src="{{ asset('/js/dev/test-package.js') }}"></script>--}}
    <script src="{{ asset('/js/dev/test2-package.js') }}"></script>
@endsection