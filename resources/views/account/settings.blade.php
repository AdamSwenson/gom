@extends('layouts.master')

@section('pageTitle', 'Settings | gradeomatic')

@section('cssLinks')

@endsection

@section('body')
        <h3><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Account & Settings</h3>

        <div class="list-group">
            <a class="list-group-item">
                <h4 class="list-group-item-heading"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    Preferences
                </h4>
                <p class="list-group-item-text">Gradeomatic settings</p>
            </a>
            <a class="list-group-item">
                <h4 class="list-group-item-heading"><span class="glyphicon glyphicon-tower" aria-hidden="true"></span>
                    Security
                </h4>
                <p class="list-group-item-text">Security & access options</p>
            </a>
            <a class="list-group-item">
                <h4 class="list-group-item-heading"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                    Payment
                </h4>
                <p class="list-group-item-text">Payment details</p>
            </a>
            <a class="list-group-item">
                <h4 class="list-group-item-heading"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                    Upgrade
                </h4>
                <p class="list-group-item-text"></p>
            </a>
        </div>
@endsection

@section('jsArea')

    <script type="text/javascript">
        // set 'Account' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navAccount').attr('class', 'active');

        $(document).ready(function () {
            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */

        });
    </script>
@endsection