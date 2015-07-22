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
    <h4>Element #<span id="elementNumber">1</span></h4>
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
    <button class="btn btn-default btn-sml" id="moveUp"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
    </button>
    <button class="btn btn-default btn-sml" id="moveDown"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
    </button>
    <button class="btn btn-info btn-sml" id="customizeElement" data-toggle="modal" data-target="#customizeResponse">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        Customize Responses</button>

    <!-- this Modal should be broken out into a template to handle custom responses -->
    <!-- Modal -->
    <div class="modal fade" id="customizeResponse" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Customize Responses</h2>
                    Modify the feedback students receive based on their performance
                </div>
                <!-- tabbed area for responses -->
                <div class="modal-body">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="active"><a href="#">Missing</a></li>
                        <li role="presentation"><a href="#">Poor</a></li>
                        <li role="presentation"><a href="#">Fair</a></li>
                        <li role="presentation"><a href="#">Good</a></li>
                    </ul>
                    <div id="customResponse">
                        <textarea class="form-control" rows="4" id="questionText" placeholder="You forgot to include this part in your response."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-warning btn-sml" id="deleteElement" onclick="deleteElement(this.parentNode.id)"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
        Delete</button>
    <br>
</div>