<div class="list-group-item" style="background-color: #DDDDDD;">
    <h5>Element #{{ $eNumber }}: "{{ $elements[$eNumber-1]->getElementName() }}"</h5>
    <div class="row">
                <span class="col-md-5">
                    <!-- score slider -->
                    <input id="sliderQ{{ $qNumber }}E{{ $eNumber }}" type="text"
                           data-slider-ticks="[0,10,20,30]" data-slider-ticks-snap-bounds="0"
                            data-slider-ticks-labels='["Missing","Poor","Fair","Excellent"]'/>
                </span>
                    <!-- comment area -->
                <span class="col-md-7" style="background-color: #DDDDDD;">
                    <textarea class="form-control" rows="4" name="commentQ{{ $qNumber }}E{{ $eNumber }}" placeholder=
                    "Add any comments for this element here.">{{ $elements[$eNumber-1]->getCommentText() }}</textarea>
                </span>
    </div>
</div>

