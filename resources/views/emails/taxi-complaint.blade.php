<p>To whom it may concern,</p>

<p>I would like to report a Taxi Complaint.<br>
This taxi violated the following:</p>
<ul>
    @foreach ($data['violations'] as $violation)
        <li><strong>{{ $violation->name }}</strong></li>
    @endforeach
</ul>

<p>Complaint Details:<br>
Incident Date: <strong>{{ date('M d, Y (l)',
    strtotime($data['complaint']->incident_date)) }}</strong><br>
Incident Time: <strong>
@if (!empty($data['complaint']->incident_time))
     {{ date('g:i a', strtotime($data['complaint']->incident_time)) }}
@else
    N/A
@endif
</strong>
<br>
Incident Location: <strong>{{ $data['complaint']->incident_location ?: 'N/A' }}
    </strong><br>
Notes: <strong>{{ $data['complaint']->notes ?: 'N/A' }}</strong><br>
</p>

<p>Taxi Details:<br>
Plate Number: <strong>{{ $data['taxi']->plate_number }}</strong><br>
Taxi Name: <strong>{{ $data['taxi']->name ?: 'N/A' }}</strong><br>
Taxi Description: <strong>{{ $data['taxi']->description ?: 'N/A' }}</strong><br>
Drivers name: <strong>{{ $data['complaint']->drivers_name ?: 'N/A' }}</strong><br>
</p>

<p>My Contact Info:<br>
Name: <strong>{{ $data['reporter']->name }}</strong><br>
Email: <strong>{{ $data['reporter']->email }}</strong><br>
Conctact Number: <strong>{{ $data['reporter']->contact_number }}</strong><br>
</p>

<?php $url = config('app.url') . '/show/' . $data['taxi']->id; ?>
<p>This email has been sent via
{!! link_to(config('app.url'), 'TaxiComplaint',
    ['target' => '_blank']) !!} app.<br>
You may also view this info at {!! link_to($url, $url,
    ['target' => '_blank']) !!}
</p>

<p>Regards,<br>
{{ $data['reporter']->name }}</p>
