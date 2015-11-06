<div class="infoItem">
    <h4 id="intro">Introduction</h4>

    <p class="answer">
        The gradeomatic separates the grading process into three components
    </p>
    <ul>
        <li><a href="#how_it_works">Exam setup</a>: Preparing the questions, adding the raw material for comments, and uploading students</li>
        <li><a href="#grading">Grading</a>: Evaluating student work and tweaking the grade distribution</li>
        <li><a href="#reports">Reporting</a>: Reviewing student performance and releasing feedback to students</li>
    </ul>
    <p class="answer">Of course, grading is a complex and organic process. So, you can generally jump around between the stages. We wouldn't let you be tortured by a typo in a question name which you didn't notice until 5 exams in. Nor would we prevent you from adding an extra element after noticing that your students have discovered a brand new way to misunderstand a concept.
    </p>
</div>

<div class="infoItem">
    <h4 id="how_it_works">Exam setup</h4>

    <p class="answer">Let's start with how things fit together.</p>

    <p class="answer">An <i>exam</i> is the most basic unit of organization. Of course, we just chose to call it an 'exam'. It could be a quiz, an assignment, a paper, or virtually any other activity for which you want to grade a bunch of students on the same criteria and at approximately the same time.</p>

    <p class="answer">An exam is identified by its name, and the year and term in which it is given. An exam is associated with a <a href="#rosters">roster</a> of students. Each exam contains at least one <a href="#questions">question</a>. Each question usually contains at least one task which students need to complete in order to receive full credit for the question. These tasks are <a href="#elements">elements</a>. </p>

    <p class="answer">During <a href="#grading">grading</a>, you enter a grade or score for each question and rate how well the student performed on each element. You may also choose to further customize the feedback for the student. That's it.</p>

    <p class="answer">Once you're finished grading, some helpful statistics and visualizations of student performance will help you adjust the grade distribution as you see fit. Then with two clicks you can email each student a unique link. This link will allow them to securely view your feedback along with some charts indicating how well they performed on each question and element. Once they've had enough time to review the feedback, another click hides the feedback. It is also possible to print out the feedback and hand it back to students. Finally, another click will export your students' scores and grades to a spreadsheet. A quick copy and paste into your grade book, and you're ready for a celebratory beverage.</p>
</div>

<div class="infoItem">
    <h4 id="questions">Questions</h4>

    <p class="answer">In setting up the exam, you create a <i>question</i> by giving it a brief question name (to use as a reminder while grading) and, optionally, the full question text. You also assign the maximum points possible for each question. If you want to give each question a letter grade and then have the overall exam grade reflect all questions equally, simply assign each question the same number of points. The gradeomatic will translate the letter grade into a fixed percentage of the total possible points. If all questions count equally, we recommend assigning each question 100 points.</p>

    <p class="answer">We called these items 'questions' because that's what they'll be for many uses of the gradeomatic. However, the system is designed to be extremely flexible. 'Questions' are really just whatever items a student's grade depends upon.</p>

    <p class="answer">For example, if you were using the gradeomatic to grade long form essays, you could have 'questions' like <samp>Organization</samp> or <samp>Grammar</samp> and set the point values accordingly. </p>

    <p class="answer">Similarly, suppose you have an exam with four questions each worth 20% and want the student's grammar on all questions to count for 20%. Simply add an extra question called 'Grammar', and set the number of points that portion is worth.</p>

    <p class="answer">Finally, while each question must have a maximum score, the maximum score can be 0. This might be helpful if you want to use the gradeomatic to create feedback for students but don't want to assign a grade. For example, suppose you are going to grade a rough draft of an essay credit/no credit, and then give actual grades for the final draft. You would create the questions and elements as usual. For the rough draft you set the points for each question to 0. Then, when the final draft is turned in, simply clone the 'exam' you used for the rough draft and change the points for each question to their actual values.</p>
</div>

