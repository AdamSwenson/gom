<?php
/**
 * This is the common login area that can be included on the home page
 * or on its own page
 *
 *
 * Created by PhpStorm.
 * User: adam
 * Date: 8/7/15
 * Time: 10:15 AM
 */?>



<form method="POST" action="{{url('/auth/login')}}" accept-charset="UTF-8" class="form-horizontal col-xs-4">
    {!! csrf_field() !!}
    <div class="form-group">
        <div class="col-xs-8">
            <label>Email</label>
            <input class="form-control" type="email" name="email"  placeholder="Enter email">
        </div>
    </div>
    <div class="form-group">

        <div class="col-xs-8">
            <label>Password</label>
            <input class="form-control" type="password" name="password" placeholder="Enter password">
        </div>
    </div>
    <div class="checkbox">
        <label><input type="checkbox"> Remember me</label>
        <label><a href={{url('password/email')}}>Forgot Password</a></label>
    </div>
    <input class="btn btn-primary" value="Log In" type="submit" >
</form>

