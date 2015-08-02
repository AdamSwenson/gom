<!-- this form describes the input form and buttons for an individual element -->
<li class="list-group-item" id="elementItem{{ isset($e) ? $counter : 1 }}">
    <h4 id="displayNumber">Element #{{ isset($e) ? $counter : 1 }}</h4>

    <div class="input-group">
        <span class="input-group-addon">Element Name</span>
        <input id="elementName{{ isset($e) ? $counter : 1 }}"
               name="elementName{{ isset($e) ? $counter : 1 }}" type="text" class="form-control input"
               value="{{ isset($e->elementName ) ? $e->elementName : '' }}"
               placeholder="(Optional) Enter a short reminder for this element, i.e. &quot;Economic causes of the Civil War&quot; "
               aria-describedby="basic-addon1">
    </div>
    <h5>Element Response</h5>

    <div class="form-group">
        <textarea class="form-control" rows="3" id="elementText{{ isset($e) ? $counter : 1 }}"
                  name="elementText{{ isset($e) ? $counter : 1 }}"
                  placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."
                >{{ isset($e->elementName ) ? $e->commentText  : '' }}</textarea>
    </div>
    <div class="form-group">
        <!-- move -->
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
        </span>
        <!-- customize responses -->
        <a class="btn btn-info btn-sm" id="btnCustomizeResponse{{ isset($e) ? $counter : 1 }}" data-toggle="modal"
                data-target="#commentForm{{ isset($e) ? $counter : 1 }}">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            Customize Responses
        </a>
        @include('setup.comment_form')

                <!-- delete button -->
        <a class="btn btn-warning btn-sm" type="button"><span class="js-remove"><span
                        class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
        </a>
    </div>
    <input type="hidden" id="elementId" name="elementId{{isset($e) ? $counter : 1}}"
           value="{{ isset($e['eObj']) ? $e['eObj']->getId() : '0' }}"/>
</li>