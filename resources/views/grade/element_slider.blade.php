<div id="q<?php echo "$count" ?>-panel" class="tab-pane fade <?php if($count==1) { echo "in active";} ?>">
    <h4>
        <div class="row">
            <span class="col-md-4">Input Score: </span>
            <span class="col-md-8">Custom Score: </span>
        </div>
    </h4>
    <div class="list-group">
        <div class="list-group-item">
            <h5>E1: "Element Description"</h5>
            <input class="slider slider-horizontal" id="ex1" data-slider-id='ex1' type="text" data-slider-min="0" data-slider-max="20"
                   data-slider-step="1" data-slider-value="14"/>
        </div>
        <div class="list-group-item">
            <h5>E2: "Element Description"</h5>
            <!--
            <input id="ex2" type="text" data-slider-min="0" data-slider-max="100"
                   data-slider-step="1" data-slider-value="50" data-slider-orientation="horizontal">
                   -->

        </div>
        <div class="list-group-item">
            <h5>E3: "Element Description"</h5>
            <input id="ex3" type="text"/>
        </div>
    </div>
</div>