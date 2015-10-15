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
                    <input class="form-control" id="email" type="email" name="email" value="{{ $email or '' }}"
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
                        <ul class="dropdown-menu" id="institutionList" role="menu" style="cursor:pointer;">
                            <li>University / college</li>
                            <li>Junior college</li>
                            <li>Technical school</li>
                            <li>High school</li>
                            <li>Middle school</li>
                            <li>Other</li>
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
        $(document).ready(function () {
            $('#institutionList li').bind('click', function () {
                $('#institutionType').val($(this).text());
                var $institution = $('#institutionSelect');
                var $icon = $institution.find('span');
                $institution.text($(this).text());
                $institution.append(" ");
                $institution.append($icon);
            });
        });
    </script>
@endsection