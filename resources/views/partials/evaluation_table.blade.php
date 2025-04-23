<table class="styled-table">
    <thead>
        <tr>
            <th>{{ __('contreq.name') }}</th>
            <th>{{ __('contreq.TotalMark') }}</th>
            <th>{{ __('contreq.ObtainedMark') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->fullname }}</td>
                <td>{{ $employee->temmark }}</td>
                <td>{{ $employee->empmark }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
