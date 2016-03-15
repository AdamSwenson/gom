<!-- template used by "edit_roster" to display one table row displaying a single student.
    Holds student lname, fname, id, email and delete button -->
<tr class="dataRow {{ $s['failed'] or '' }}"
    id="dataRow{{ $row }}">
    <td>
        <input
                class="form-control"
                type="text"
                id="lastName"
                name="lastName{{ $row }}"
                placeholder="Last Name"
                value="{{ $s['last_name'] or '' }}"
                style="border:none;"
        >
    </td>
    <td>
        <input
                class="form-control"
                type="text"
                id="firstName"
                name="firstName{{ $row }}"
                placeholder="First Name"
                value="{{ $s['first_name'] or '' }}"
                style="border:none;">
    </td>
    <td>
        <input
                class="form-control"
                type="text"
                id="studentIdentifier"
                placeholder="Student ID"
                name="studentIdentifier{{ $row }}"
                style="border:none;"
                value="{{ !empty($s['student_identifier']) ? $s['student_identifier'] : '' }}"
        >
    </td>
    <td>
        <input
                class="form-control"
                type="text"
                id="email"
                name="email{{ $row }}"
                placeholder="Email"
                value="{{ $s['email'] or '' }}"
                style="border:none;"
        >
    </td>
    <td align="center" style="vertical-align: middle;">
        <a
           class="deleteStudentButton"
           data-rowid="{{ $row }}"
           id="deleteButton"
        >
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </a>
    </td>
    <input
            type="hidden"
            name="id{{ $row }}"
            value="{{ $s['id'] or '0' }}"
    >
</tr>