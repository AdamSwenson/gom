@extends('layouts.master')

@section('pageTitle', 'Help | gradeomatic')

@section('cssLinks')
<link rel="stylesheet" href="{{ asset('css/help-styles.css') }}" />
@endsection

@section('body')
<div id="faq">
    <h3><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Gradeomatic FAQ</h3>

    <div class="well">
        @include('other.help_components.faq')
    </div>
</div>

<div id="help">
    <h3><span class="glyphicon glyphicon-apple" id="help" aria-hidden="true"></span> Gradeomatic Help</h3>

    <div class="well">
        @include('other.help_components.overview')
    </div>
</div>
@endsection


@section('jsArea')
    <script type="text/javascript">
        // set 'Account' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navHelp').attr('class', 'active');
    </script>

@endsection


