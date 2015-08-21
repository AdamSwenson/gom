<div class="list-group-item" style="background-color: #DDDDDD;" id="element{{ $count }}" data-element-index="{{ $count }}"
     data-element-id="{{ $elements[$eNumber]->getId() }}">
    <h5>Element #{{ $eNumber+1 }}: "{{ $elements[$eNumber]->getElementName() }}"</h5>
    <div class="row">
                <span class="col-md-5">
                    <!-- score slider -->
                    <input class="slider" id="sliderQ{{ $qNumber }}E{{ $eNumber+1 }}" type="text"/>
                </span>
                    <!-- comment area -->
                <span class="col-md-7" style="background-color: #DDDDDD;">
                    <textarea class="form-control" rows="4" name="commentQ{{ $qNumber }}E{{ $eNumber+1 }}" placeholder=
                    "No score for this element"></textarea>
                </span>
    </div>
</div>

