<!-- Generic nav bar template used by all pages once logged in. The active tab is set in JS by the page -->
{{--
<style>
    li:hover {
        background-color: #393939;
    }
</style>
--}}
<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('home/') }}"><span class="standard">GradeOmatic</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li id="navSetup">
                    <a href="{{url('setup')}}">Setup</a>
                </li>
                <li id="navGrade">
                    <a href="{{url('grade')}}">Grade</a>
                </li>
                <li id="navReport">
                    <a href="{{url('report')}}">Reports</a>
                </li>
                <li id="navAccount">
                    <a href="{{url('account')}}">Account</a>
                </li>
                <li id="navLogout">
                    <a href="{{url('auth/logout')}}">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</div>