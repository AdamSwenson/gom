@extends('layouts.master')
@section('pageTitle', 'Login | gradeomatic')
@section('description', 'Login to gradeomatic')

@section('body')
    @include('auth.partials.login_form')
@endsection