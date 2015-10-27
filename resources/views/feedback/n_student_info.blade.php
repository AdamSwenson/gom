<div id="studentInfo">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <p>
                <span class="studentInfoLabel">Grade:</span> <span class="grade">{{  $data->grade() ? $data->grade() : 'Not Assigned'}}</span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <p>
                <span class="studentInfoLabel">Entry Code:</span> <span class="pseudoID"> {{ $data->getAccessKey() ? $data->getAccessKey() : 'Not Assigned'}}</span>
            </p>
        </div>
    </div>
</div>