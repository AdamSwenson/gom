<div class="infoItem">
    <p class="lead"><b>Q.</b> Where can I get help?</p>

    <p>Check the <a href="#help">help section</a> for basic information on how to use the site.</p>
    <p>Our growing library of <a href="{{ url('/tutorials') }}">tutorial videos</a> may also help.</p>
</div>

<div class="infoItem">
    <p class="lead"><b>Q.</b> What is the gradeomatic? Who created it?</p>

    <p>The gradeomatic was created by a teacher who couldn't bring himself to sacrifice the quality of the feedback he gave his students when his class sizes exploded.
        Thus the gradeomatic streamlines grading and its administrative tasks. It allows teachers to provide detailed and personalized feedback to their students. And it captures
        fine-grained data on student performance and the grading process to improve pedagogy, exam design, and quality control in grading.</p>
</div>

<div class="infoItem">
    <p class="lead"><b>Q.</b> What's a .csv file? How do I make one?</p>

    <p class="answer">CSV stands for "Comma Separated Value". It is a very simple text format for storing data. It is basically what would be left over
        if you removed all the formulas, all the formatting, and all the other things which make an Excel spreadsheet useful.</p>
    <p class="answer">To make a .csv file, it's easiest to start with an Excel spreadsheet. Once you've added all your data (if you don't want to lose
        the formatting, first save it as you would any other spreadsheet).</p>
    <p class="answer">To create a .csv file from Excel in Windows or Mac, go to "File", then "Save As", and select "CSV (Comma delimited) (*.csv)". A message may pop up,
        to warn you that saving as a .csv file will lose all the file's formatting. If this is a problem, make sure you've saved the file as a normal
        spreadsheet (.xls or .xlsx) before proceeding. Once you're ready, click Confirm.</p>
</div>

<div class="infoItem">
    <p class="lead"><b>Q.</b> Why didn't my roster file import correctly?</p>

    <p class="answer">The file importer makes its best guess about how the data in your file is organized. To improve its
        accuracy, delete any extraneous data not used by gradeomatic and make sure the columns are arranged (from left to right):</p>
    <ul>
        <li>Last Name  (required) </li>
        <li>First Name (required) </li>
        <li>Student ID (optional) </li>
        <li>Email      (optional) </li>
    </ul>
</div>

<div class="infoItem">
    <p class="lead"><b>Q.</b> When grading, can I hide student names? </p>

    <p class="answer">Yes. Click the pencil icon <span class="glyphicon glyphicon-pencil"></span> to grade
        exams anonymously.</p>
</div>

<div class="infoItem">
    <p class="lead"><b>Q.</b> I love the gradeomatic! What can I do make it even better? </p>

    <p class="answer">Yay! We're so glad to hear it. Here are three things that would help: </p>
    <ol>
        <li>Spread the word! Tell your friends and colleagues about the gradeomatic.</li>
        <li>Send us a testimonial about how you used the gradeomatic and how it helped your teaching. You can
            reach us at {{ env('CONTACT_EMAIL') }}.</li>
        <li>Send us suggestions for new features or improvements. Your feedback will help us prioritize among
            the long list of things we're planning.</li>
    </ol>
</div>

{{--Setting up the exam--}}
<div class="infoItem">
    <p class="lead"><b>Q.</b> How can I give feedback on the question as a whole? </p>
    <p class="answer">You have two options. One is to have only one element for the question. The stock comment you provide can then cover the whole question.</p>
    <p class="answer">Ok. We lied. There aren't really two options. The second option is to rethink what you need. If you find yourself asking this question, you probably haven't fully appreciated the power of the elements. A common thought is something like, "Well, my students need to do x, y, and z, in order to explain the concept the question is asking them about. But then I also want to give them feedback on how well they tied x, y, and z together." The answer is to add a fourth element with the description "Ties together x, y, and z." This may rightly seem strange: You now have four elements. But one is a different type of task from the other three. The first three involve (for example) demonstrating understanding of part of a concept. The new fourth element is the more meta-level task of integrating the explanations.</p>
</div>

<div class="infoItem">
    <p class="lead"><b>Q.</b> How secure is student data? </p>
    <p class="answer">The gradeomatic has been designed with security in mind at every step. Student information is  stored in an encrypted database.  </p>
    <p class="answer">That said, student privacy is important, both legally and morally. So, let's clarify a few things.   </p>
</div>