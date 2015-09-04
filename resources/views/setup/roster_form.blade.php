<tr class="dataRow" id="dataRow{{ $row }}">
    <td><input class="form-control" type="text" id="lastName" name="lastName{{ $row }}" placeholder="Last Name"
               value="{{ $s['last_name'] or '' }}"
               style="border:none;">
    </td>
    <td><input class="form-control" type="text" id="firstName" name="firstName{{ $row }}" placeholder="First Name"
               value="{{ $s['first_name'] or '' }}"
               style="border:none;">
    </td>
    <td><input class="form-control" type="text" id="studentIdentifier" placeholder="Student ID"
               name="studentIdentifier{{ $row }}" value="{{ $s['student_identifier'] or '--' }}"
               style="border:none;">
    </td>
    <td><input class="form-control" type="text" id="email" name="email{{ $row }}" placeholder="e-mail"
               value="{{ $s['email'] or '--' }}"
               style="border:none;">
    </td>
    <td align="center" style="vertical-align: middle;">
        <a onclick="deleteStudent({{ $row }})" id="deleteButton" >
            <span class="glyphicon glyphicon-remove" style="font-size: 1.2em; color: #EE0000;" aria-hidden="true"></span>
        </a>
    </td>
    <input type="hidden" name="id{{ $row }}" value="{{ $s['id'] or '0' }}">
</tr>