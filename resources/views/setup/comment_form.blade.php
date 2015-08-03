<!-- comment_form displays the custom response modal -->
<div class="modal fade" id="commentForm{{ $counter }}" role="dialog">
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
                    <li role="presentation" class="active"><a id="tab0" data-toggle="tab" href="#e{{ $counter }}valence0">Missing</a></li>
                    <li role="presentation"><a id="tab1" data-toggle="tab" href="#e{{ $counter }}valence1">Poor</a></li>
                    <li role="presentation"><a id="tab2" data-toggle="tab" href="#e{{ $counter }}valence2">Fair</a></li>
                    <li role="presentation"><a id="tab3" data-toggle="tab" href="#e{{ $counter }}valence3">Excellent</a></li>
                </ul>
                <div class="tab-content" id="comments">
                    <div id="e{{ $counter }}valence0" class="tab-pane fade in active">
                        <textarea class="form-control" rows="5" name="e{{ $counter }}valence0"
                                  placeholder="Write a response if the element is missing."
                                >{{ isset($e->comments[0]->body) ? $e->comments[0]->body : ''  }}</textarea>
                    </div>
                    <div id="e{{ $counter }}valence1" class="tab-pane fade">
                        <textarea class="form-control" rows="5" name="e{{ $counter }}valence1"
                                  placeholder="Modify the response for a student that did a poor job of addressing this element."
                                >{{ isset($e->comments[1]->body) ? $e->comments[1]->body : ''  }}</textarea>
                    </div>
                    <div id="e{{ $counter }}valence2" class="tab-pane fade">
                        <textarea class="form-control" rows="5" name="e{{ $counter }}valence2"
                                  placeholder="This response is if the student did a fair job on the element."
                                >{{ isset($e->comments[2]->body) ? $e->comments[2]->body : ''  }}</textarea>
                    </div>
                    <div id="e{{ $counter }}valence3" class="tab-pane fade">
                        <textarea class="form-control" rows="5" name="e{{ $counter }}valence3"
                                  placeholder="Here, response for a student that who did an excellent job on this element."
                                >{{ isset($e->comments[3]->body) ? $e->comments[3]->body : ''  }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default confirm-btn"
                        data-dismiss="modal">Save
                </button>
            </div>
        </div>
    </div>
</div>