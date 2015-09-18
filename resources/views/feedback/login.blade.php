<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 9:12 PM
 */?>
@extends('layouts.primalMaster')

@section('body')

    <form id="feedbackLogin" method="post" action="{{ url('feedback/login') }}" accept-charset="UTF-8">
    <fieldset>
        <legend class="displayBig">Log in to view your feedback</legend>
        @include('errors.list')

        <label for="accessKey" class="displayBig">Please enter the access key which was emailed to you</label><br/>
        <input type="text" id="accessKey" name="accessKey" class="displayBig"/>
        <input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">
    </fieldset>
    <input type="submit" id="submitButton" value="Log In" class="displayBig" name="submit" />
</form>
@endsection

@section('jsArea')
    <script type="javascript/text">
        $(document).ready(function(){
            $('#submitButton').button();
        });
    </script>
@endsection

