<!-- general nav bar -->
<style>
    li:hover {
        background-color: #E9E9E9;
    }
</style>
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('home/') }}"><span class="standard">Grade-o-Matic</span></a>
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
                    <a href="{{url('account/home')}}">Account</a>
                </li>
                <li id="navLogout">
                    <a href="{{url('auth/logout')}}">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</div>