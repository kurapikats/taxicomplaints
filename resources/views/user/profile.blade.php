@extends('layouts.backend')

@section('page_scripts')
@parent
{!! Html::script('components/jquery-colorbox/jquery.colorbox-min.js') !!}
<script type="text/javascript">
(function() {
    $('.nav-tabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    $('.user-photo a').colorbox({
        maxHeight: '100%',
        title: '{{ $user->name }}',
        photo: true
    });
})();
</script>
@stop

@section('page_styles')
@parent
<style type="text/css">
.user-photo {
    border: 1px solid #000;
    margin-right: 10px;
    margin-bottom: 10px;
}
</style>
@stop

@section('content')
    <br>
    <div class="row">
        <div class="user-profile-con">

            @if (session('status'))
                <div class="alert alert-success alert-dismissible">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    {{ session('error') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#user-profile"
                    aria-controls="user-profile" role="tab"
                    data-toggle="tab">User Profile</a></li>
                <li role="presentation"><a href="#edit-profile"
                    aria-controls="edit-profile" role="tab" data-toggle="tab">
                    Edit Profile</a></li>
                <li role="presentation"><a href="#change-password"
                    aria-controls="change-password" role="tab"
                    data-toggle="tab">Change Password</a></li>
            </ul> <! /.nav-tabs -->

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="user-profile">
                    <div class="user-photo pull-left">
                        <a href="{{ $user->photo }}">
                            <img src="{{ $user->photo ?:
                                'http://lorempixel.com/g/100/100/' }}"
                                title="{{ $user->name }}" width="100">
                        </a>
                    </div>
                    <div class="">
                        <strong>{{ $user->name }}</strong><br>
                        Location: {{ $user->address }}<br>
                        Contact #: {{ $user->contact_number }}<br>
                        Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a><br>
                        Role: {{ $user->role()->name }}<br>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="edit-profile">
                    {!! Form::open(['files' => true, 'url' => '/profile/update',
                        'id' => 'profile-form', 'method' => 'put',
                        'class' => 'form-horizontal']) !!}

                        {!! Form::hidden('_token', csrf_token()) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Full Name *',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('name', $user->name,
                                    ['class' => 'form-control',
                                    'placeholder' => 'ie. Cloud Strife']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', 'Location *',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('address', $user->address,
                                    ['class' => 'form-control',
                                    'placeholder' => 'ie. Makati']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('contact_number', 'Contact Number *',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('contact_number', $user->contact_number,
                                    ['class' => 'form-control',
                                    'placeholder' => 'ie. 09178312034']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('photo', 'Photo',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::file('photo',
                                    ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-sm-offset-2">
                                {!! Form::submit('Submit',
                                    ['class' => 'btn btn-primary btn-sm']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div role="tabpanel" class="tab-pane fade" id="change-password">
                    {!! Form::open(['url' => '/profile/change-password',
                        'id' => 'change-password-form', 'method' => 'put',
                        'class' => 'form-horizontal']) !!}

                        {!! Form::hidden('_token', csrf_token()) !!}

                        <div class="form-group">
                            {!! Form::label('old_password', 'Current Password *',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::password('old_password',
                                    ['class' => 'form-control',
                                    'placeholder' => 'ie. h3110w0r1d']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'New Password *',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::password('password',
                                    ['class' => 'form-control',
                                    'placeholder' => 'ie. s3cr3t']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm New Password *',
                                ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::password('password_confirmation',
                                    ['class' => 'form-control',
                                    'placeholder' => 'ie. s3cr3t']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-sm-offset-2">
                                {!! Form::submit('Submit',
                                    ['class' => 'btn btn-primary btn-sm']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div> <!-- /.tab-panes -->


        </div> <!-- /.user-profile-con -->
    </div>

    <div class="row">
        <h4>Reported Taxis:</h4>
        @if (count($user->taxi_complaints()) > 0)
            <table class="table table-bordered table-striped table-hover table-condensed col-sm-12">
                @foreach ($user->taxi_complaints() as $tc)
                    <tr>
                        <td class="col-sm-1">{{ $tc->id }}</td>
                        <td class="col-sm-1">{!! link_to('/' . $tc->taxi_id,
                            $tc->taxi()->plate_number) !!}</td>
                        <td class="col-sm-1">{{ date('m/d/y',
                            strtotime($tc->incident_date)) }}</td>
                        <td class="col-sm-1">{{ $tc->incident_time ? date('h:i A',
                            strtotime($tc->incident_time)) : 'N/A'}}</td>
                        <td class="col-sm-2">{{ $tc->drivers_name ?: 'N/A' }}</td>
                        <td class="col-sm-2">{{ $tc->incident_location ?: 'N/A' }}</td>
                        <td class="col-sm-2">{{ $tc->notes ?: 'N/A'}}</td>
                        <td class="col-sm-2">{{ $tc->taxi()->name }}</td>
                    </tr>
                @endforeach
                </tr>
            </table>
            {!! $user->taxi_complaints()->render() !!}
        @endif
    </div>
@stop

