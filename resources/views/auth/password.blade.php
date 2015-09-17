<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/6/15
 * Time: 6:38 PM
 */ ?>

@extends('layouts.master')
@section('title')
    Reset your password
@endsection

@section('body')
    <div class="row">
    <form role="form" method="POST" action="{{url('/password/email')}}" accept-charset="UTF-8" class="col-xs-4">
        {!! csrf_field() !!}
        <h3 class="text-left"> Create Account</h3>

        <div class="form-group ">
            <input class="form-control" type="email" name="email" placeholder="Enter email">
        </div>

        <input class="btn btn-default" value="Send Password Reset Link" type="submit">
    </form>
    </div>
@endsection
