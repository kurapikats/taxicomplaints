<!-- Navigation -->
<a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
        @if ($user = Auth::user())
            <li class="sidebar-brand">
                <a href="/profile"  onclick = $("#menu-close").click();>{{ $user->name }}</a>
            </li>
        @else
            <li>
                <a href="#login" class="login-modal-open" onclick="$('#menu-close').click();">Login</a>
            </li>
            <li>
                <a href="/auth/register">Register</a>
            </li>
        @endif
        <li>
            <a href="/#top" onclick = $("#menu-close").click();>Home</a>
        </li>
        <li>
            <a href="#about" onclick = $("#menu-close").click();>About</a>
        </li>
        <li>
            <a href="#opensource" onclick = $("#menu-close").click();>Open Source</a>
        </li>
        <li>
            <a href="#footer" onclick = $("#menu-close").click();>Contact</a>
        </li>
        @if ($user = Auth::user())
          <li>
              <a href="/auth/logout" onclick = $("#menu-close").click();>Logout</a>
          </li>
        @endif
    </ul>
</nav>
