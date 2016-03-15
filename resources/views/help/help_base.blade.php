@extends('layouts.master')

@section('pageTitle', 'Help | gradeomatic')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/help-styles.css') }}"/>
@endsection

@section('body')
    <div class="row">
        <div class="col-md-10" role="main">
            @yield('mainText')
        </div>

        <div class="col-md-2" role="complementary">
            <nav class="hidden-print hidden-xs hidden-sm affix">
                <ul class="commonLinks">
                    <li><a href="{{ url('info/faq') }}#faq">FAQ</a></li>
                    <li><a href="{{ url('info/instructions') }}">Instructions</a></li>
                    <li><a href="{{ url('info/tutorials') }}">Video tutorials</a></li>
                </ul>

                <ul class="nav nav-stacked fixed docs-sidebar" id="sidebar">

                    @yield('sideNav')

                </ul>
            </nav>
        </div>
    </div>

    @include('help.partials.picture_modal')

@endsection


@section('jsArea')
    <script type="text/javascript">
        var activeTab = '';
    </script>
    <script type="text/javascript" src="{{ asset('js/help-package.js') }}"></script>
@endsection