<!DOCTYPE html>
<html>
    <head>
        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="<?php echo asset('css/landing.css'); ?>" type="text/css" />
</head>
<body>
<div id="pageContainer">

<div id="container">
<div id="test">Test</div>
    <div id="navarea">
        <div class="navs">
            <h3>Get started</h3>
            <ul>
                <li><a href="<?php  ?>">Sign up</a></li>
                <li><a href="<?php  ?>">Login</a></li>
            </ul>
        </div>
        <div class="navs">
            <h3>Guides and the future</h3>
            <ul>
                <li><a href="<?php  ?>">Instructions</a></li>
                <li><a href="<?php  ?>">Announcements</a></li>
                <li><a href="<?php  ?>">Known bugs</a></li>
                <li><a href="<?php  ?>">History of the gradeomatic</a></li>
            </ul>
        </div>

        <div class="navs">
            <h3>Setup an exam</h3>
            <ul>
                <li>Wizard</li>
                <li><a href="{{url('setup/exam')}}">Create the exam</a> <span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <li><a href="{{url('setup/question')}}">Create and edit questions</a> <span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <!--                        <li><a href="--><?php ////_H(\classes\Navigation::EXAMPOPULATE); ?><!--">Populate exam with questions</a> <span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>-->
                <li><a href="{{url('setup/element')}}">Create and edit comments</a> <span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <!--                        <li><a href="--><?php ////_H(\classes\Navigation::COMMENTASSIGN); ?><!--">Assign comments to exam</a> <span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>-->
                <li><a href="<?php  ?>">Upload your roster</a> <span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
            </ul>
        </div>
        <div class="navs">
            <h3>Grade an exam</h3>
            <ul>
                <li><a href="<?php  ?>">Choose an exam for grading</a><span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <li><a href="<?php ?>">Grade it</a><span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <li><a href="<?php  ?>">Assign grades</a><span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <li><a href="<?php ?>">Release comments to students </a><span
                            class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
            </ul>
        </div>
        <div class="navs">
            <h3>Quality control</h3>
            <ul>
                <li><a href="<?php ?>">Detect errors in grading</a><span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
                <li><a href="<?php  ?>">Assessment tools </a><span class="ui-icon ui-icon-locked" style="display: inline-block"></span></li>
            </ul>
        </div>
    </div>
</div>
</div>
</body>
</html>