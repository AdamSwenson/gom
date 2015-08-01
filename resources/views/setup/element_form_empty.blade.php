<!-- used to display an individual element in the edit_element view -->
<ul style="display: none" id="hiddenQuestionList">
    <li class="list-group-item" id="emptyQuestionItem">
        <h4 id="displayNumber">Question #0</h4>

        <div class="input-group">
            <span class="input-group-addon">Element Name</span>
            <input id="questionName0" name="questionName0" type="text" class="form-control input" value=""
                   placeholder="(Optional) Enter a short reminder for this element, i.e. &quot;Economic causes of the Civil War&quot; "
                   aria-describedby="basic-addon1">

        </div>
        <h5>Element Response</h5>

        <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText0" name="questionText0"
                  placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."></textarea>
        </div>
        <div class="form-group">
            <!-- move -->
        <a class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
                </a>

            <!-- customize -->
            <a class="btn btn-info btn-sm" id="customizeElement0" data-toggle="modal"
                    data-target="#customizeResponse0">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Customize Responses
            </a>
            @include('setup.comment_form')

            <!-- delete -->
            <a class="btn btn-warning btn-sm"><span class="js-remove"><span
                            class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
            </a>
        </div>
        <input type="hidden" id="questionId" name="questionId" value="0"/>
    </li>
</ul>