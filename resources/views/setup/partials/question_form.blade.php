<!-- Used by "edit_question" to hold fields and buttons for an individual question -->
<li class="list-group-item" id="questionItem{{ $counter }}">

    <div class="row">
        <div class="col-sm-4">
            <h4 id="displayNumber">Question #{{ $counter }}</h4>
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4" style="text-align: left">
            <!-- max grade -->
            <div class="input-group">
                <span class="input-group-addon">Max Score</span>
                <input id="maxScore{{ $counter }}" style="width:6em;" name="maxScore{{ $counter }}" type="number" min="0"
                       title="maximum score for this question"
                       class="form-control input" aria-describedby="basic-addon" value="{{ $q['max_score'] or '' }}">
            </div>
        </div>
    </div>
    <!-- question name -->
    <div class="input-group">
        <span class="input-group-addon">Question Name</span>
        <input id="questionName{{ $counter }}"
               name="questionName{{ $counter }}"
               type="text"
               class="form-control input"
               value="{{ isset($q) ? $q->getQuestionName() : '' }}"
               placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
               aria-describedby="basic-addon">
    </div>
    <h5>Question Text</h5>

    <div class="form-group">
        <textarea class="form-control"
                  rows="3"
                  id="questionText{{ $counter }}"
                  name="questionText{{ $counter }}"
                  placeholder="Enter the full question text (optional)">{{ isset($q) ? $q->getQuestionText() : '' }}</textarea>
    </div>
    <div class="form-group">
        <span id="moveQuestionButton{{ $counter }}"
              class="btn btn-info btn-sm handle">
            <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
            Move
        </span>

        <a id="deleteQuestionButton{{ $counter }}"
           class="btn btn-danger btn-sm js-remove">
            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            Delete
        </a>
    </div>
    <input type="hidden" id="questionId" name="questionId{{ $counter }}"
           value="{{ isset($q) ? $q->getId() : '0' }}"/>
</li>