@extends('layouts.public')

@section('page_styles')
    {!! Html::style('css/styles.less', array('rel' => 'stylesheet/less')) !!}

    {{-- todo: remove this on production --}}
    {!! Html::style('css/auth.css', array('media'=>'screen')) !!}
@stop

@section('page_scripts')

{!! Html::script('components/jquery-validation/dist/jquery.validate.min.js') !!}

{{-- todo: remove this on production --}}
{!! Html::script('components/less/dist/less.min.js') !!}

<script type="text/javascript">
$(function () {
    // validation for register form
    $("#register-form").validate({
        rules: {
            'name': 'required',
            'email': 'required',
            'email': 'email',
            'password': 'required',
            'password_confirmation': {
                equalTo: "#password"
            }
        },
        messages: {
            'password_confirmation': {
                equalTo: 'Password does not match the confirm password.'
            }
        }
    });
});
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

          <form id="register-form" role="login" method="POST"
            action="{{ url('/auth/register') }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <h3>Register :: {!! link_to(config('app.url'), config('app.taxi_complaint_app_name')) !!}</h3>

            <input type="text" name="name" placeholder="Full Name" required
              class="form-control input-lg" value="{{ old('name') }}">

            <input type="email" name="email" placeholder="Email" required
              class="form-control input-lg" value="{{ old('email') }}" />

            <input type="password" id="password" class="form-control input-lg"
              name="password" placeholder="Password" required />

            <input type="password" id="password_confirmation"
              class="form-control input-lg" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit" class="btn btn-lg btn-primary btn-block">
              Sign Up</button>

            <div>
              <a href="/auth/login">Login</a> or
                <a href="/password/email">Reset Password</a>
            </div>

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
