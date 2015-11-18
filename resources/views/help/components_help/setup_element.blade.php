<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="figure">
            <p class="picture">
                <img src="{{ asset('images/element_edit_screen.jpg') }}"
                     class="img-responsive"
                     alt="The element editing screen">
            </p>

            <p class="pictureCaption">The element editing screen</p>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>

<section id="{{\App\ViewTools\HelpLinks::$elementWhat['id']}}" class="group">
    <h4 class="text-center">What elements are and what they do</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer"><i>Elements</i> can be a bit tricky to explain since they have multiple roles and are very
                flexible. On their most basic use, elements have three jobs:</p>
            <ol>
                <li>Elements comprise questions</li>
                <li>Elements form the basis of feedback</li>
                <li>Elements let you compare student performance across different exams</li>
            </ol>
        </div>
        <div class="col-lg-6">
            @include('help.partials.field_table', ['fields' => [
            ['name' => 'Element name', 'required' => true],
            ['name' => 'Element response', 'required' => false],
            ['name' => 'Element response: Missing', 'required' => false],
            ['name' => 'Element response: Poor', 'required' => false],
            ['name' => 'Element response: Fair', 'required' => false],
            ['name' => 'Element response: Excellent', 'required' => false],
            ]])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Elements comprise questions. On more complex questions, where you are asking the student
                to do
                multiple things or where explaining a concept requires several different components, each task or
                component
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
            <blockquote>
                <p><em>Scene: A good student comes to your office, distraught after doing poorly on one question on the
                        exam.</em></p>

                <p><strong>Student</strong> What did I miss? What should I have done?</p>

                <p><strong>You</strong> Well, let's see. You needed to do x, y, and z.
                    You did a good job on x. But you totally forgot to bring up y. And there were several mistakes
                    in your explanation of z.</p>
            </blockquote>
            <div class="answer">Whatever you fill in for x, y, and z in that conversation are the elements of the
                question
            </div>
        </div>
        <div class="col-lg-6"></div>
    </div>

</section>

<section id="{{\App\ViewTools\HelpLinks::$elementCreate['id']}}" class="group">
    <h4 class="text-center">Creating elements and comments</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">On the "create & edit elements" page, you create and edit elements.</p>

            <p class="answer">To do this, you provide a short name for the element which which will be meaningful to you
                when you see it during grading and when displayed in charts.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_name_filled_in.jpg') }}"
                         class="img-responsive"
                         alt="The element name field has been filled in with text">
                </p>

                <p class="pictureCaption">Name the element</p>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">You then also provide some text that will form the basis for all feedback that you give on
                the
                element.</p>

            <p class="answer">In "element response", enter the basic description of what the student should do to fully
                answer the element.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_stock_text.jpg') }}"
                         class="img-responsive"
                         alt="The stock text field has been filled in">
                </p>

                <p class="pictureCaption">Add stock feedback</p>
            </div>
        </div>
    </div>
</section>


<section id="{{ \App\ViewTools\HelpLinks::$elementCustomize['id'] }}" class="group">
    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you just wanted to give every student the same feedback regardless of how they do,
                you can
                stop here.</p>

            <p class="answer">However, pressing the "Customize Response" button allows you to further customize the
                text to
                reflect performance.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_customize_circled.jpg') }}"
                         class="img-responsive"
                         alt="The customize response button has been circled">
                </p>

                <p class="pictureCaption">Customize Response </p>
            </div>
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

            <h6>Stock reply</h6>

            <blockquote><p>In order to say why Descartes has adopted the skeptical method of the Meditations, you
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

            <p class="answer">The text and pictures below are examples of how we might alter the stock feedback for
                different levels of performance.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_response_modal_orig.jpg') }}"
                         class="img-responsive"
                         alt="The the custom response text in the pop up is just the stock feedback entered">
                </p>

                <p class="pictureCaption">Stock text initially populates the custom boxes</p>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-lg-6">
            <h6>Missing</h6>
            <blockquote>
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
                    wrongabout. Then he can work backwards to explaining why and when, for example, scientific
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
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_response_modal_missing.jpg') }}"
                         class="img-responsive"
                         alt="Altering the stock text through the modal window for missing">
                </p>

                <p class="pictureCaption">Alter the feedback text for students who forgot the element</p>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-lg-6">
            <h6>Poor</h6>
            <blockquote>
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
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_response_modal_poor.jpg') }}"
                         class="img-responsive"
                         alt="Altering the stock text through the modal window for poor">
                </p>

                <p class="pictureCaption">Alter the feedback text for students who did poorly</p>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">

            <h6>Fair</h6>
            <blockquote>
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
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_response_modal_fair.jpg') }}"
                         class="img-responsive"
                         alt="Altering the stock text through the modal window for fair">
                </p>

                <p class="pictureCaption">Alter the feedback text for students who did fairly </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h6>Excellent</h6>
            <blockquote>
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
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_response_modal_excellent.jpg') }}"
                         class="img-responsive"
                         alt="Altering the feedback text through the modal window for excellent">
                </p>

                <p class="pictureCaption">Alter the feedback text for students who did well </p>
            </div>
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$elementAdd['id'] }}" class="group">
    <h4 class="text-center">Adding elements</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To add additional elements, click "Add Element"</p>

            <h6>Stock response</h6>
            <blockquote>
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
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_new_second_element.jpg') }}"
                         class="img-responsive"
                         alt="Adding a second element">
                </p>

                <p class="pictureCaption">Add a second element </p>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_second_element_filled_in.jpg') }}"
                         class="img-responsive"
                         alt="Text added for second element">
                </p>

                <p class="pictureCaption">Add second element content</p>
            </div>
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
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/element_edit_next_question_circled.jpg') }}"
                         class="img-responsive"
                         alt="Next question button circled">
                </p>

                <p class="pictureCaption">Click the 'Next question'
                    button to save edits and move on to the next
                    question </p>
            </div>
        </div>
    </div>
</section>
