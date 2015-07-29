
    <!-- a blank question form to use for clones -->
    <ul style="display: none" id="hiddenQuestionList">
        <li class="list-group-item" id="emptyQuestionItem">
            <h4 id="displayNumber">Question #0</h4>

            <div class="input-group">
                <span class="input-group-addon">Question Name</span>
                <input id="questionName0" name="questionName0" type="text" class="form-control input" value=""
                       placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
                       aria-describedby="basic-addon1">

            </div>
            <h5>Question Text</h5>

            <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText0" name="questionText0"
                  placeholder="Enter the full question text(optional)"></textarea>
            </div>
            <div class="form-group">
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
                </span>
                <button class="btn btn-warning btn-sm"><span class="js-remove"><span
                                class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
                </button>
            </div>
            <input type="hidden" id="questionId" name="questionId" value="0"/>
        </li>
    </ul>
