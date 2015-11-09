@section('page_scripts')
@stop

<!-- Begin Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <div class="login-con">
                    {!! Form::open(['url' => '/auth/login',
                        'id' => 'login-form-modal']) !!}
                        {!! csrf_field() !!}

                        <div class="form-group">
                            {!! Form::label('email',
                                'Email Address *') !!}
                            {!! Form::text('email', old('email'),
                                ['class' => 'form-control',
                                    'required', 'email']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password',
                                'Password *') !!}
                            {!! Form::password('password',
                                ['class' => 'form-control',
                                    'required']) !!}
                        </div>

                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('remember',
                                    old('remember')) !!} Remember Me
                            </label>
                        </div>

                        {!! Form::submit('Login', ['class' =>
                            'btn btn-primary col-sm-12']) !!}

                        <div>
                            <p class="login-modal-links">
                            <a href="/auth/register">Create Account</a> or
                            <a href="/password/email">Reset Password</a></p>
                        </div>
                    {!! Form::close() !!}
                </div> <!-- ./login-con -->
            </div> <!-- ./modal-body -->
        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- ./modal -->
<!-- End Login Modal -->
