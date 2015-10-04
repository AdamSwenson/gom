@extends('layouts.master')
@section('title')
    Login to the gradeomatic
@endsection

@section('body')

    @include('auth.login_form')

@endsection