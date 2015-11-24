<section id="{{\App\ViewTools\HelpLinks::$examWhat['id']}}" class="group">
    <h4 class="text-center">What exams are</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">An <i>exam</i> is the basic unit of organization. Please don't be misled by our choice to
                call this an 'exam'. It could be a quiz, an assignment, a paper, or virtually any other activity for
                which you want to assess a group of students on the same criteria at approximately the same time.
            </p>

            <p class="answer">An exam is identified by its name, and the year and term in which it is given. An exam is
                associated with a <a href="#{{\App\ViewTools\HelpLinks::$instructSectionRosterSetup['id']}}">roster</a>
                of students.</p>

            <p class="answer">Every exam contains at least one <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionQuestionSetup['id']}}">question</a>.
                Questions usually contain several tasks which a student must complete in order to receive full credit
                for the question. These tasks are <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionElementSetup['id']}}">elements</a>.
            </p>

        </div>
        <div class="col-lg-6">
            @include('help.partials.field_table', ['fields' => [
              ['name' => 'Exam name', 'required' => true],
              ['name' => 'Term', 'required' => true],
              ['name' => 'Year', 'required' => true]
              ],
              'caption' => 'Exam'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$examCreate['id']}}" class="group">
    <h4 class="text-center">Create exam</h4>
    @include('help.partials.section_top_picture',
    ['imageFile' => 'exam/exam_setup.jpg',
    'altText' =>"The Create Exam page",
    'caption' => 'The Create Exam page'])

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Enter a short descriptive name in the exam name box. </p>

            <p class="answer">This name will be used when you select the exam in several different places. It will also
                be
                displayed as part of the feedback your students see.</p>
            <blockquote>
                <h6>Example</h6>

                <p>For our examples, we'll use a midterm for philosophy 101 about Descartes' famous skeptical argument
                    from the beginning of the <i>Meditations</i>.</p>

                <p>Thus let's call it
                    <mark>Phil101 midterm Descartes cogito</mark>
                </p>
            </blockquote>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
                        ['imageFile' => 'exam/exam_setup_name_entered_in_box.jpg',
                        'altText' =>"Create exam with the new exam name entered in the exam name field",
                        'caption' => 'Give the exam a name'])

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                Use the dropdown menu to select the term in which you are giving the exam. The term field is required.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
                        ['imageFile' => 'exam/exam_setup_term_select.jpg',
                        'altText' =>"Exam create showing the term dropdown menu with options 'winter', 'spring', 'summer', 'fall' displayed",
                        'caption' => 'Select the term'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Use the dropdown menu to select the year in which you are giving the exam. The year field
                is
                required.</p>

            <p class="answer">Once the name is filled in, and the term and year are selected, click 'Add/Edit Questions'
                to save the exam, and move on to the next step.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
                        ['imageFile' => 'exam/exam_setup_year_select.jpg',
                        'altText' =>"Exam create showing the term dropdown menu with options 2015, 2016 displayed",
                        'caption' => 'Select the year'])
        </div>
    </div>
</section>

<section id="{{ \App\ViewTools\HelpLinks::$examClone['id'] }}" class="group">
    <h4 class="text-center">Create a new exam from an existing exam</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                If you give the same or similar exams in multiple semesters, you can save virtually all of the setup
                time by
                cloning a past exam.
            </p>

            <p class="answer">
                The clone process duplicates all the questions, elements, and feedback from the parent exam. It does not
                duplicate the parent exam's roster, student scores, or any individualized feedback.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
                        ['imageFile' => 'exam/exam_setup_clone_button_circled.jpg',
                        'altText' =>"The exam selection page with a clone button circled",
                        'caption' => 'Click Clone to duplicate an existing exam'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                The newly created exam will be named 'Clone of ' followed by the original exam's name. Click 'Edit' to use the exam edit
                page to rename and update the term and year.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
                        ['imageFile' => 'exam/exam_setup_clone_success.jpg',
                        'altText' =>"The exam selection page the newly cloned exam whose name is 'Clone of' plus the original exam name",
                        'caption' => 'Clone successful'])

        </div>
    </div>

</section>