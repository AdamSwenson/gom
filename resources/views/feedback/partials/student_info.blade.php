<div id="studentInfo">
    <div class="row">
        <dl class="dl-horizontal">
            @if(isset($data['studentName']))
                <dt>Name</dt>
                <dd><span id="studentName">{{ $data['studentName'] }}</span></dd>
            @endif

            @if(isset($data['studentIdentifier']))
                <dt>ID</dt>
                <dd><span id="studentIdentifier">{{ $data['studentIdentifier'] }}</span></dd>
            @endif

            @if( isset($data['grade']))
                <dt>Grade</dt>
                <dd><span id="letterGrade">{{ $data['grade'] }}</span></dd>
            @endif

            @if(isset($data['accessKey']))
                <dt>Access Code</dt>
                <dd><span id="accessKey">{{ $data['accessKey'] }}</span></dd>
            @endif
        </dl>
    </div>
</div>