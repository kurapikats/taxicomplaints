<!DOCTYPE html>
<html lang="en-us">
  <head>
    @include('layouts.includes.head')
    @include('admin.includes.site_styles')
  </head>
  <body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('admin.includes.navbar-head')

            @include('admin.includes.topnavbar')

            @include('admin.includes.sidebar')
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('layouts.includes.site_scripts')
    @include('admin.includes.site_scripts')
  </body>
</html>
