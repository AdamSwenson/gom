<!-- /**
 * Created by PhpStorm.
 * User: Brian
 * Date: 10/4/2015
 * Time: 5:34 PM
 */ -->

@extends('layouts.master')

@section('pageTitle', 'About | gradeomatic')

@section('cssLinks')

@endsection

@section('body')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-justify">
            <h3><span class="glyphicon glyphicon-globe"></span> About</h3>
            @include('help.components_help.intro_note')
        </div>
        <div class="col-lg-3"></div>
    </div>
@endsection


@section('jsArea')
    <script>
        var activeTab = 'navHelp';
    </script>
    <script src="{{ asset('js/common-package.js') }}"></script>
@endsection