<div id="navBar">
    <div id="navmenu">
        <hr/>
        <div class="navBarItem">
            <ul id="accountLinks" class="navMenuItem">
                <li>
                    <a href="#">Account</a>
                    @include('navigation.nav_account')
                </li>
            </ul>

            <ul id="otherLinks" class="navMenuItem">
                <li>
                    <a href="#">Other</a>
                    @include('navigation.nav_other')
                </li>
            </ul>

            <ul id="setupLinks" class="navMenuItem">
                <li>
                    <a href="#">Exam setup</a>
                    @include('navigation.nav_setup')
                </li>
            </ul>

            <ul id="feedbackLinks" class="navMenuItem">
                <li>
                    <a href="#">Feedback</a>
                    @include('navigation.nav_report')
                </li>
            </ul>

            <ul id="gradex" class="navMenuItem">
                <li>
                    <a href="#">Grade exams</a>
                    @include(('navigation.nav_input'))
                </li>
            </ul>
        </div>
        <hr/>
    </div>
</div>