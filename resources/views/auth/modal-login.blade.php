@section('page_scripts')
    @parent
    <script type="text/javascript">
        $('.nav-tabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show');
        })
    </script>
@stop

<!-- Begin Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ config('app.taxi_complaint_app_name') }}</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#login-regular" aria-controls="login-regular"
                        role="tab" data-toggle="tab">Login</a></li>
                    <li role="presentation"><a href="#login-facebook"
                        aria-controls="login-facebook" role="tab"
                        data-toggle="tab">Login using Facebook</a></li>
                </ul> <!-- /.nav-tabs -->

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="login-regular">
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
                    </div> <!-- /#login-regular -->
                    <div role="tabpanel" class="tab-pane fade" id="login-facebook">
                        <div class="row">
                            <div align="center">
                                <a href="/auth/facebook"
                                    alt="Login using your Facebook Account"
                                    title="Login using your Facebook Account">
                                    <img src="http://res.cloudinary.com/kurapikats/image/upload/v1447928006/fb-login-btn_uvipzd.png"
                                        width="202" height="46">
                                </a>
                            </div>
                        </div>
                    </div> <!-- /#login-facebook -->
                </div> <!-- /.tab-content -->
            </div> <!-- ./modal-body -->
        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- ./modal -->
<!-- End Login Modal -->
