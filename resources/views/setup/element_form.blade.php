<!-- this form describes the input form and buttons for an individual question -->
<li class="list-group-item" id="questionItem{{ isset($q) ? $counter : 1 }}">
    <h4 id="displayNumber">Element #{{ isset($q) ? $counter : 1 }}</h4>

    <div class="input-group">
        <span class="input-group-addon">Element Name</span>
        <input id="questionName{{ isset($q) ? $counter : 1 }}"
               name="questionName{{ isset($q) ? $counter : 1 }}" type="text" class="form-control input"
               value="{{ isset($q['qName']) ? $q['qName'] : '' }}"
               placeholder="(Optional) Enter a short reminder for this element, i.e. &quot;Economic causes of the Civil War&quot; "
               aria-describedby="basic-addon1">
    </div>
    <h5>Element Response</h5>

    <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText{{ isset($q) ? $counter : 1 }}"
                  name="questionText{{ isset($q) ? $counter : 1 }}"
                  placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."
                >{{ isset($q['qDesc']) ? $q['qDesc'] : '' }}</textarea>
    </div>
    <div class="form-group">
        <!-- move -->
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
        </span>
        <!-- customize responses -->
        <button class="btn btn-info btn-sm" id="customizeElement" data-toggle="modal" data-target="#customizeResponse">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            Customize Responses
        </button>

        @include('setup.comment_form')

                <!-- delete button -->
        <button class="btn btn-warning btn-sm" type="button"><span class="js-remove"><span
                        class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
        </button>
    </div>
    <input type="hidden" id="questionId" name="questionId{{isset($q) ? $counter : 1}}"
           value="{{ isset($q) ? $q['qObj']->getId() : '0' }}"/>
</li>