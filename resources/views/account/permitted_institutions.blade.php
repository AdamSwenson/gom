<?php
/** This is the page which a user will be redirect to if they attempt to log in from
 * an unsupported institution.
 * User: adam
 * Date: 9/12/15
 * Time: 5:19 PM
 */ ?>

@extends('layouts.master')

@section('pageTitle', 'Get notified')
@section('cssLinks')

@endsection

@section('body')
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <h4>
                We are sorry. The gradeomatic is presently only available to teachers from the following institutions:
            </h4>

            <ul id="permittedInstitutions">
                <li>California State University, Northridge</li>
            </ul>

            <div id="notificationSignUp">
                <p>If you would like to be notified when access is expanded, please provide your name and email
                    address</p>
                {!! Form::open(['url' => '/registrationRestrictions', 'method' => 'post']) !!}

                {{ csrf_field() }}

                <div class="form-group ">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" type="text" name="name" value=""
                           placeholder="Dr. Jill Smith">
                </div>

                <div class="form-group ">
                    <label for="email">Email (required)</label>
                    <input class="form-control"
                           id="email"
                           type="email"
                           name="email"
                           value="{{ $email }}"
                           placeholder="jill@PlaceWherePeopleLearn.edu">
                </div>
                <div class="form-group ">
                    <input name="institutionType" type="hidden" id="institutionType"/>

                    <div class="btn-group btn-group">
                        <button class="btn btn-default dropdown-toggle" id="institutionSelect"
                                title="Type of institution"
                                data-toggle="dropdown"> Your institution <span
                                    class="glyphicon glyphicon-menu-down"></span>
                        </button>
                        <ul class="dropdown-menu list-group" id="institutionList" role="menu" style="cursor:pointer;">
                            <li class="list-group-item">University / college</li>
                            <li class="list-group-item">Junior college</li>
                            <li class="list-group-item">Technical school</li>
                            <li class="list-group-item">High school</li>
                            <li class="list-group-item">Middle school</li>
                            <li class="list-group-item">Other</li>
                        </ul>
                    </div>
                </div>

                <input class="btn btn-primary" value="Notify me when access is expanded" type="submit">

                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>

@endsection

@section('jsArea')
    <script type="text/javascript">
        var activeTab = '';
    </script>
    <script type="text/javascript" src="{{ asset('js/restricted-registration-package.js') }}"></script>
@endsection