<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 5:12 PM
 */?>
@extends('feedback.progress_compiling)
@section('sendingText')
    <div class="infoText">
        Gradeomatic has completed compiling feedback for your students.....
    </div>

    <div class="infoText">
        Gradeomatic is preparing to notify your students that their comments are available.....
    </div>
    @yield('sendComplete')
    @endsection
