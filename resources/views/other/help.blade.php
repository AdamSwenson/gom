@extends('layouts.master')

@section('pageTitle', 'Help | gradeomatic')

@section('cssLinks')

@endsection

@section('body')
    <div class="container">
        <h3><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Gradeomatic FAQ</h3>

        <div class="well">
            <p>
                <b>Q.</b> Where can I get help?<br/>
                <b>A.</b> Check the <a href="#help">help section</a> for basic information how to use the site.
            </p>

            <p>
                <b>Q.</b> What is gradeomatic?<br/>
                <b>A.</b> Gradeomatic is a program designed to make grading written exams faster, while providing better
                feedback to students.
                It also helps you analyze your grading to see if you're asking the right questions in the right way.
            </p>

            <p>
                <b>Q.</b> What's a .csv file?<br/>
                <b>A.</b> CSV simply stands for "comma separated value", a simple text format used to interchange data. To
                create one from Excel in Windows, go to "File", then "Save As", and select "CSV (Comma delimited) (*.csv)"
            </p>

            <p>
                <b>Q.</b> Why didn't my roster file import correctly?<br/>
                <b>A.</b> The file importer makes its best guess as to how your data is organized. To improve it's
                accuracy, delete any extraneous data not used by gradeomatic and order the columns as listed on the page
                (Last Name, First Name, Student ID, Email Address).
            </p>

            <p>
                <b>Q.</b> When grading, can I hide student names?<br/>
                <b>A.</b> Yes. Click the pencil icon <span class="glyphicon glyphicon-pencil"></span> to grade
                exams anonymously.
            </p>
        </div>
        <h3><span class="glyphicon glyphicon-apple" id="help" aria-hidden="true"></span> Gradeomatic Help</h3>

        <div class="well">
            <h4 id="intro">Intro</h4>

            <p>
                Using gradeomatic is broken into three distinct steps: <a href="#how_it_works">setup</a>,
                <a href="#grading">grading</a>, and <a href="#reports">reports</a>,
                each representing tasks you might perform to prepare for and administer an exam. In setup, you
                create and edit an exam along with the associated student roster. 'Grade' allows for both scoring
                individual exams
                and assigning letter grades to the class. 'Reports' shows you information about student scores, along
                with controls for emailing students and saving exam data.
            </p>
            <br/>
            <h4 id="how_it_works">How it works</h4>

            <p>
                Exams are constructed out of <a href="#questions">questions</a>, which are assigned a maximum number of points. Each
                question, in term, consists of one or more <a  href="#elements">elements</a>, which correspond to portions of a question
                that the student must address. Exams also have a <a  href="#rosters">roster</a> of students, which can be imported from a
                file or edited manually. During <a href="#grading">grading</a>, you enter a grade for each question, along with a feedback
                level for each element based on how that student performed. That's it. You can then email the responses
                generated for each student, while they marvel at your effort and individual attention!
            </p>
            <br/>
            <h4 id="questions">Questions</h4>

            <p>
                Questions are the top-level pieces of an exam. In the exam editor, the question page provides tools to
                enter a brief question name (to use as a reminder while grading), and the full question text. Here, you
                also assign the maximum points possible for each question. This approach is designed for flexibility -
                if you want to grade students on their use of grammar, even if it's not on your test, you can simply
                make an extra question called "Grammar", and set the number of points that portion is worth.
            </p>
            <br/>
            <h4 id="elements">Elements</h4>

            <p>
                Elements, the lower-level part of a question, allow you to break a single question up into several sections.
                Multi-part questions or short essays spanning several paragraphs might have several elements, while a
                short-form question might only have one. A question can have zero elements if you only want to use
                gradeomatic for reporting scores.
            </p>
            <p>
                In the "create & edit elements" page, you can provide a short name for the element along with a stock comment.
                In "element response", enter the basic description of what the student should do to fully answer the element.
                Pressing the "Customize Response" button allows you to take it
                one step further. Here you modify that basic comment to tailor it based on the student's performance. By
                default, gradeomatic allows for four responses varieties: "missing", "poor", "fair" and "excellent". These
                responses will be what the student sees once you have graded the exam.
            </p>
            <br/>
            <h4 id="rosters">Student Rosters</h4>
            <p>
                Each exam has a student roster containing information about the students taking an exam. In the
                "edit roster" page, there are tools for importing roster data from a .csv file as well as editing
                individual students. Student ID and email addresses are optional, however first and last names are
                required. Pressing "Save & Exit" will save any changes to the roster.
            </p>
            <br/>
            <h4 id="grading">Grading</h4>
            <p>
                To grade an exam, select the exam from the "Grade" tab and pick a student. This will reveal the questions
                for the exam and a slider for each element. For each element, move the slider to a value that corresponds
                to the student's performance. This won't affect the question grade, but it will affect the written feedback.
                If you wish to tailor the student's feedback individually, simply modify the text box next to that element.
                Enter a score for the question, then move to the next question. Once a grade is entered for a student,
                the exam is considered graded for timing and release purposes. This allows you to construct exams where
                students may choose among one or more questions to answer. If the student didn't need to answer a
                question, simply leave the score area blank and they won't be graded.
            </p>
            <br/>
            <h4 id="assignments">Grade Assignments</h4>
            <p>
                The grade assignment page is accessable from the "Grade" tab. Gradeomatic automatically calculates the
                maximum possible score on the exam, along with suggestions for letter grades. If you don't want to use
                a letter, simply empty the box and it will not be a possible grade for students. The charts on the right hand
                side of the page show a histogram of the number of students currently receiving each grade and a bar
                chart showing exam scores for each student ordered from low to high, along with their grade.
            </p><br/>
            <h4 id="reports">Reports</h4>
            <p>
                Reports holds tasks you might perform after the exam is graded. "Release Exam" will officially release
                the exam, emailing all students you have graded and who have valid email addresses a link where they
                can view their grade and compiled feedback. The lock is the reverse, cutting off all access to all
                students for that exam. Once an exam is locked, it must be re-released, which will email students with
                new links to their results.
            </p>
            <p>
                The students button takes you to a page with individual student controls for emailing a student (useful
                to notify only one student that their grade has changed) and to review the feedback that the student can
                see.
            </p>
            <br/>
            <h4 id="analytics">Analytics</h4>
            <p>
                The analytics page has various charts detailing the data collected from the exam. The first chart is a
                box plot detailing student score variation for each question. The lines show the lowest and highest
                grades, the bottom of the box the lowest quartile, the top of the box the third quartile, and the circles
                display the mean and median.
            </p>
            <br/>
        </div>

    </div>
    @include('errors.list')
@endsection


@section('jsArea')


@endsection


