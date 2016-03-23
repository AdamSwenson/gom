<tr>
    <!-- width will override the column width setting for term info -->
    <td class="examDetailsCell" >
        {{ $exam->term or '' }}
        {{ $exam->year or '' }}
    </td>
    <td class="examNameCell">
        {{ $exam->name or 'Name Not Found'}}
    </td>

    <td>
        <exam-release-toggle
        exam-id="{{ $exam->id }}"
        released="{{ $exam->isReleased() }}"></exam-release-toggle>

        <exam-buttons-dropdown
             exam-id="{{ $exam->id }}"
             base-url="{!! url() !!}"></exam-buttons-dropdown>
    </td>


</tr>