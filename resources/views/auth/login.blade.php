@extends('layouts.public')

@section('page_styles')
    {!! Html::style('css/auth.css', array('media'=>'screen')) !!}
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

          <form role="login" method="POST" action="{{ url('/auth/login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <h3>Login :: {!! link_to(config('app.url'), config('app.taxi_complaint_app_name')) !!}</h3>
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
