<div class="modal fade" id="customizeResponse{{ isset($q) ? $counter : 1 }}" role="dialog">
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
                <ul class="nav nav-pills nav-justified">
                    <li role="presentation" class="active"><a data-toggle="tab" href="#comment0">Missing</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#comment1">Poor</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#comment2">Fair</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#comment3">Excellent</a></li>
                </ul>
                <div class="tab-content" id="comments">
                    <div id="comment0" class="tab-pane fade in active">
                    <textarea class="form-control" rows="3" id="comText0" placeholder="Write a response if the element is missing."></textarea>
                    </div>
                    <div id="comment1" class="tab-pane fade">
                        <textarea class="form-control" rows="3" id="comText1"
                                  placeholder="Write a response if the student did a poor job of answering this element."></textarea>
                    </div>
                    <div id="comment2" class="tab-pane fade">
                        <textarea class="form-control" rows="3" id="comText2" placeholder="If the student did a good job."></textarea>
                    </div>
                    <div id="comment3" class="tab-pane fade">
                        <textarea class="form-control" rows="3" id="comText3" placeholder="The student did an excellent."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default confirm-btn"
                        data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>