<section id="{{ \App\ViewTools\HelpLinks::$faqSetupGradeOnly['id'] }}" class="group">
    <div class="infoItem">
        <p class="lead"><b>Q.</b> I'm grading a final exam. Do I have to give feedback?</p>

        <p class="answer">No. You can use the gradeomatic just to record grades without giving feedback. This may still save you a lot of time. Each small administrative task adds up quickly when you have large classes. Indeed, the gradeomatic was born during budget cuts and exploding class sizes when the creator realized that spending an extra 30 seconds on each of 120 exams drained an hour from his life.</p>

        <p class="answer"><b>Q.</b> Great. So how do I do that?</p>

        <ol>
            <li><a href="#{{\App\ViewTools\HelpLinks::$examCreate['id']}}">Create</a> the exam.</li>
            <li><a href="#{{\App\ViewTools\HelpLinks::$questionCreate['id']}}">Create</a> the questions. </li>
            <li>After creating the questions, you will be sent to the create elements page. If you want to use elements for assessment, only fill in the <code>Element Name</code> field. If you do not want to use elements, you may find yourself trapped by an error message when you try to save a blank element by clicking <code>Edit Questions</code> or </code><code>Next Question</code>. Instead, click <code>Setup</code> in the navigation bar at the top. This will take you back to the list of exams.</li>
            <li>We still need to add students. So, on the list of exams, click <code>Edit</code>. This will take you back to the page where you created the exam.</li>
            <li>From the exam creation/editing page, click <code>Edit Student Roster</code></li>
            <li>Follow the instructions for <a href="#{{\App\ViewTools\HelpLinks::$rosterPrep['id']}}">preparing</a> and <a href="#{{\App\ViewTools\HelpLinks::$rosterImport['id']}}">uploading</a> your roster. You won't be emailing students, so don't upload them.</li>
            <li>Click <code>Grade</code> in the navigation bar. </li>
            <li>Follow the instructions for <a href="#{{\App\ViewTools\HelpLinks::$gradeExamSelect['id']}}">grading</a> your students' exams</li>
            <li>(Optional) <a href="{{\App\ViewTools\HelpLinks::$assignSetCutoffs['id']}}">Adjust</a> the grade distributions.</li>
            <li><a href="#{{\App\ViewTools\HelpLinks::$exportHow['id']}}">Export</a> the grades to your gradebook. </li>
            <li>Enjoy a refreshing post-grading beverage.</li>
        </ol>

        <p class="answer"><b>Q.</b> Oy vey. That was complicated. Did it have to be so hard?</p>
        <p class="answer">Yeah, sorry about that. Everyone grades in different ways. So the system has to be really flexible. But if we made every part completely customizable, no one would be able to figure out how to use the thing. This is one place where the trade-offs are really noticeable and the compromise is the result of several head-shaped dents in my desk. Creative suggestions are very welcome....</p>

    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$faqRosterCsvWhat['id']}}" class="group">
    <div class="infoItem">
        <p class="lead"><b>Q.</b> What's a .csv file? How do I make one?</p>

        <p class="answer">CSV stands for "Comma Separated Value". It is a very simple text format for storing data. It
            is basically what would be left over
            if you removed all the formulas, all the formatting, and all the other things which make an Excel
            spreadsheet useful.</p>

        <p class="answer">To make a .csv file, it's easiest to start with an Excel spreadsheet. Once you've added all
            your data (if you don't want to lose
            the formatting, first save it as you would any other spreadsheet).</p>

        <p class="answer">To create a .csv file from Excel in Windows or Mac, go to "File", then "Save As", and select
            "CSV (Comma delimited) (*.csv)". A message may pop up,
            to warn you that saving as a .csv file will lose all the file's formatting. If this is a problem, make sure
            you've saved the file as a normal
            spreadsheet (.xls or .xlsx) before proceeding. Once you're ready, click Confirm.</p>
        <p class="answer">See <a href="#{{\App\ViewTools\HelpLinks::$rosterPrep['id']}}">{{\App\ViewTools\HelpLinks::$rosterPrep['text']}}</a> for more detailed instructions.</p>
    </div>
</section>



<section id="{{\App\ViewTools\HelpLinks::$faqRosterErrors['id']}}" class="group">
    <div class="infoItem">
        <p class="lead"><b>Q.</b> Why didn't my roster file import correctly?</p>

        <p class="answer">The file importer makes its best guess about how the data in your file is organized. To
            improve its
            accuracy, delete any extraneous data not used by gradeomatic and make sure the columns are arranged (from
            left to right):</p>
        <ul>
            <li>Last Name (required)</li>
            <li>First Name (required)</li>
            <li>Student ID (optional)</li>
            <li>Email (optional)</li>
        </ul>
    </div>
</section>

<section id="{{\App\ViewTools\HelpLinks::$faqHowSave['id']}}" class="group">
    <div class="infoItem">
        <p class="lead"><b>Q.</b> How do I save things? I don't see a 'Save' button!</p>

        <p class="answer">In all of the setup tasks, clicking the navigation buttons at the top left and right of the
            screen saves your entries and displays the next (or previous) page for editing. </p>

        <p class="answer">These buttons will have different names depending on which page you are on. For example, when
            you are creating questions, the left navigation button will say 'Edit Exam'; the right will say 'Add/Edit
            Elements'. When you are editing elements, the left navigation button will say 'Edit Questions'; the right
            will say 'Next Question' (if you are working on the final question's elements, it will say 'Import
            Students'). </p>

        <p class="answer text-danger">Your entries and edits are not saved until you click one of these buttons. Our
            security procedures will log you out after a period of inactivity. Thus if you are going to walk away from
            your computer, please make sure you save your changes first. </p>
    </div>
</section>