@extends('layouts.master')

@section('pageTitle', 'Welcome to Grade-O-Matic')

@section('cssLinks')


@endsection

@section('body')
    <script>
        //these elements exist in the nav_bar_main.blade.php
        document.getElementById('setupHead').setAttribute('class', "");
        document.getElementById('gradeHead').setAttribute('class', "");
        document.getElementById('reportHead').setAttribute('class', "");
        document.getElementById('accountHead').setAttribute('class', "active");
    </script>
    <div id="pageContainer">
        <div id="container" class="container">
            <div class="row">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="list-group">
                            <a href="#" class="list-group-item"><h4>Preferences</h4></a>
                            <a href="#" class="list-group-item"><h4>Security</h4></a>
                            <a href="#" class="list-group-item"><h4>Payment</h4></a>
                            <a href="#" class="list-group-item"><h4>Upgrade</h4></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
            </div>
        </div>
    </div>
@endsection

@section('jsArea')

    <script type="text/javascript">
        $(document).ready(function () {
            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */

        });
    </script>
@endsection