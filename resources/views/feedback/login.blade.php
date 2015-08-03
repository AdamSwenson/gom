<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 9:12 PM
 */?>
@extends('layouts.master')

@section('body')
    <form id="feedbackLogin" method="post" action="{{ url('feedback/login') }}" accept-charset="UTF-8">
    <fieldset>
        <legend class="displayBig">Log In</legend>
        <label for="lookup" class="displayBig">Access key:</label>
        <input type="text" name="lookup" class="displayBig" /><br />
        <label for="accessKey" class="displayBig">Access code:</label>
        <input type="text" id="accessKey" name="accessKey" class="displayBig"/>
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

