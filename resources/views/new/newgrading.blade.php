@extends('new.newmaster')

@section('pageTitle', 'Grade exams')
@section('description', 'Grading page for the Gradeomatic')

@section('pageCss')
    <link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('pageJs')
    <script src="{{ asset('/js/dev/newest-grading-package.js') }}"></script>
@endsection
