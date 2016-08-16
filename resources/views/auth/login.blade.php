@extends('layouts.master')
@section('pageTitle', 'Login | gradeomatic')
@section('description', 'Login to gradeomatic')

@section('otherCss')
    <style>
    .verticallyAligned {
    height: 21px;
    line-height: 21px;
    }
    </style>
    @endsection

@section('body')
    <div id="loginPage" class="mainBodyLocator">
    @include('auth.partials.login_form')
    </div>
@endsection