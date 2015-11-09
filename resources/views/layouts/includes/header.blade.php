<div id="header">
    <div class="logo">
        <a href="/">site logo here</a>
    </div>

    <div class="left">
        @if ($user = Auth::user())

        Welcome <strong>{!! link_to('profile', $title = $user->name) !!}</strong> |
            {!! link_to('auth/logout', $title = 'Logout') !!}
        @else
            {!! link_to('auth/login', $title = 'Login') !!} |
            {!! link_to('auth/register', $title = 'Register') !!}
        @endif
    </div>
</div>
