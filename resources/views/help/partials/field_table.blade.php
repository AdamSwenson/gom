<div class="fieldTable">
    <dl class="dl-horizontal">
        @foreach($fields as $field)
            <dt>{{ $field['name'] }}</dt>
            <dd>{{ $field['required'] ? 'Required' : 'Optional' }}</dd>
        @endforeach
    </dl>
</div>