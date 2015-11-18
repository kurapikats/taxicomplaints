@section('page_scripts')
    @parent
    {!! Html::script('components/moment/min/moment.min.js') !!}
    {!! Html::script('components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}

    <script type="text/javascript">
    $(function () {
        $('#btn-report-modal').click(function() {
            $('#report-modal').modal('show');
        });

        // todo: remove existing form values after hiding the modal
        $('#report-modal').on('hidden.bs.modal', function (e) {
            var form = $('#report-form');

            form[0].reset();

            form.not(':button, :submit, :reset, :hidden')
                .val('')
                .removeAttr('checked')
                .removeAttr('selected');

            var validator = form.validate();
            validator.resetForm();
        });

        $('#incident_date').datetimepicker({
            format: 'YYYY-MM-DD',
            maxDate: moment(),
            showClear: true,
            showClose: true
        });

        $('#incident_time').datetimepicker({
            format: 'LT',
            stepping: 5
        });

        // js validate the form before submitting to the backend
        $("#report-form").validate({
            rules: {
                'plate_number': 'required',
                'name': 'required',
                'incident_date': 'required',
                'violations[]': 'required',
                'reg_password': 'required',
                'reg_password_confirmation': {
                    equalTo: "#reg_password"
                }
            },
            messages: {
                'reg_password_confirmation': {
                    equalTo: 'Password does not match the confirm password.'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "violations[]") {
                  error.appendTo($('#errorViolation'));
                } else {
                  error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: '/api/report',
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function(data) {
                        window.location.href = '#report-modal-anchor';

                        $('.alert-success').fadeIn();
                        setTimeout(function() {
                            $('.alert-success').fadeOut();
                        }, 3000);

                        setTimeout(function() {
                            $('#report-modal').modal('hide');
                        }, 4000);
                    },
                    error: function(data) {
                        window.location.href = '#report-modal-anchor';

                        console.log(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            },
            invalidHandler: function(form) {
                window.location.href = '#report-modal-anchor';
            }
        });
    });
    </script>
@stop

<!-- Begin Report Modal -->
<div class="modal fade" id="report-modal" tabindex="-1" role="dialog"
    aria-labelledby="report-modal-label">
    <div class="modal-dialog large" role="document">
        <div class="modal-content">

            {!! Form::open(['files' => true, 'url' => 'api/report', 'class' => 'form-horizontal',
                'id' => 'report-form']) !!}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="report-modal-label"><strong>
                    <a name="report-modal-anchor">Report Taxi Form</a></strong></h4>
                </div>
                <div class="modal-body">

                    <div class="report-con">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-success" style="display:none;">
                            <span class="glyphicon glyphicon-ok"
                                aria-hidden="true"></span>
                            <span class="sr-only">Success:</span>
                            Taxi Complaint has been recorded.
                        </div> <!-- /.alert-info -->

                        {!! csrf_field() !!}

                        <div class="col-sm-6">

                            @if (!Auth::user())
                                <div class='login-reminder'>
                                    <p>* If you have an existing account please login first.
                                        <strong>
                                            <a href="/auth/login" class="login-modal-open">
                                                Click here to login.</a>
                                        </strong>
                                    </p>
                                    <p>* Don't have an account yet? You can use the
                                        <strong>integrated sign-up form</strong> here.</p>
                                    <br>
                                </div>
                            @endif

                            <div class="form-group">
                                <?php $plate_number = (empty($taxi))?"":$taxi->plate_number ?>
                                {!! Form::label('plate_number', 'Plate Number',
                                    ['class' => 'col-sm-3 control-label req']) !!}
                                    <div class="col-sm-6">
                                        {!! Form::text('plate_number', $plate_number,
                                            ['class' => 'form-control',
                                            'placeholder' => 'ie. ABC 1234']) !!}
                                    </div>
                            </div>
                            <div class="form-group">
                                <?php $name = (empty($taxi))?"":$taxi->name ?>
                                {!! Form::label('name', 'Taxi Name',
                                    ['class' => 'col-sm-3 control-label req']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('name', $name,
                                        ['class' => 'form-control',
                                        'placeholder' => 'ie. Love Taxi']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('incident_date', 'Incident Date',
                                    ['class' => 'col-sm-3 control-label req']) !!}
                                <div class="col-sm-6">
                                    <div class='input-group date' id='incident_date'>
                                        {!! Form::text('incident_date', \Carbon\Carbon::now(),
                                            ['class' => 'form-control',
                                            'placeholder' => 'ie. 2015-12-31']) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if (isset($violations))
                                <div class="form-group">
                                    <div class="center"><strong>Violations
                                        <span class="req">*</span></strong></div>
                                    <div id="errorViolation" class="center"></div>
                                    <div class="col-sm-6">
                                        <?php
                                            $total    = count($violations);
                                            $counter  = 1;
                                            $counter2 = 1;
                                        ?>
                                        @foreach ($violations as $k => $v)
                                            @if ($counter <= $total/2)
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('violations[]', $k, '', ['data-msg' => 'Please select at least one violation.']) !!}
                                                    {{ $v }}
                                                </label>
                                            </div>
                                            @endif
                                            <?php $counter++; ?>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-6">
                                        @foreach ($violations as $k => $v)
                                            @if ($counter2 > $total/2)
                                                <div class="checkbox">
                                                    <label>
                                                        {!! Form::checkbox('violations[]', $k) !!}
                                                        {{ $v }}
                                                    </label>
                                                </div>
                                            @endif
                                            <?php $counter2++; ?>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div> <!-- ./col-sm-6 -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php $description = (empty($taxi))?"":$taxi->description ?>
                                {!! Form::label('description', 'Taxi Description',
                                    ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('description', $description,
                                        ['class' => 'form-control', 'rows' => 3,
                                        'placeholder' => 'ie. White colored Toyota Vios']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('incident_time', 'Incident Time',
                                    ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    <div class='input-group date' id='incident_time'>
                                        {!! Form::text('incident_time', '',
                                            ['class' => 'form-control',
                                            'placeholder' => 'ie. 4:30 PM']) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('incident_location', 'Incident Location',
                                    ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('incident_location', '',
                                        ['class' => 'form-control',
                                        'placeholder' => 'ie. San Isidro, Makati']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('notes', 'Complaint Notes',
                                    ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('notes', '',
                                        ['class' => 'form-control', 'rows' => 3,
                                        'placeholder' =>
                                        'Explain other compaints not included on violations list.']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('drivers_name', 'Name of Driver',
                                    ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('drivers_name', '',
                                        ['class' => 'form-control',
                                        'placeholder' => 'ie. Eren Yeager']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('taxi_pictures', 'Taxi Pictures',
                                    ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::file('taxi_pictures[]', array('multiple'),
                                        ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            @if (!Auth::user())
                                <div class="register">
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email Address',
                                            ['class' => 'col-sm-3 control-label req']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('email', '',
                                                ['class' => 'form-control',
                                                'required', 'email',
                                                'placeholder' => 'ie. gon.freaks@gmail.com']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('full_name', 'Full Name',
                                            ['class' => 'col-sm-3 control-label req']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('full_name', '',
                                                ['class' => 'form-control req', 'required',
                                                'placeholder' => 'ie. Squall Leonhart']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('contact_number', 'Contact Number',
                                            ['class' => 'col-sm-3 control-label req']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('contact_number', '',
                                                ['class' => 'form-control', 'required',
                                                'placeholder' => 'ie. 09171234567']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('reg_password', 'Password',
                                            ['class' => 'col-sm-3 control-label req']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('reg_password',
                                                ['class' => 'form-control', 'required',
                                                'placeholder' => 'ie. secretpassword']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('reg_password_confirmation',
                                            'Confirm Password', ['class' =>
                                                'col-sm-3 control-label req']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('reg_password_confirmation',
                                                ['class' => 'form-control', 'required',
                                                'placeholder' => 'ie. secretpassword']) !!}
                                        </div>
                                    </div>
                                </div> <!-- ./register -->
                            @endif
                        </div> <!-- ./col-sm-6 -->

                        <div class="clearfix">&nbsp;</div>

                    </div> <!-- .report-con -->

                </div> <!-- ./modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Report this Taxi', ['class' => 'btn btn-primary']) !!}
                </div> <!-- ./modal-footer -->

            {!! Form::close() !!}

        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- ./modal -->
<!-- End Report Modal -->
