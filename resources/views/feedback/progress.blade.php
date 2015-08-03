<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 5:06 PM
 */?>
@extends('layouts.master')

@section('pageTitle', 'Feedback progress')
@section('cssLinks')
    <link href="{{ asset('inc/css/outputStyles.css')}}" type="text/css" rel="stylesheet"/>
@endsection

@section('body')
    <div class="info">
        @yield('progressText')
    </div>
    @endsection
