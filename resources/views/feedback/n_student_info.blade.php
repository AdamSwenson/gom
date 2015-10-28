<div id="studentInfo">
    <div class="row">
        <dl class="dl-horizontal">
            @if($data->name)
                <dt>Name</dt>
                <dd>{{ $data->name }}</dd>
            @endif

            @if($data->student_id)
                <dt>ID</dt>
                <dd>{{ $data->student_id }}</dd>
            @endif

            <dt>Grade</dt>
            <dd>{{ $data->grade() }}</dd>

            <dt>Access Code</dt>
            <dd>{{ $data->getAccessKey() }}</dd>
        </dl>
    </div>
</div>