<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/6/15
 * Time: 6:41 PM
 */ ?>
@extends('layouts.master')
@section('pageTitle', 'Reset Password | gradeomatic')

@section('body')
    <div class="row">
        <form role="form" method="POST" action="{{url('password/reset')}}" accept-charset="UTF-8" class="col-xs-4">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            <h3 class="text-left"> Reset your password</h3>

            <div class="form-group ">
                <input class="form-control"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Enter email">
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="password" id="pwd" placeholder="Enter new password">
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="password_confirmation" id="pwd_conf"
                       placeholder="Confirm new password">
            </div>

            <input class="btn btn-default" value="Reset Password" type="submit">
        </form>
    </div>
@endsection