@extends('layouts.master')
@section('title')
    Login to the Gradeomatic
@endsection

@section('body')
    <div class="row">
    @include('auth.login_form')
    </div>
@endsection