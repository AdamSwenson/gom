<!-- this form describes the input form and buttons for an individual question -->
<li class="list-group-item"  id="questionItem{{ isset($q) ? $counter : 1 }}">
    <h4 id="displayNumber">Question #{{ isset($q) ? $counter : 1 }}</h4>
    <div class="input-group">
        <span class="input-group-addon">Question Name</span>
        <input id="questionName{{ isset($q) ? $counter : 1 }}"
               name="questionName{{ isset($q) ? $counter : 1 }}" type="text" class="form-control input"
               value="{{ isset($q) ? $q['qObj']->getQuestionName() : '' }}"
               placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
               aria-describedby="basic-addon1">
    </div>
    <h5>Question Text</h5>

    <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText{{ isset($q) ? $counter : 1 }}"
                  name="questionText{{ isset($q) ? $counter : 1 }}"
                  placeholder="Enter the full question text(optional)">{{ isset($q) ? $q['qObj']->getQuestionText() : '' }}</textarea>
    </div>
    <div class="form-group">
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
        </span>
        <button class="btn btn-warning btn-sm" type="button" ><span class="js-remove"><span
                        class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
        </button>
    </div>
    <input type="hidden" id="questionId" name="questionId{{isset($q) ? $counter : 1}}"
           value="{{ isset($q) ? $q['qObj']->getId() : '0' }}"/>
</li>