<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 5:51 PM
 */

 this layout creates the new title and nav bar with basic bootstrap styling -->
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><span class="standard">Grade-o-Matic</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li id="setupHead">
                    <a href="{{url('setup')}}">Setup</a>
                </li>
                <li>
                    <a href="{{url('grade')}}">Grade</a>
                </li>
                <li id="reportHead">
                    <a href="{{url('report')}}">Reports</a>
                </li>
                <li id="accountHead">
                    <a href="{{url('account/home')}}">Account</a>
                </li>
            </ul>
        </div>
    </div>
</div>