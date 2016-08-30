<div class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="standard" style="color: white;">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> gradeomatic |
                <small>
                    grade faster. teach better.
                </small>
                </span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li id="navHelp" title="About">
                    <a href="{{url('help')}}" style="color:white;">What Is This?</a>
                </li>
                <li id="navSetup" title="Sign up for gradeomatic">
                    <a href="{{url('register')}}" style="color:white;">Sign Up</a>
                </li>
                <li id="navGrade" title="Log in to gradeomatic">
                    <a href="{{url('login')}}" style="color:white;">Log In</a>
                </li>
            </ul>
        </div>
    </div>
</div>