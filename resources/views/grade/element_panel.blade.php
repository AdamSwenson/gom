<div class="list-group-item" style="background-color: #DDDDDD;">
    <h5>Element #{{ $eNumber }}: "{{ $elements[$eNumber-1]->getElementName() }}"</h5>
    <div class="row">
                <span class="col-md-5">
                    <!-- score slider -->
                    <input id="sliderQ{{ $qNumber }}E{{ $eNumber }}" type="text"/>
                </span>
                    <!-- comment area -->
                <span class="col-md-7" style="background-color: #FFFFFF;" id="commentQ{{ $qNumber }}E{{ $eNumber }}">
                    <p>"{{ $elements[$eNumber-1]->getCommentText() }}"</p>
                </span>
    </div>
</div>

