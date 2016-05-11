<div id="studentInfo">
    <div class="row">
        <dl class="dl-horizontal">
{{--            @if(array_key_exists('studentName', $data))--}}
                <dt>Name</dt>
                <dd>{{ $data['studentName'] }}</dd>
            {{--@endif--}}

            {{--@if(array_has('studentIdentifier', $data))--}}
                <dt>ID</dt>
                <dd>{{ $data['studentIdentifier'] }}</dd>
            {{--@endif--}}

{{--            @if(array_has('grade', $data))--}}
                <dt>Grade</dt>
                <dd>{{ $data['grade'] }}</dd>
            {{--@endif--}}

{{--            @if(array_has('accessKey', $data))--}}
                <dt>Access Code</dt>
                <dd>{{ $data['accessKey'] }}</dd>
            {{--@endif--}}
        </dl>
    </div>
</div>