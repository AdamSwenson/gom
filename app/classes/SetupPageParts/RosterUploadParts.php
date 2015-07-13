<?php
/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 * This won't be used unless I really want to mess around with an ajax file loader
 */
?>
<div class="bodyText">
    <div id="instructions">
        Many many many instructions go here.

        <table id='dataTypes'>
            <tr>
                <th>Field name</th>
                <th>Value type</th>
                <th>Description</th>
                <th>Example</th>
                <th>Max size</th>
                <th>Required?</th>
                <th>Unique?</th>
            </tr>
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
                <td>The student's email address.  </td>
                <td>200 characters</td>
                <td>fake@fake.com</td>
                <td>Yes</td>
                <td>No</td>
            </tr>
        </table>

        <p>Tooltips: <br/>
            Unique: No two records can have the same value.<br/>
            Required: Every record must have a value.<br/>

            If you do not want the gradeomatic to email comments to students, just put a dummy email address for all students
        </p>
        <p>
            Link to sample csv file goes here.
        </p>
    </div>
       <!--<form enctype="multipart/form-data" method="post" action='<?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' role="form">-->
    <!--<form>-->
    <div>
        <div class="form-group">
            <label for="exampleInputFile">Select file to upload</label>
            <input type="file" class="prettyButton" name="file" id="file" size="150">
        </div>
        <label for="classClasses">Import students for this class</label><br/>
        <select id="classClasses"name="classid" id="importClassId" class="classSelect"></select><br/>
        <!--<button type="submit" class="prettyButton" name="Import" value="Import">Upload</button>-->
        <input type="button" class="prettyButton" name="Import" id="importRecords" value="Import">Upload</button>
    <!--</form>-->
    </div>
    <div id="importedRecords">

        <?php
//        if (isset($_POST)) {
//            if ((isset($_POST['Import']) && $_POST['Import'] == 'Import')) {
//                $filename = $_FILES["file"]["tmp_name"];
//                if ($_FILES["file"]["size"] > 0) {
//                    ini_set('auto_detect_line_endings', TRUE);
//                    $file = fopen($filename, "r");
//                    $i = 0;
//                    while (($data = fgetcsv($file, 10000, ",")) !== FALSE) {
//                        if ($i == 0) {
//                            //check the header fields
//                            \App\classes\ImportExportClasses\StudentImportValidator::csv_headers($data);
//                            //@todo Make it fail and generate an error message here
//                        } else {
//                            $sid = $data[0];
//                            $studentName = $data[1];
//                            $email = $data[2];
//                            try {
//                                $classid = \App\classes\ImportExportClasses\StudentImportValidator::clean($_POST['classid']);
//                                $class = new \KumiClasses\LoadKumiByClass($user, $classid);
//                            } catch (\Exception $e) {
//                                echo $e->getMessage();
//                                echo "The classID you specified was invalid. You must first create a class. Look up the id and add it to your csv file";
//                            }
//                            $valid = new \App\classes\ImportExportClasses\StudentImportValidator($sid, $studentName, $email);
//                            $import = new \App\classes\ImportExportClasses\StudentImporter($valid, $class);
//                            if ($import) {
//                                echo $sid . ' ' . $studentName . '  ' . $class->displayID() . '  ' . $email;
//                                echo '<br />';
//                            } else {
//                                //@todo Add better error message
//                                echo "The record for $sid $studentName was invalid. Please reformat and try again.";
//                                return false;
//                            }
//                        }
//                        $i++;
//                    }
//                    fclose($file);
//                    echo 'CSV File has been successfully Imported';
//                } else {
//                    echo 'Invalid File: Please Upload a CSV File';
//                }
//                ini_set('auto_detect_line_endings', FALSE);
//            }
//        }
        ?>
    </div>
</div>

            <script type="text/javascript">
                var SETUPLINK = "<?php //echo Navigation::SETUPPROCESSOR; ?>";
                $(document).ready(function () {
                    $('#importRecords').bind('click', function () {
                       var classid = $('#importClassId').val();
                       var file = $('#file').val();
                       var SEND = {'task' : 'importStudents', 'classID' : classid, 'file' :file}
                       $.post('processor_inputoutput.php', SEND, function (response) {
                           window.console.log(response);
                       }, 'JSON' );
                    });
                });


//<div id="scriptTemplates">
//        <script id="ExamKumiOptionTemplate" type="text/x-jQuery-tmpl">
//            <option data="${classID}${examID}" value="${classID}">${year}  ${term}  ${course}  ${section}  ${examTopic}</option>
        </script>
<!--        <script id="ExamKumiListTemplate" type="text/x-jQuery-tmpl">
            <li data="${classID}${examID}">${year}  ${term}  ${course}  ${section}  ${examTopic}</li>
        </script>-->

        <div class="ScriptBox">
            <script type="text/javascript">//
//                var SETUPLINK = "<?php //echo Navigation::SETUPPROCESSOR; ?>";
//                $(document).ready(function () {
//                    $('.prettyButton').button();
//                    $('#importedRecords').empty();
//
//                    function genericGetAll(objectType, getCommand) {
//                        var Req = new Object();
//                        Req.task = getCommand;
//                        $.getJSON(SETUPLINK, Req, function (json) {
//                            if (objectType == 'Kumi') {
//                                $("#ExamKumiOptionTemplate").tmpl(json.data).appendTo(".classSelect");
//                                $("#ExamKumiListTemplate").tmpl(json.data).appendTo(".classList");
//                            }
//                            else if (objectType == 'Exam') {
//                                $("#ExamKumiOptionTemplate").tmpl(json.data).appendTo(".examSelect");
//                                $("#ExamKumiListTemplate").tmpl(json.data).appendTo(".examList");
//                            }
//                        }, "JSON");
//
//                    }//generic get
//                    genericGetAll('Kumi', 'getUserClasses');
//                });
//            </script>
        </div>
