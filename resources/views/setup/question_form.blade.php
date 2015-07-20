<!-- this form describes the input form and buttons for an individual question -->
<div id="questionPane">
    <hr/>
    <h4>Question #1</h4>
    <div class="input-group">
        <span class="input-group-addon" id="questionLabel">Question Name</span>
        <input id="questionName" type="text" class="form-control input" placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
               aria-describedby="basic-addon1">
    </div>
    <h5>Question Text</h5>
    <div class="form-group">
        <textarea class="form-control" rows="4" id="questionText" placeholder="Enter the full question text(optional)"></textarea>
    </div>

    <p></p>
    <button class="btn btn-default" id="moveUp"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
    </button>

    <button class="btn btn-default" id="moveDown"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
    </button>

    <button class="btn btn-warning" id="deleteQuestion"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
    Delete</button>

</div>