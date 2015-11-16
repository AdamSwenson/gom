@extends('layouts.master')

@section('pageTitle', 'Help | gradeomatic')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/help-styles.css') }}"/>
@endsection

@section('body')
    <div class="row">
        <div class="col-md-9" role="main">
            @yield('mainText')
        </div>

        <div class="col-md-3" role="complementary" >
            <nav class="hidden-print hidden-xs hidden-sm affix">
                <ul class="nav nav-stacked fixed docs-sidebar" id="sidebar">
                    <li>
                        <ul class="nav nav-stacked">
                            <li><a href="{{ url('info/faq') }}#faq">FAQ</a></li>
                            <li><a href="{{ url('info/instructions') }}">Instructions</a></li>
                            <li><a href="{{ url('info/tutorials') }}">Video tutorials</a></li>
                        </ul>
                    </li>


                    @yield('sideNav')

                </ul>
            </nav>
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


