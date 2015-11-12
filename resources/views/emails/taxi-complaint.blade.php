<p>To whom it may concern,</p>

<br>

<p>I would like to report a Taxi Complaint.</p>

<br>

<p>This taxi violated the following:</p>
<ul>
    @foreach ($data['violations'] as $violation)
        <li><strong>{{ $violation['name'] }}</strong></li>
    @endforeach
</ul>

<br>

<p>Complaint Details:<br>
Ref #: <strong>{{ $data['complaint']['id'] }}</strong><br>
Incident Date: <strong>{{ date('M d, Y (l)',
    strtotime($data['complaint']['incident_date'])) }}</strong><br>
Incident Time: <strong>
@if (!empty($data['complaint']['incident_time']))
     {{ date('g:i a', strtotime($data['complaint']['incident_time'])) }}
@else
    N/A
@endif
</strong>
<br>
Incident Location: <strong>{{ $data['complaint']['incident_location'] ?: 'N/A' }}
    </strong><br>
Notes: <strong>{{ $data['complaint']['notes'] ?: 'N/A' }}</strong><br>
</p>

<br>

<p>Taxi Details:<br>
Plate Number: <strong>{{ $data['taxi']['plate_number'] }}</strong><br>
Taxi Name: <strong>{{ $data['taxi']['name'] ?: 'N/A' }}</strong><br>
Taxi Description: <strong>{{ $data['taxi']['description'] ?: 'N/A' }}</strong><br>
Drivers name: <strong>{{ $data['complaint']['drivers_name'] ?: 'N/A' }}</strong><br>
</p>

<br>

<p>My Contact Info:<br>
Name: <strong>{{ $data['reporter']['name'] }}</strong><br>
Email: <strong>{{ $data['reporter']['email'] }}</strong><br>
Conctact Number: <strong>{{ $data['reporter']['contact_number'] }}</strong><br>
</p>

<br>

<?php $url = config('app.url') . '/' . $data['taxi']['id']; ?>
<p>This email has been sent via
{!! link_to(config('app.url'), 'TaxiComplaint',
    ['target' => '_blank']) !!} app.<br>
You may also view this info at {!! link_to($url, $url,
    ['target' => '_blank']) !!}
</p>

<br>

<p>Regards,<br>
{{ $data['reporter']['name'] }}</p>

