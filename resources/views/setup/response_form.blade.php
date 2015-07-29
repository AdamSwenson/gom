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
                    <textarea class="form-control" rows="3" id="questionText" placeholder="Write your custom response here."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <!-- added data-token to try csrf token -->
                <button type="button" class="btn btn-default confirm-btn" data-token="{{ csrf_token() }}"
                        data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>