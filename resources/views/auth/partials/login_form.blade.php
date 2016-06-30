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
 */ ?>
<div class="row">
    <div class="col-xs-3"></div>
    <form role="form" id="loginForm" method="POST" action="{{url('/auth/login')}}" accept-charset="UTF-8" class="col-xs-6">
        {!! csrf_field() !!}
        <h3 class="text-left">Login</h3>

        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Enter password">
        </div>

        <div class="row">
            <div class="col-xs-4">
                <label class="checkbox-inline">
                    <input type="checkbox" id="remember" name="remember"> Remember me
                </label>
            </div>

            <div class="col-xs-4"></div>

            <div class="col-xs-4 verticallyAligned">
                <span class="">
                    <a href={{url('password/email')}}>Forgot Password</a>
                    </span>
            </div>
        </div>
</div>
<br/>
<input id="login"
       class="btn btn-primary"
       value="Log In"
       type="submit">
</form>
<div class="col-xs-3"></div>
</div>

