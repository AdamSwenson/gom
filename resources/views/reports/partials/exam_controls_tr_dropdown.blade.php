<tr id="reportsForExam{{ $examId }}">
    <!-- width will override the column width setting for term info -->
    <td class="examDetailsCell" >
        {{ $exam1->term or '' }}
        {{ $exam1->year or '' }}
    </td>
    <td class="examNameCell">
        {{ $exam1->name or 'Name Not Found'}}
    </td>

    <td>
        <exam1-release-toggle
        exam1-id="{{ $exam1->id }}"
        released="{{ $exam1->isReleased() }}"
        previously-released="{{ $exam1->wasPreviouslyReleased() }}"
        graded="{{ $exam1->isGraded() }}"></exam1-release-toggle>

        <exam1-buttons-dropdown
             exam1-id="{{ $exam1->id }}"
             base-url="{!! url('') !!}"></exam1-buttons-dropdown>
    </td>


</tr>