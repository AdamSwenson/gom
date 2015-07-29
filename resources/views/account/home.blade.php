@extends('layouts.master')

@section('pageTitle', 'Welcome to the gradeomatic')

@section('cssLinks')

 <!-- styles for jsArea(the top bar of the webpage-->
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/navMenuStyles.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/standardStyles.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("inc/css/examCreateStyles.css")}}"/>

  <!--styles for the rest of the webpage -->
    <link href="{{asset('inc/css/landing.css')}}" type="text/css" rel="stylesheet"/>
    <link href="{{asset('inc/css/indexStyle.css')}}" type="test/css" rel="stylesheet"/>
@endsection

@section('body')
    <div id="pageContainer">
        <div id="container" class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 id="GradeomaticHomeTitle" class="text-left">Gradeomatic</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 btn-group">
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Home</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Payment</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Guides</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Features</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg ">News</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">About Us</a>
                    <a href="{{url('home')}}" type="button" class="btn btn-primary btn-lg">Help</a>
                </div>
            </div>
                <div class="container">
                        <div class="row" >
                            <div class="col-xs-12">
                        <div class="panel panel-default">
                            <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#Home">Home</a></li>
                            <li><a data-toggle="tab" href="#profile">Profile</a></li>
                            <li><a data-toggle="tab" href="#examMenu">Exams</a></li>
                            <li><a data-toggle="tab" href="#questionMenu">Questions</a></li>
                            <li><a data-toggle="tab" href="#elementsMenu">Elements</a></li>
                            <li><a data-toggle="tab" href="#studentsMenu">Students</a></li>
                        </ul>
                            <div class="tab-content">
                            <div id="profile" class="tab-pane fade">
                                <div class="list-group">
                                    <a href="#" class="list-group-item"><h4>Preferences</h4></a>
                                    <a href="#" class="list-group-item"><h4>Security</h4></a>
                                    <a href="#" class="list-group-item"><h4>Payment</h4></a>
                                    <a href="#" class="list-group-item"><h4>Upgrade</h4></a>
                                </div>
                            </div>
                            <div id="examMenu" class="tab-pane fade">
                                <!--
                                This is the exams menu with the folloing options
                                    -Create exam
                                    -Edit exam
                                    -Clone exam
                                    -Delete Exam
                                -->
                                <h3>Exams</h3>
                                <p>You can add, edit or delete Exams here.</p>
                                <div class="list-group">
                                    <!-- Create menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#examListAdd" data-parent="#examAction">
                                        <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Exam </h4></a>
                                    <div id="examListAdd" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <h4> Add an Exam to the list of Exams:</h4>
                                                <form role="form" class="form">

                                                    <div class="row">
                                                    <div class="col-xs-4">
                                                        <input type="text"  placeholder="Exam Name" class="form-control">
                                                    </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Exam Type
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('examType').setAttribute('value','Multiple Choice')">Multiple Choice</a></li>
                                                                    <li><a onClick="document.getElementById('examType').setAttribute('value','Essay')">Essay</a></li>
                                                                    <li><a onClick="document.getElementById('examType').setAttribute('value','Short Answer')">Short Answer</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="examType" type="text" disabled placeholder="Exam Type" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-xs-2">
                                                        <button type="submit" class="form-control">Create Exam</button>
                                                        <label>This will add an exam with empty questions to the database</label>
                                                    </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Edit menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#examListEdit" data-parent="#examAction">
                                        <h4><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Exam</h4></a>
                                    <div id="examListEdit" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Edit an exam From the List of Exams:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Exam Type
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('examNameEdit').setAttribute('value','Exam1')">Exam1</a></li>
                                                                    <li><a onClick="document.getElementById('examNameEdit').setAttribute('value','Exam2')">Exam2</a></li>
                                                                    <li><a onClick="document.getElementById('examNameEdit').setAttribute('value','Exam3')">Exam3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="examNameEdit" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <button type="submit" class="form-control">Finish Edit</button>
                                                            <label>This will make finalize the changes to your exam</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- clone menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#examListClone" data-parent="#examAction">
                                        <h4><span class="glyphicon glyphicon-copy" aria-hidden="true"></span>Clone Exam</h4></a>
                                    <div id="examListClone" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Clone an exam in the List of Exams:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Exam Type
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('examNameClone').setAttribute('value','Exam1')">Exam1</a></li>
                                                                    <li><a onClick="document.getElementById('examNameClone').setAttribute('value','Exam2')">Exam2</a></li>
                                                                    <li><a onClick="document.getElementById('examNameClone').setAttribute('value','Exam3')">Exam3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="examNameClone" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <button type="submit" class="form-control">Clone Exam</button>
                                                            <label>This will add a copy of this exam into the database</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete menu -->
                                    <a id="deleteExamLink" class="list-group-item" data-toggle="collapse" data-target="#examListDelete" data-parent="#examAction">
                                        <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete Exam</h4></a>

                                    <div id="examListDelete" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Delete an exam in the List of Exams:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Exam Type
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('examNameDelete').setAttribute('value','Exam1')">Exam1</a></li>
                                                                    <li><a onClick="document.getElementById('examNameDelete').setAttribute('value','Exam2')">Exam2</a></li>
                                                                    <li><a onClick="document.getElementById('examNameDelete').setAttribute('value','Exam3')">Exam3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="examNameDelete" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <button type="submit" class="form-control">Delete Exam</button>
                                                            <label>This removes the selected exam from the Database</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!--
                                  This is the  menu with the following options
                                      -Create Questions
                                      -Edit Questions
                                      -Clone Questions
                                      -Delete Questions
                                  -->
                            <div id="questionMenu" class="tab-pane fade">
                                <h3>Questions</h3>
                                <p>You can add, edit or delete questions for your exams here.</p>
                                <div class="list-group">
                                    <!-- Create menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#questionListAdd" data-parent="#questionAction">
                                        <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Question </h4></a>
                                    <div id="questionListAdd" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <h4> Add an Question to an Exam:</h4>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input type="text"  placeholder="Question Name" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Question Type
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('questionType').setAttribute('value','Multiple Choice')">Multiple Choice</a></li>
                                                                    <li><a onClick="document.getElementById('questionType').setAttribute('value','Essay')">Essay</a></li>
                                                                    <li><a onClick="document.getElementById('questionType').setAttribute('value','Short Answer')">Short Answer</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="questionType" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <button type="submit" class="form-control">Create Question</button>
                                                            <label>This will add an empty question to the database</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Edit menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#questionListEdit" data-parent="#questionAction">
                                        <h4><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Question</h4></a>
                                    <div id="questionListEdit" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Edit an question from the Database:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Questions
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('questionNameEdit').setAttribute('value','Question1')">Question1</a></li>
                                                                    <li><a onClick="document.getElementById('questionNameEdit').setAttribute('value','Question2')">Question2</a></li>
                                                                    <li><a onClick="document.getElementById('questionNameEdit').setAttribute('value','Question3')">Question3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="questionNameEdit" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <button type="submit" class="form-control">Finish Edit</button>
                                                            <label>This will make finalize the changes to your question</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- clone menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#questionListClone" data-parent="#questionAction">
                                        <h4><span class="glyphicon glyphicon-copy" aria-hidden="true"></span>Clone Question</h4></a>
                                    <div id="questionListClone" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Clone an Question in Database:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Questions
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('questionNameClone').setAttribute('value','Question1')">Question1</a></li>
                                                                    <li><a onClick="document.getElementById('questionNameClone').setAttribute('value','Question2')">Question2</a></li>
                                                                    <li><a onClick="document.getElementById('questionNameClone').setAttribute('value','Question3')">Question3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="questionNameClone" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <button type="submit" class="form-control">Clone Question</button>
                                                            <label>This will add a copy of this exam into the database</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete menu -->
                                    <a id="deleteQuestionLink" class="list-group-item" data-toggle="collapse" data-target="#questionListDelete" data-parent="#questionction">
                                        <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete Exam</h4></a>

                                    <div id="questionListDelete" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Delete an Question in the database:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Questions
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('questionNameDelete').setAttribute('value','Question1')">Question1</a></li>
                                                                    <li><a onClick="document.getElementById('questionNameDelete').setAttribute('value','Question2')">Question2</a></li>
                                                                    <li><a onClick="document.getElementById('questionNameDelete').setAttribute('value','Question3')">Question3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="questionNameDelete" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <button type="submit" class="form-control">Delete Question</button>
                                                            <label>This removes the selected question from the Database</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!--
                                 This is the  menu with the following options
                                     -Create Questions
                                     -Edit Questions
                                     -Clone Questions
                                     -Delete Questions
                                 -->
                            <div id="elementsMenu" class="tab-pane fade">
                                <h3>Elements</h3>
                                <p>You can add, edit or delete elements here.</p>
                                <div class="list-group">
                                    <!-- Create menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#elementListAdd" data-parent="#elementAction">
                                        <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Element </h4></a>
                                    <div id="elementListAdd" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <h4> Add an Element to database:</h4>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input type="text"  placeholder="Element Name" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="row">
                                                                <div class="col-xs-8">
                                                                    <label for="comment">Element Response:</label>
                                                                    <textarea class="form-control" rows="5" id="comment"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <button type="submit" class="form-control">Create Element</button>
                                                            <label>This will add an comment to the database</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Edit menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#elementListEdit" data-parent="#elementAction">
                                        <h4><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Element</h4></a>
                                    <div id="elementListEdit" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Edit an Element:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Elements
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('elementNameEdit').setAttribute('value','Element1')">Element1</a></li>
                                                                    <li><a onClick="document.getElementById('elementNameEdit').setAttribute('value','Element2')">Element2</a></li>
                                                                    <li><a onClick="document.getElementById('elementNameEdit').setAttribute('value','Element3')">Element3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="elementNameEdit" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                            <label for="comment">Element Response:</label>
                                                            <textarea class="form-control" rows="5" id="comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <button type="submit" class="form-control">Finish Edit</button>
                                                            <label>This will make finalize the changes to your question</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- clone menu -->
                                    <a class="list-group-item" data-toggle="collapse" data-target="#elementListClone" data-parent="#elementAction">
                                        <h4><span class="glyphicon glyphicon-copy" aria-hidden="true"></span>Clone Element</h4></a>
                                    <div id="elementListClone" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Clone an Element in Database:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Elements
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('elementNameClone').setAttribute('value','Element1')">Element1</a></li>
                                                                    <li><a onClick="document.getElementById('elementNameClone').setAttribute('value','Element2')">Element2</a></li>
                                                                    <li><a onClick="document.getElementById('elementNameClone').setAttribute('value','Element3')">Element3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="elementNameClone" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <button type="submit" class="form-control">Clone Element</button>
                                                            <label>This will add a copy of this element.</label>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete menu -->
                                    <a id="deleteElementLink" class="list-group-item" data-toggle="collapse" data-target="#elementListDelete" data-parent="#elementAction">
                                        <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete Element</h4></a>

                                    <div id="elementListDelete" class="sublinks collapse">
                                        <div class="list-group-item">
                                            <div class="container">
                                                <label>Delete an Question in the database:</label>
                                                <form role="form" class="form">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Elements
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onClick="document.getElementById('elementNameDelete').setAttribute('value','element1')">Element1</a></li>
                                                                    <li><a onClick="document.getElementById('elementNameDelete').setAttribute('value','element2')">Element2</a></li>
                                                                    <li><a onClick="document.getElementById('elementNameDelete').setAttribute('value','element3')">Element3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <input id="elementNameDelete" type="text" disabled class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <button type="submit" class="form-control">Delete Element</button>
                                                            <label>This removes the selected question from the Database</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!--
                                 This is the  menu with the following options
                                     -Create Questions
                                     -Edit Questions
                                     -Clone Questions
                                     -Delete Questions
                                 -->
                            <div id="studentsMenu" class="tab-pane fade">
                                    <h3>Students</h3>
                                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                </div>
                            <div id="Home" class="tab-pane fade in active">
                                    <h3>Tasks</h3>
                                <a href="{{url('select')}}" type="button" class="btn btn-primary btn-lg">Exam Setup Wizard</a><br>
                                <label> See your list of Exams:</label><br>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Exams
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Exam1</a></li>
                                        <li><a href="#">Exam2</a></li>
                                        <li><a href="#">Exam3</a></li>
                                    </ul>
                                </div>
                                </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-xs-4">
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('jsArea')
    <script type="text/javascript" src="<?php echo asset("inc/js/common.js");?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var scripts = [
                "inc/js/common.js",
                "inc/js/examSetup.js"
            ];

            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */
            function onLoad() {
                $('.navMenuItem').menu();
                $('.prettyButton').button();
                bindListeners();
                console.log('onload fired');
            }

            onLoad();
//                    scriptLoader(scripts.length, 0);
        });
    </script>

@endsection
@endsection