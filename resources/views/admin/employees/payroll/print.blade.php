<html>
    <body onload="window.print();">
        <h4 style="text-align:center;">{{ substr($Employee->fullname, 0, 20) .((strlen($Employee->fullname) > 20) ? '...' : '') }} (s) Payroll Sheet</h4>
        <table class="tabel table-striped" border="1" width="100%;">
            <tr>
                <th>Date</th>
                <th>Hours</th>
                <th>Short Hrs</th>
                <th>Overtime</th>
                <th>Hourly Rate</th>
                <th>Total Amount</th>
            </tr>
            @if(!$Employee_time_punches->isEmpty())
                @foreach($Employee_time_punches as $Employee_time_punch)
                    <tr>
                        <td align="center">{{ date('m/d/Y',strtotime($Employee_time_punch->date)) }}</td>
                        <td align="center">{{ $Employee_time_punch->total_hrs }}</td>
                        <td align="center">{{ $Employee_time_punch->total_hrs-$Employee_time_punch->total_hrs }}</td>
                        <td align="center">{{ $Employee_time_punch->overtime_hrs }}</td>
                        <td align="center">$&nbsp;{{ $Employee->starting_pay_rate  }}/hr</td>
                        <td align="center">$&nbsp;{{ $Employee->starting_pay_rate*$Employee_time_punch->total_hrs  }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="6">No Employee payroll data found.</td></tr>
            @endif
        </table>
    </body>
</html>
