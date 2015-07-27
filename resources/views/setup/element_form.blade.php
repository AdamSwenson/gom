<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 3:10 PM
 */
    This form describes the layout for editing or creating an element.
-->

<!-- this Div will become the element template -->

<div id="elementForm">
    <hr/>
    <h4>Element #<span id="element">1</span></h4>
    <div class="input-group">
        <span class="input-group-addon" id="elementLabel">Element Name</span>
        <input id="elementName" type="text" class="form-control input"
               placeholder="(Optional) Enter a short reminder for this element, i.e. &quot;Economic causes of the Civil War&quot; "
               aria-describedby="basic-addon1">
    </div>
    <h5>Element Response</h5>
    <div class="form-group">
        <textarea class="form-control" rows="4" id="questionText" placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."></textarea>
    </div>
    <button class="btn btn-sm" id="moveUp"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
    </button>
    <button class="btn btn-sm" id="moveDown"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
    </button>
    <button class="btn btn-info btn-sm" id="customizeElement" data-toggle="modal" data-target="#customizeResponse">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        Customize Responses</button>

    <!-- this Modal should be broken out into a template to handle custom responses -->
    <!-- Modal -->
    @include('setup.response_form')

    <button class="btn btn-warning btn-sm" id="deleteElement" onclick="deleteElement(this.parentNode.id)"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
        Delete</button>
    <br>
</div>