@extends('new.newmaster')

@section('pageTitle', 'Gradeomatic - Grade exams')
@section('description', 'Grading page for the Gradeomatic')

@section('pageCss')
    {{--This needs to be here until GOM-372 is fixed--}}
{{--    <link href="{{ asset('css/grade-package-required-until-gom-372-is-fixed.css') }}" rel="stylesheet" type="text/css">--}}
@endsection

@section('pageJs')
    <script src="{{ asset('/js/dev/newest-grading-package.js') }}"></script>
@endsection
