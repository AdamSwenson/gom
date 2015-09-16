<!-- template used by 'grade_exam' to host -->
<div class="list-group-item" style="background-color: #DDDDDD;" id="element{{ $count }}" data-element-index="{{ $count }}"
     data-element-id="{{ $elements[$eNumber-1]->getId() }}">
    <h5>Element #{{ $eNumber }}: "{{ $elements[$eNumber-1]->getElementName() }}"</h5>
    <div class="row">
                <span class="col-md-5">
                    <!-- score slider -->
                    <label for="sliderQ{{ $qNumber }}E{{ $eNumber }}"></label>
                    <input class="slider" id="sliderQ{{ $qNumber }}E{{ $eNumber }}" type="text"/>
                </span>
                    <!-- comment area -->
                <span class="col-md-7" style="background-color: #DDDDDD;">
                    <textarea class="form-control" rows="4" name="commentQ{{ $qNumber }}E{{ $eNumber }}" placeholder=
                    "No score for this element"></textarea>
                </span>
    </div>
</div>

