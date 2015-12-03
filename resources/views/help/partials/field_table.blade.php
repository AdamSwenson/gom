<div class="fieldTable">
    <table class="table table-condensed">
        <caption>{{ $caption }}</caption>
        <thead>
        <tr>
            <th>Field</th>
            <th>Required</th>
            <th>Visible to students</th>
        </tr>
        </thead>
        <tbody>
        @foreach($fields as $field)
            <tr>
                <td>{{ $field['name'] }}</td>
                <td>{{ $field['required'] ? 'Required' : 'Optional' }}</td>
                <td>{{ $field['visible'] ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{--<dl class="dl-horizontal">--}}
    {{--@foreach($fields as $field)--}}
    {{--<dt>{{ $field['name'] }}</dt>--}}
    {{--<dd>{{ $field['required'] ? 'Required' : 'Optional' }}</dd>--}}
    {{--@endforeach--}}
    {{--</dl>--}}
</div>