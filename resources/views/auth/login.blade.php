@extends('layouts.public')

@section('page_styles')
    @parent
    {!! Html::style('css/auth.css', array('media'=>'screen')) !!}
@stop

@section('page_scripts')
    @parent
    <script type="text/javascript">
        $('.nav-tabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show');
        })
    </script>
@stop

@section('content')
<div class="container">

  <div class="row" id="pwd-container">

    <div class="col-md-3"></div>

      <div class="col-md-6">
        <section class="login-form">

          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('message'))
            <div class="alert alert-danger">
              {{ session('message') }}
            </div>
          @endif

          <form role="login" method="POST" action="{{ url('/auth/login') }}">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#login-regular" aria-controls="login-regular"
                    role="tab" data-toggle="tab">Login</a></li>
                <li role="presentation"><a href="#login-facebook"
                    aria-controls="login-facebook" role="tab"
                    data-toggle="tab">Login using your Facebook</a></li>
            </ul> <!-- /.nav-tabs -->

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="login-regular">

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <h3 style="text-align:left;">Login :: {!! link_to(config('app.url'),
                    config('app.taxi_complaint_app_name')) !!}</h3>

                  <input type="email" name="email" placeholder="Email" required
                    class="form-control input-lg" value="{{ old('email') }}" />

                  <input type="password" id="password" class="form-control input-lg"
                    name="password" placeholder="Password" required="" />

                  <button type="submit" class="btn btn-lg btn-primary btn-block">
                    Sign In</button>

                  <div>
                    <a href="/auth/register">Create Account</a> or
                      <a href="/password/email">Reset Password</a>
                  </div>

                </div> <!-- /#login-regular -->
                <div role="tabpanel" class="tab-pane fade" id="login-facebook">
                    <div class="row">
                        <p align="center">
                            <br><br>
                            <a href="/auth/facebook"
                                alt="Login using your Facebook Account"
                                title="Login using your Facebook Account">
                                <img src="http://res.cloudinary.com/kurapikats/image/upload/v1447928006/fb-login-btn_uvipzd.png"
                                    width="202" height="46">
                            </a>
                        </p>
                    </div>
                </div> <!-- /#login-facebook -->
            </div> <!-- /.tab-panes -->

          </form>

          <div class="form-links">
            {!! link_to(config('app.url'), config('app.taxi_complaint_app_name') . ' &copy; 2015') !!}
          </div>
        </section>
      </div>

      <div class="col-md-3"></div>

  </div>
</div>
@endsection
