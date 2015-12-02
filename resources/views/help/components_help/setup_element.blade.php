@include('help.partials.section_top_picture', [
'imageFile' => 'element/element_edit_screen.jpg',
'altText' => "The element editing screen",
'caption' => "Create and edit elements"])


<section id="{{\App\ViewTools\HelpLinks::$elementWhat['id']}}" class="group">
    <h4 class="text-center">What elements are and what they do</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer"><i>Elements</i> have multiple roles and are very
                flexible. On their most basic use, elements have three jobs:</p>
            <ol>
                <li>Elements comprise questions</li>
                <li>Elements form the basis of feedback</li>
                <li>Elements let you compare student performance across superficially very different exams</li>
            </ol>
        </div>
        <div class="col-lg-6">
            @include('help.partials.field_table', ['fields' => [
            ['name' => 'Element name', 'required' => true, 'visible' => true],
            ['name' => 'Element response', 'required' => false, 'visible' => true],
            ['name' => 'Element response: Missing', 'required' => false, 'visible' => true],
            ['name' => 'Element response: Poor', 'required' => false, 'visible' => true],
            ['name' => 'Element response: Fair', 'required' => false, 'visible' => true],
            ['name' => 'Element response: Excellent', 'required' => false, 'visible' => true],
            ],
              'caption' => 'Element'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Elements comprise questions. On more complex questions, where you are (explicitly or
                implicitly) asking the student to do multiple things or where explaining a concept requires several
                different components, each task or component
                should be represented by an element. </p>

            <p class="answer">Multi-part questions or short essays spanning several paragraphs might have several
                elements.
                While a short-form question might only have one. A question can have zero elements if you only want to
                use
                the gradeomatic for reporting scores.
            </p>

            <p class="answer">If you are familiar with using rubrics to grade an exam, you are already familiar with how
                to
                divide a question into its elements.</p>

            <p class="answer">For those unaccustomed to rubrics, consider this, likely
                familiar, scenario:</p>
            <blockquote class="example">
                <p><em>Scene: A good student comes to your office, distraught after doing poorly on one question on the
                        exam.</em></p>

                <p><strong>Student</strong> What did I miss? What should I have done?</p>

                <p><strong>You</strong> Well, let's see. You needed to do x, y, and z.
                    You did a good job on x. But you totally forgot to bring up y. And there were several mistakes
                    in your explanation of z.</p>
            </blockquote>
            <p class="answer">Whatever you filled in for x, y, and z in that conversation are probably the elements of the
                question
            </p>
            {{--TODO: Add links to rubrics resources --}}
            {{--@include('help.partials.related_links', ['relatedLinks' =>--}}
            {{--[--}}
                {{--['id' => 'questionAltUses', 'text' => 'National Institute for for Learning Outcomes Assessment'],--}}
                {{--['id' => 'questionFeedbackOnly', 'text' => 'Giving feedback only']--}}
            {{--]])--}}
        </div>
        <div class="col-lg-6"></div>
    </div>

</section>

<section id="{{\App\ViewTools\HelpLinks::$elementCreate['id']}}" class="group">
    <h4 class="text-center">Creating elements and comments</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To create an element, provide a short name for the element which which will be meaningful
                to you
                when you see it during grading and when displayed in charts.
            </p>
            <blockquote>
                <h6>Example</h6>

                <p class="example">An explanation of methodology isn't going to make much sense without knowing what
                    it's for. So the first task is to explain Descartes' goal. </p>

                <p class="example"><em>ElementName</em>:
                    <mark>Explain Descartes goal</mark>
                </p>
            </blockquote>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
         ['imageFile' => 'element/element_edit_name_filled_in.jpg',
         'altText' =>"The element name field has been filled in with text",
         'caption' => 'Name the element'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">You then also provide some text that will form the basis for all feedback that you give on
                the
                element.</p>

            <p class="answer">In <em>Element Response</em>, enter a basic description of what the student should do to
                fully
                answer the element.</p>
            <blockquote class="example">
                <h6>Example</h6>

                <p><em>Element Response</em>:
                    <mark>In order to say why Descartes has adopted the skeptical method of the Meditations, you need to
                        tell the reader what Descartes is hoping to achieve. Namely, he is trying to discover what kinds
                        of beliefs can be the completely certain foundations upon which the rest of our knowledge can be
                        built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work
                        backwards to explaining why and when, for example, scientific beliefs count as certain
                        knowledge.
                    </mark>
                </p>
            </blockquote>
        </div>
        <div class="col-lg-6">

            @include('help.partials.picture_container',
         ['imageFile' => 'element/element_edit_stock_text.jpg',
         'altText' =>"The stock text field has been filled in",
         'caption' => "Add stock feedback"])

        </div>
    </div>
</section>


<section id="{{ \App\ViewTools\HelpLinks::$elementCustomize['id'] }}" class="group">
    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you want to give every student the same feedback regardless of how they do,
                you may
                stop here.</p>

            <p class="answer">Pressing the "Customize Response" button allows you to further customize the
                text to
                reflect performance.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_customize_circled.jpg',
'altText' =>"The customize response button has been circled",
'caption' => "Customize Response"])

        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                Here you modify that basic comment to tailor it based on the student's performance. By default,
                gradeomatic
                allows for four responses varieties: "missing", "poor", "fair" and "excellent". These responses will
                be what
                the student sees once you have graded the exam.
            </p>

            <p class="answer">Let's use the following as the stock feedback for this element.</p>

            <blockquote>
                <h6>Example: Stock response</h6>

                <p>In order to say why Descartes has adopted the skeptical method of the Meditations, you
                    need to
                    tell the reader what Descartes is hoping to achieve. Namely, he is trying to discover what kinds
                    of
                    beliefs can be the completely certain foundations upon which the rest of our knowledge can be
                    built.
                    That is, the idea is to find some beliefs which he can't be wrong about. Then he can work
                    backwards to
                    explaining why and when, for example, scientific beliefs count as certain knowledge.
                </p>
            </blockquote>

            <p class="answer">This can be a bit tricky. So here's a detailed example of how we might alter the stock feedback for
                different levels of performance. In each variation, the new or altered text is underlined.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_response_modal_orig.jpg',
'altText' =>"The the custom response text in the pop up fields is initially just the stock feedback entered",
'caption' => "Stock text initially populates the custom boxes"])

        </div>
    </div>


    <div class="row">

        <div class="col-lg-6">

            <blockquote>
                <h6>Example: Missing</h6>

                <p>
                    In order to say why Descartes has adopted the skeptical method of the Meditations, you need to
                    tell the
                    reader what Descartes is hoping to achieve.
                    <ins> However, you didn't do this. This leaves it up to your reader to figure out that
                        Descartes
                    </ins>
                    is trying to discover what kinds of beliefs can be the completely certain foundations upon which
                    the
                    rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be
                    wrong about. Then he can work backwards to explaining why and when, for example, scientific
                    beliefs count
                    as certain knowledge.
                    <ins>As you can see, this is pretty complicated. So you can't just assume that the reader will
                        figure it
                        out.
                    </ins>
                </p>
            </blockquote>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_response_modal_missing.jpg',
