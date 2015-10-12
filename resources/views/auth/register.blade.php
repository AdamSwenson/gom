@extends('layouts.master')

@section('pageTitle', 'Sign Up | gradeomatic')
@endsection

@section('description', 'Sign up for gradeomatic')
@endsection

@section('body')
    <div class="row">
        <div class="col-xs-3"></div>
        <form role="form" method="POST" action="{{url('auth/register')}}" accept-charset="UTF-8" class="col-xs-6">
            {!! csrf_field() !!}
            <h3 class="text-left"> Create Account</h3>

            <div class="form-group ">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}"
                       placeholder="Username">
            </div>
            <div class="form-group ">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}"
                       placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input class="form-control" type="password" name="password" id="pwd" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="pwd_conf">Confirm Password</label>
                <input class="form-control" type="password" name="password_confirmation" id="pwd_conf"
                       placeholder="Confirm password">
            </div>

            <input class="btn btn-primary" value="Create Account" type="submit">
        </form>
        <div class="col-xs-3"></div>
    </div>
@endsection