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
        <div class="col-md-4"></div>
        <div class="col-md-4 text-justify">
            <h3><span class="glyphicon glyphicon-earphone"></span> Contact</h3>

            <p>You can contact us at {{ env('CONTACT_EMAIL') }}.</p>

            <p>We will make every effort to reply as quickly as we can. But please be aware that, right now, we have no
                employees. So it is unlikely that we will reply right away. </p>
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection


@section('jsArea')
    <script>
        var activeTab = 'navHelp';
    </script>
    <script src="{{ asset('js/common-package.js') }}"></script>

@endsection