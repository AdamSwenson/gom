<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 5:08 PM
 */ ?>
@extends('feedback.old.progress')

@section('progressText')
    <div class="infoText">
        Gradeomatic is compiling feedback for your students.....
    </div>
    @yield('sendingText')
@endsection
