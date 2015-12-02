<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 10/4/2015
 * Time: 5:33 PM
 */
-->
@extends('layouts.master')

@section('pageTitle', 'Contact | gradeomatic')

@section('cssLinks')

@endsection

@section('body')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3><span class="glyphicon glyphicon-earphone"></span> Contact</h3>

            <p>You may contact us at {{ env('CONTACT_EMAIL') }}.</p>

            <p>We will make every effort to reply as quickly as we can.</p>
            <p>But please be aware that, right now, we have no
                employees. So it is unlikely that we will reply right away. </p>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection


@section('jsArea')


@endsection