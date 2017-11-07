<!-- Generic nav bar template used by all pages once logged in. The active tab is set in JS by the page -->
<nav id="topNavbar"
     class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">

        <div class="navbar-header">
            @include('navigation.partials.navigation_toggle')
            @include('navigation.partials.brand')
        </div>

        <div class="collapse navbar-collapse"
             id="navbar-ex-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li id="navSetup"
                    title="Create or edit an exam1">
                    <a href="{{url('exam1')}}"
                       class="navItem"><span class="linkText">Setup</span></a>
                </li>

                <li id="navGrade"
                    title="Grade an exam1">
                    <a href="{{url('grade')}}"
                       class="navItem"><span class="linkText">Grade</span></a>
                </li>

                <li id="navReport"
                    title="Reports, Analytics and Student Feedback">
                    <a href="{{url('report')}}"
                       class="navItem"><span class="linkText">Reports</span></a>
                </li>

                <li id="navHelp"
                    title="Help"
                    role="presentation"
                    class="dropdown"
                >
                    <a class="dropdown-toggle navItem"
                       data-toggle="dropdown"
                       href="#"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('help') }}">Help</a>
                        </li>
                        <li>
                            <a href="{{ url('info/faq') }}#faq">FAQ</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="{{ url('info/instructions') }}">Instructions</a>
                        </li>
                        <li>
                            <a href="{{ url('info/tutorials') }}">Video tutorials</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="{{ url('contact') }}">Contact</a>
                        </li>
                        <li>
                            <a href="{{ url('about') }}">About</a>
                        </li>
                    </ul>
                </li>

                <li id="navLogout">
                    @include('navigation.partials.logout')
                </li>
            </ul>
        </div>
    </div>
</nav>