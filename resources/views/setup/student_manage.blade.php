@extends('layouts.master')

@section('pageTitle', 'Manage Students')

@section('cssLinks')
    <link href="<?php echo asset('inc/css/navMenuStyles.css');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/standardStyles.css");?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/examManagerStyles.css");?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/studentmanager.css");?>" type="text/css" rel="stylesheet"/>
@endsection

@section('body')
    @include("layouts.topbar")
    <div class="pageComponent">


        <div id="bodymain">

            <div class='completedMessage'></div>
            <div class='hideOnComplete'>
                <div id="instructions" class='pageComponent'>
                    <p class='instructions'>
                        Many many many instructions go here.
                    </p>

                    <div class="pageTable">
                        <table id='dataTypes'>
                            <thead>
                            <tr>
                                <th>Field name</th>
                                <th>Value type</th>
                                <th>Description</th>
                                <th>Max size</th>
                                <th>Example</th>
                                <th>Required?</th>
                                <th>Unique?</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>student_id</td>
                                <td>Integer</td>
                                <td>A uniquely identifying number.</td>
                                <td>11 digits</td>
                                <td>91245214</td>
                                <td>Yes</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>student_name</td>
                                <td>Letters and punctation</td>
                                <td>The student's name. Format: Lastname, Firstname</td>
                                <td>200 characters</td>
                                <td>Smith, Jill</td>
                                <td>Yes</td>
                                <td>No</td>
                            </tr>

                            <tr>
                                <td>email</td>
                                <td>Letters and punctation</td>
                                <td>The student's email address.</td>
                                <td>200 characters</td>
                                <td>fake@fake.com</td>
                                <td>Yes</td>
                                <td>No</td>
                            </tr>
                            <tr>
                                <td>class_nickname</td>
                                <td>Letters and numbers</td>
                                <td>A nickname by which to identify this class (e.g., course and section) in your
                                    records
                                </td>
                                <td>100 characters</td>
                                <td>Phil360sec1</td>
                                <td>No</td>
                                <td>No</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>Tooltips: <br/>
                        Unique: No two records can have the same value.<br/>
                        Required: Every record must have a value.<br/>

                        If you do not want the gradeomatic to email comments to students, just put a dummy email address
                        for all students
                    </p>

                    <p>
                        Link to sample csv file goes here.
                    </p>
                </div>
                <div class="pageComponent">
                    <form enctype="multipart/form-data" method="post" action='{{$_SERVER['PHP_SELF']}}; ?>' role="form">
                        <div class="form-group">
                            <input type="hidden" name="task" value="uploadStudents"/>

                            <div id="fileSelection" class="formArea">
                                <label for="exampleInputFile">Select file to upload</label><br/>
                                <input type="file" class="prettyButton" name="file" id="file" size="150">
                            </div>
                            <div id="buttonArea" class="formArea">
                                <button type="submit" class="prettyButton" name="Import" value="Import">Upload</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div id="errorArea">
                    {{--status = {{$status or ''}}--}}
                    <p>
                        {{--{{$errors or ''}}--}}
                    </p>
                </div>

                <div id="studentRecords" class="pageComponent">
                    <div class="pageTable">
                        <table id="allStudents" class="display" cellspacing="0">
                            <caption>Students associated with the current exam</caption>
                            <thead>
                            <tr>
                                <th>Class Nickname</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>



@section('jsArea')
    <?php
    $jc = new \PageToolClasses\JQueryPlugins();
    $jc->jCookie();
    $jc->dataTablesLoad();
    ?>
    <script type="text/javascript" src="{{asset("inc/js/common.js")}}"></script>
    <script type="text/javascript" src="{{asset("inc/js/examchoicebutton.js")}}"></script>
    <script type="text/javascript" src="{{asset("inc/js/rosteruploadScripts.js")}}"></script>

    <script type="text/javascript">
        const API = 'api';

        <?php
       $table_maker = new \App\classes\StudentClasses\display\StudentTableMaker();
        $table_maker->set_encoder(new \App\classes\JsonOutputClasses\encoders\DirectJsonOutput());
        $table_maker->set_student_loader(new \App\classes\StudentClasses\dao\StudentLoader());

    //global variables for scripts
    $j = new \App\classes\DirectOutputClasses\encoders\JavascriptVariableEncoder();
        print('var studentRecords = ');
//        ($exam ? $table_maker->display_for_exam($exam) : print("''"));
        echo ';';
        ?>
                $(document).ready(function () {
                    var scripts = [
                        "inc/js/common.js",
                        "inc/js/examchoicebutton.js",
                        "inc/js/rosteruploadScripts.js"];

                    /**
                     * Do any styling or activities required by the page
                     * @returns {undefined}
                     */
                    function onLoad() {
                        $('.navMenuItem').menu();
                        $('.prettyButton').button();
                        $('#importedRecords').empty();
                        checkExamStatus();

                        $('.taskComplete').button();
                        //genericGetAll('Kumi', 'getUserClasses');
                        bindExamEventListeners();//examchoicebutton.js events

                        $.extend($.fn.dataTable.defaults, {
                            "pageLength": 50
                        });
                        var data = new Array();
                        if (studentRecords) {
                            $.each(studentRecords, function (k, v) {
                                data.push(v);
                            });
                        }
                        $('#dataTypes').dataTable({ordering: false, paging: false});
                        $('#allStudents').dataTable({
                            "data": data,
                            "columns": [
                                {"data": "class_nickname"},
                                {"data": "student_id"},
                                {"data": "student_name"},
                                {"data": "email"}
                            ]
                        });
                        console.log('onload called');
                    };
                    onLoad();
                    // scriptLoader(scripts, scripts.length, onLoad, 0);
                });
    </script>
@endsection