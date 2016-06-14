<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/6/15
 * Time: 6:38 PM
 */ ?>

@extends('layouts.master')
@section('pageTitle', 'Reset Password | gradeomatic')
@section('description', 'Reset your password')

@section('body')
    <div class="row">
        <div class="col-xs-3"></div>
        <form role="form" method="POST" action="{{url('/password/email')}}" accept-charset="UTF-8" class="col-xs-6">
            {!! csrf_field() !!}
            <h3>Reset Password</h3>

            <div class="form-group ">
                <input id="email" class="form-control" type="email" name="email" placeholder="Enter email">
            </div>

            <input id="submit" class="btn btn-primary" value="Send Email" type="submit">
        </form>
        <div class="col-xs-3"></div>
    </div>
@endsection
