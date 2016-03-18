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
    <h3><span class="glyphicon glyphicon-globe"></span> About</h3>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            @include('help.components_help.intro_note')
        </div>
        <div class="col-lg-3"></div>
    </div>
@endsection


@section('jsArea')


@endsection