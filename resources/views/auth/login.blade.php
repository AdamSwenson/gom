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
    @include('auth.partials.login_form')
@endsection