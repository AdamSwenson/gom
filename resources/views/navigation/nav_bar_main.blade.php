<!-- Generic nav bar template used by all pages once logged in. The active tab is set in JS by the page -->

<style>
    li:hover {
        background-color: #393939;
    }
</style>

<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}" style="color:white;">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> gradeomatic</span>
                | <small>grade faster. teach better.</small>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li id="navSetup" title="Create or edit an exam">
                    <a href="{{url('exam')}}" style="color:white;">Setup</a>
                </li>
                <li id="navGrade" title="Grade an exam">
                    <a href="{{url('grade')}}" style="color:white;">Grade</a>
                </li>
                <li id="navReport" title="Reports, Analytics and Student Feedback">
                    <a href="{{url('report')}}" style="color:white;">Reports</a>
                </li>
                <li id="navHelp" title="Help">
                    <a href="{{url('help')}}" style="color:white;"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
                </li>
                <li id="navAccount">
                    <a href="{{url('account')}}" title="Account & Settings " style="color:white;">
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                </li>
                <li id="navLogout">
                    <a href="{{url('auth/logout')}}" title="Log Out" style="color:white;">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</div>