@extends('layouts.master')

@section('otherCss')
    {{--<link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{ asset('css/grade-package.css') }}" rel="stylesheet" type="text/css">--}}
@endsection
@section('body')
<div id="homePage" class="row mainBodyLocator">
    <div class="col-xs-1 col-md-2 col-lg-2"></div>
    <div class="col-xs-10 col-md-8 col-lg-8">
        <img
                class="img-responsive"
                src="{{asset('images/home/greenbookSmall.jpeg')}}"
             alt="Picture of a student's exam, ready for grading.">
    </div>
    <div class="col-xs-1 col-md-2 col-lg-2"></div>
</div>
@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = '';
    </script>
    <script type='text/javascript' src="{{ asset('js/common-package.js') }}"></script>
@endsection