<div class="infoItem">
    <h4 id="elements">Elements</h4>
    <h6>What elements are and what they do</h6>
    <p class="answer"><i>Elements</i> can be a bit tricky to explain since they have multiple roles and are very flexible. Let's start with the most basic use and add possibilities as we go. On the most basic use, elements have two jobs:</p>
    <ol>
        <li>Elements comprise questions</li>
        <li>Elements form the basis of feedback</li>
    </ol>

    <p class="answer">Elements comprise questions. On more complex questions, where you are asking the student to do multiple things or where explaining a concept requires several different components, each task/component should be represented by an element. </p>

    <p class="answer">Multi-part questions or short essays spanning several paragraphs might have several elements. While a
        short-form question might only have one. A question can have zero elements if you only want to use
        gradeomatic for reporting scores.
    </p>

    <p class="answer">If you are familiar with using rubrics to grade an exam, you are already familiar with how to divide a question into it's elements. For those who are less familiar, here are a few strategies you might try:</p>
    <ul>
        <li>Imagine that a good student comes to your office, distraught after doing poorly on one question on the exam. She asks 'What did I miss? What should I have done?' You'll probably say something like 'Well, you needed to do x, y, and z. You did a good job on x. But you totally forgot to bring up y. And there were several mistakes in your explanation of z'. When you have that conversation in your head, whatever you fill in for x, y, and z are the elements of the question</li>
    </ul>

    <h6>Creating elements and comments</h6>
    <p class="answer">On the "create & edit elements" page, you, um, create and edit elements. To do this, you provide a short name for the element which which will be meaningful to you when you see it during grading and in charts.</p>

    <p class="answer">You then also provide some text that will form the basis for all feedback that you give on the element.
        to can provide a short name for the element along with a stock
        comment.
        In "element response", enter the basic description of what the student should do to fully answer the
        element.
        Pressing the "Customize Response" button allows you to take it
        one step further. Here you modify that basic comment to tailor it based on the student's performance. By
        default, gradeomatic allows for four responses varieties: "missing", "poor", "fair" and "excellent". These
        responses will be what the student sees once you have graded the exam.
    </p>
</div>

<div class="infoItem">
    <h4 id="rosters">Student Rosters</h4>

    <p class="answer">Each exam has a student roster with all the students who will take the exam. On the "edit roster" page you can import students from a .csv file and edit student information.</p>

    <p class="answer">The only required information is the first and last name of the student. You may also include the student's ID number (if, for example, you wish to grade the exams blindly) and their email address if you want to have a link for accessing feedback emailed directly to the students.</p>

    <p class="answer">Pressing "Save & Exit" will save any changes to the roster.</p>
</div>

<div class="infoItem">
    <h4 id="grading">Grading</h4>

    <p class="answer">
        To grade an exam, select the exam from the "Grade" tab and pick a student. This will reveal the questions
        for the exam and a slider for each element. For each element, move the slider to a value that corresponds
        to the student's performance. This won't affect the question grade, but it will affect the written feedback.
        If you wish to tailor the student's feedback individually, simply modify the text box next to that element.
        Enter a score for the question, then move to the next question. Once a grade is entered for a student,
        the exam is considered graded for timing and release purposes. This allows you to construct exams where
        students may choose among one or more questions to answer. If the student didn't need to answer a
        question, simply leave the score area blank and they won't be graded.
    </p>
</div>

<div class="infoItem">
    <h4 id="assignments">Grade Assignments</h4>

    <p class="answer">
        The grade assignment page is accessable from the "Grade" tab. Gradeomatic automatically calculates the
        maximum possible score on the exam, along with suggestions for letter grades. If you don't want to use
        a letter, simply empty the box and it will not be a possible grade for students. The charts on the right
        hand
        side of the page show a histogram of the number of students currently receiving each grade and a bar
        chart showing exam scores for each student ordered from low to high, along with their grade.
    </p>
</div>

<div class="infoItem">
    <h4 id="reports">Reports</h4>

    <p class="answer">
        Reports holds tasks you might perform after the exam is graded. "Release Exam" will officially release
        the exam, emailing all students you have graded and who have valid email addresses a link where they
        can view their grade and compiled feedback. The lock is the reverse, cutting off all access to all
        students for that exam. Once an exam is locked, it must be re-released, which will email students with
        new links to their results.
    </p>

    <p class="answer">
        The students button takes you to a page with individual student controls for emailing a student (useful
        to notify only one student that their grade has changed) and to review the feedback that the student can
        see.
    </p>
</div>

<div class="infoItem">
    <h4 id="analytics">Analytics</h4>

    <p class="answer">
        The analytics page has various charts detailing the data collected from the exam. The first chart is a
        box plot detailing student score variation for each question. The lines show the lowest and highest
        grades, the bottom of the box the lowest quartile, the top of the box the third quartile, and the circles
        display the mean and median.
    </p>
</div>