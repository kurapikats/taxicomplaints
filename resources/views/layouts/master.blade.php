@section('page_styles')
    {!! Html::style('css/stylish-portfolio.css') !!}
@stop

@section('page_scripts')
    @parent

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    </script>

    <script type="text/javascript">
    // login modal scripts
    $(function () {
        // trigger open modal login
        $('.login-modal-open').click(function() {
            $('#login-modal').modal('show');
        });

        // validation for modal login form
        $("#login-form-modal").validate({
            rules: {
                'email': 'required',
                'email': 'email',
                'password': 'required'
            }
        });
    });
    </script>
@stop

<!DOCTYPE html>
<html lang="en-us">
  <head>
    @include('layouts.includes.head')
  </head>
  <body>

    @include('layouts.includes.navigation')

    <!-- Header -->
    <header id="top" class="header">
        @include('taxi.modal-taxi-details')
        <div class="text-vertical-center">
            <div class="row">
                @include('taxi.common.search')
            </div>
            <div class="row">
                <div class="col-sm-4">
                    @include('taxi.common.top-violators')
                </div>
                <div class="col-sm-4">
                    <h1>TaxiComplaints<sup class="trademark">
                        <i class="fa fa-trademark"></i></sup></h1>
                    <h3>Lets make them popular!</h3>
                    <br>
                    <!-- Button trigger modal -->
                    <button class="btn btn-dark btn-lg" id="btn-report-modal">
                        Report a Taxi</button>
                </div>
                <div class="col-sm-4">
                    @include('taxi.common.recently-added')
                </div>
            </div>
        </div>
        @include('taxi.report')
        @include('auth.modal-login')
    </header>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>TaxiComplaints is a FREE to use community driven public service.</h2>
                    <p class="lead">It aims to help fellow commuters report service violations to LTFRB automatically.</p>
                    <p>The system is built using Free and OpenSource softwares, anyone who's capable is encouraged to help and <a href="#footer">contribute</a>.</p>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    @include('layouts.includes.opensource')

    <!-- Call to Action -->
    <aside class="call-to-action bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3><i class="fa fa-android"></i> Mobile apps comming soon! <i class="fa fa-apple"></i></h3>
                </div>
            </div>
        </div>
    </aside>

    @include('layouts.includes.footer')

    <!-- begin here -->
    <!--main content start-->
    <section id="main-content">
        @yield('content')
    </section>
    <!--main content end-->

    <!-- js placed at the end of the document so the pages load faster -->
    @include('layouts.includes.site_scripts')

  </body>
</html>
