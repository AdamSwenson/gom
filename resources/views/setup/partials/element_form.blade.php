<!-- Template used by 'edit_element' to hold the fields and buttons for an individual element.  -->
<li class="list-group-item" id="elementItem{{ $counter }}">
    <h4 id="displayNumber">Element #{{ $counter }}</h4>
    <!-- element name -->
    <div class="input-group">
        <span class="input-group-addon">Element Name</span>
        <input id="elementName{{ $counter }}"
               name="elementName{{ $counter }}" type="text" class="form-control input"
               value="{{ isset($e->elementName ) ? $e->elementName : '' }}"
               placeholder="Enter a short reminder for this element, i.e. &quot;Economic causes of World War I&quot; "
               aria-describedby="basic-addon1">
    </div>
    <h5>Element Response</h5>
    <!-- element description (the "stock comment") -->
    <div class="form-group">
        <textarea class="form-control" rows="3" id="elementText{{ $counter }}"
                  name="elementText{{ $counter }}"
                  placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."
        >@if(isset($e->commentText )){{$e->commentText}}@endif</textarea>
    </div>
    <div class="form-group">
        <!-- move -->
        <span class="btn btn-info btn-sm handle">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move
        </span>
        <!-- customize responses -->
        <a class="btn btn-info btn-sm" id="btnCustomizeResponse{{ $counter }}" data-toggle="modal"
           data-target="#commentForm{{ $counter }}">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            Customize Responses
        </a>
        <!-- 'comment form' displays the modal triggered by 'customize response' button -->
    @include('setup.partials.comment_form')
    <!-- delete button -->
        <a class="btn btn-danger btn-sm js-remove">
            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            Delete
        </a>
    </div>
    <input type="hidden" id="elementId" name="elementId{{ $counter }}"
           value="{{ isset($e) ? $e->getId() : '0' }}"/>
</li>