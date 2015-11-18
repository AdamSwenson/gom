<section id="{{\App\ViewTools\HelpLinks::$rosterWhat['id']}}" class="group">
    <h4 class="text-center">Rosters: Associating students with an exam</h4>

    <div class="row">
        <div class="col-lg-6">

            <p class="answer">Each exam has a student roster with all the students who will take the exam. On the "edit
                roster"
                page you can import students from a .csv file and edit student information.
            </p>

            <p class="answer">The only required information is the first and last name of the student. You may also
                include
                the
                student's ID number (if, for example, you wish to grade the exams blindly) and their email address if
                you
                want
                to have a link for accessing feedback emailed directly to the students.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
      ['imageFile' => 'roster_edit/roster_edit_import_page.jpg',
      'altText' =>'The roster editing and importing page',
      'caption' => 'Importing and editing students'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To import students, click 'Edit Student Roster' on the exam setup page. You will also be
                automatically taken to the import students page after you save elements for the last question.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_edit_roster_circled.jpg',
            'altText' =>'Circle around the edit roster button on exam setup page',
            'caption' => 'Click Edit Roster'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$rosterPrep['id']}}" class="group">
    <h4 class="text-center">Preparing the roster for importing</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">CSV stands for "Comma Separated Value". It is a very simple text format for storing data.
                It
                is basically what would be left over
                if you removed all the formulas, all the formatting, and all the other things which make an Excel
                spreadsheet useful.</p>

            <p class="answer">To make a .csv file, it's easiest to start with an Excel spreadsheet. Once you've added
                all
                your data (if you don't want to lose
                the formatting, first save it as you would any other spreadsheet).</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_xlsx_circled.jpg',
            'altText' =>'Open excel file with xlsx circled',
            'caption' => 'Start with a regular excel file'])
        </div>
    </div>

    <h4 class="text-center">Preparing the spreadsheet</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Make sure that all of the information is correct. Remove all data except for the student's
                last name, student's first name, (optional) student id, and (optional) email address.</p>


            <p class="answer">Make sure the columns are in the proper order, from left to right:</p>
            <ul>
                <li>Last name</li>
                <li>First name</li>
                <li>Student id (optional)</li>
                <li>Email address (optional)</li>
            </ul>

            <p class="answer">Remove any headers so that the first row contains the first student</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_heading_rows_circled.jpg',
            'altText' =>'Open excel file with column headers circled',
            'caption' => 'Remove any headers'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_header_row_removed.jpg',
            'altText' =>'Open excel file with headers removed',
            'caption' => 'Ready to be saved'])
        </div>
    </div>

    <h4 class="text-center">Saving as .csv</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To create a .csv file from Excel in Windows or Mac, go to "File", then "Save As", and
                select
                "CSV
                (Comma delimited) (*.csv)".</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_file_save_as.jpg',
            'altText' =>'Open excel file with save as menu option circled',
            'caption' => 'Go to Save As in the File menu'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_csv_selected.jpg',
            'altText' =>'Open excel save as menu with csv option circled',
            'caption' => 'Select Comma Separated Values'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_csv_name_and_save_circled.jpg',
            'altText' =>'Open excel save as menu showing the file extension changed to csv',
            'caption' => 'Save the file in the new format'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">A message may pop up,
                to warn you that saving as a .csv file will lose all the file's formatting. If this is a problem, make
                sure
                you've saved the file as a normal spreadsheet (.xls or .xlsx) before proceeding.</p>

            <p class="answer">Once you're ready, click Confirm.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_excel_csv_warning_circled.jpg',
            'altText' =>'Open excel file with warning for saving as csv',
            'caption' => 'Formatting loss warning '])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$rosterImport['id']}}" class="group">
    <h4 class="text-center">Importing students from file</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Once your csv file is prepared, click Import Students</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_import_roster_circled.jpg',
            'altText' =>'Edit students page with Import Roster button circled',
            'caption' => 'Click Import Roster'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">A dialog will pop up allowing you to select the file to upload. Make sure you choose the
                file
                which ends in '.csv'</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_import_dialog_circled.jpg',
            'altText' =>'Edit students page with dialog for selecting file displayed',
            'caption' => 'Select the .csv file'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Check over the imported records to make sure that everything is in the correct
                location</p>

            <p class="answer">You can sort the list by clicking on the column title you want to sort by. For example, to
                sort by first name, click the 'First Name' at the top of the table.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_import_success.jpg',
            'altText' =>'Edit students page with the newly imported students displayed',
            'caption' => 'Successful import'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$rosterManual['id']}}" class="group">
    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you need to edit or correct student information, you can edit on this page.</p>

            <p class="answer">If you need to add a student by hand, click 'Add Student'</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_add_student_circled.jpg',
            'altText' =>'Edit students page with the Add Student button circled',
            'caption' => 'Add a student by hand'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_new_student_fields.jpg',
            'altText' =>'Edit students page with blank fields for adding student',
            'caption' => 'Blank fields for new student'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Fill in the student information. </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_filling_in_new_student.jpg',
            'altText' =>'Edit students page with the Add Student button circled',
            'caption' => 'Fill in student information'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$rosterDelete['id']}}" class="group">
    <h4 class="text-center">Deleting students</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you need to delete a student, click the 'X' in their row.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_delete_student_button_circled.jpg',
            'altText' =>'Edit students page with the Delete Student button circled',
            'caption' => 'Delete student'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">A warning message will display asking you to confirm that you really want to delete the
                student.</p>

            <p class="answer text-danger">Deleting a student will destroy all of their scores, feedback and grades.</p>

            <p class="answer text-danger">For security, there is no way to restore the student data once they are
                deleted.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_delete_student_warning.jpg',
            'altText' =>'Edit students page with delete student confirmation dialog shown',
            'caption' => 'Confirm deletion'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">The student has been set for deletion. The actual deletion will take place once the roster
                is
                saved</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_student_been_deleted.jpg',
            'altText' =>'Edit students page with the student deleted',
            'caption' => 'Successful deletion'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$rosterSave['id']}}" class="group">
    <h4 class="text-center">Saving changes</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Pressing "Save & Exit" will save any changes to the roster. Note that any changes you make
                will
                only be saved by pressing "Save & Exit"</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_save_button_circled.jpg',
            'altText' =>'Edit students page with the Save and Exit button circled',
            'caption' => 'Click Save & Exit'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'roster_edit/roster_edit_success.jpg',
            'altText' =>'Success message displayed after save',
            'caption' => 'Successful save'])
        </div>
    </div>
</section>