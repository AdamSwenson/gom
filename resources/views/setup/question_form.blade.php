<!-- this form describes the input form and buttons for an individual question -->
<li class="list-group-item"  id="questionItem{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}">
    <h4 id="displayNumber">Question #{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}</h4>
    <div class="input-group">
        <span class="input-group-addon">Question Name</span>
        <input id="questionName{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}"
               name="questionName{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}" type="text" class="form-control input"
               value="{{ isset($q['qName']) ? $q['qName'] : '' }}"
               placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
               aria-describedby="basic-addon1">
    </div>
    <h5>Question Text</h5>

    <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}"
                  name="questionText{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}"
                  placeholder="Enter the full question text(optional)">{{ isset($q['qDesc']) ? $q['qDesc'] : '' }}</textarea>
    </div>
    <div class="form-group">
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
        </span>
        <button class="btn btn-warning btn-sm" type="button"><span class="js-remove"><span
                        class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
        </button>
    </div>
    <input type="hidden" id="questionId" name="questionId{{isset($q['qOrder']) ? $q['qOrder'] : 0}}"
           value="{{ isset($q['qId']) ? $q['qId'] : '0' }}"/>
</li>

<!-- this form describes the input form and buttons for an individual question -->
<li class="list-group-item"  id="questionItem{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}">
    <h4 id="displayNumber">Question #{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}</h4>
    <div class="input-group">
        <span class="input-group-addon">Question Name</span>
        <input id="questionName{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}"
               name="questionName{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}" type="text" class="form-control input"
               value="{{ isset($q['qName']) ? $q['qName'] : '' }}"
               placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
               aria-describedby="basic-addon1">
    </div>
    <h5>Question Text</h5>

    <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}"
                  name="questionText{{ isset($q['qOrder']) ? $q['qOrder'] : 1 }}"
                  placeholder="Enter the full question text(optional)">{{ isset($q['qDesc']) ? $q['qDesc'] : '' }}</textarea>
    </div>
    <div class="form-group">
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
        </span>
        <button class="btn btn-warning btn-sm" type="button"><span class="js-remove"><span
                        class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
        </button>
    </div>
    <input type="hidden" id="questionId" name="questionId{{isset($q['qOrder']) ? $q['qOrder'] : 0}}"
           value="{{ isset($q['qId']) ? $q['qId'] : '0' }}"/>
</li>