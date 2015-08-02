<!-- used to display an individual element in the edit_element view -->
<ul style="display: none" id="hiddenElementList">
    <li class="list-group-item" id="emptyElementItem">
        <h4 id="displayNumber">Element #0</h4>

        <div class="input-group">
            <span class="input-group-addon">Element Name</span>
            <input id="elementName0" name="elementName0" type="text" class="form-control input" value=""
                   placeholder="(Optional) Enter a short reminder for this element, i.e. &quot;Economic causes of the Civil War&quot; "
                   aria-describedby="basic-addon1">

        </div>
        <h5>Element Response</h5>

        <div class="form-group">
        <textarea class="form-control" rows="3" id="elementText0" name="elementText0"
                  placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."></textarea>
        </div>
        <div class="form-group">
            <!-- move -->
        <a class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
                </a>

            <!-- customize -->
            <a class="btn btn-info btn-sm" id="btnCustomizeResponse0" data-toggle="modal"
                    data-target="#commentForm0">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Customize Responses
            </a>
            @include('setup.comment_form')

            <!-- delete -->
            <a class="btn btn-warning btn-sm"><span class="js-remove"><span
                            class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
            </a>
        </div>
        <input type="hidden" id="elementId" name="elementId" value="0"/>
    </li>
</ul>