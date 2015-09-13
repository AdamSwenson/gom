<?php
/**
 * This is the page which a user will be redirect to if they attempt to log in from
 * an unsupported institution.
 * User: adam
 * Date: 9/12/15
 * Time: 5:19 PM
 */
@extends('layouts.master')

@section('pageTitle', 'Grade Exam')
@section('description', 'Grade an exam')
@section('cssLinks')

@endsection

@section('body')
    <div class="container">
        We are sorry. The gradeomatic is only available to teachers from the following institutions.
        <div id="permittedInstitutions">

        </div>
        <div id="notificationSignUp">
            If you would like to be notified, when access is expanded please fill out the following
            {!! Form::open(['url' => 'interestedTeacher', 'method' => 'post']) !!}
            <p>
                {!! Form::text('email', 'example@yourInstitution.edu') !!}
            </p>

            {!! Form::close() !!}
        </div>
    </div>

@endsection