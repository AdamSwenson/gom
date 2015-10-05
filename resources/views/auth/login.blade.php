@extends('layouts.master')
@section('pageTitle', 'Login | gradeomatic')
@endsection

@section('description', 'Login to gradeomatic')
@endsection

@section('body')

    @include('auth.login_form')

@endsection