'altText' =>"Altering the stock text through the modal window for missing",
'caption' => "Alter the feedback text for students who forgot the element"])
        </div>

    </div>


    <div class="row">
        <div class="col-lg-6">

            <blockquote>
                <h6>Example: Poor</h6>

                <p>In order to say why Descartes has adopted the skeptical method of the Meditations, you need to
                    tell the
                    reader what Descartes is hoping to achieve.
                    <ins>You tried to do this. But it was not clear from your answer that his goal is to</ins>
                    discover what kinds of beliefs can be the completely certain foundations upon which the rest of
                    our
                    knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about.
                    Then he
                    can work backwards to explaining why and when, for example, scientific beliefs count as certain
                    knowledge.
                </p>
            </blockquote>
        </div>

        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_response_modal_poor.jpg',
'altText' =>"Altering the stock text through the modal window for poor",
'caption' => "Alter the feedback text for students who did a poor job"])

        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">

            <blockquote>
                <h6>Example: Fair</h6>

                <p>
                    <ins>You correctly recognized that</ins>
                    in order to say why Descartes has adopted the skeptical method of the Meditations,
                    <ins>the reader needed to be told</ins>
                    what Descartes is hoping to achieve.
                    <ins>You did a pretty good job here. But it wasn't as clear as it could have been that he</ins>
                    is trying to discover what kinds of beliefs can be the completely certain foundations upon which
                    the
                    rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be
                    wrong
                    about. Then he can work backwards to explaining why and when, for example, scientific beliefs
                    count as
                    certain knowledge.
                </p>
            </blockquote>
        </div>

        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_response_modal_fair.jpg',
'altText' =>"Altering the stock text through the modal window for fair",
'caption' => "Alter the feedback text for students who did a fair job"])

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">

            <blockquote>
                <h6>Example: Excellent</h6>

                <p>
                    <ins>You did a good job recognizing that</ins>
                    in order to say why Descartes has adopted the skeptical method of the Meditations, the reader
                    needed to
                    be told what Descartes is hoping to achieve.
                    <ins>It was completely clear from your answer that he</ins>
                    is trying to discover what kinds of beliefs can be the completely certain foundations upon which
                    the
                    rest of our knowledge can be built.
                    <ins>From your explanation I think a reader would have been able to see that the idea</ins>
                    is to find some beliefs which Descartes can't be wrong about.Then he can work backwards to
                    explaining
                    why and when, for example, scientific beliefs count as certain knowledge.
                </p>
            </blockquote>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_response_modal_excellent.jpg',
'altText' =>"Altering the feedback text through the modal window for excellent",
'caption' => "Alter the feedback text for students who did an excellent job"])

        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$elementAdd['id'] }}" class="group">
    <h4 class="text-center">Adding elements</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To add additional elements, click "Add Element"</p>

            <blockquote>
                <h6>Example: Stock response</h6>

                <p>You need to explain the role doubt plays in Descartes method. He is using a principle like "If I can
                    find
                    grounds for doubting that a kind of belief is true, then no beliefs of that sort count as
                    knowledge".
                    So, for example, if we're talking about beliefs based on seeing things in the distance, I might
                    believe
                    that I see a plane. But then someone points out that birds are often confused with faraway planes.
                    Now I
                    can't say that I know that object in the distance is a plane until I can be sure that it is not a
                    bird.
                </p>
            </blockquote>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_new_second_element.jpg',
'altText' =>"Adding a second element",
'caption' => "Add a second element"])


        </div>

    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_second_element_filled_in.jpg',
'altText' =>"Text added for second element",
'caption' => "Add second element content"])

        </div>
    </div>
</section>


<section id="{{ \App\ViewTools\HelpLinks::$elementSave['id'] }}" class="group">
    <h4 class="text-center">Saving elements</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">None of your edits are saved until you click 'Next question' </p>
        </div>
        <div class="col-lg-6">

            @include('help.partials.picture_container',
['imageFile' => 'element/element_edit_next_question_circled.jpg',
'altText' =>"Next question button circled",
'caption' => "Click the 'Next question'
                    button to save edits and move on to the next
                    question "])
        </div>
    </div>
</section>
