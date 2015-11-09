<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="@yield('author')">
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">

    <title>@yield('title', config('app.taxi_complaint_page_title'))</title>

    <!-- Styles -->
    {!! Html::style('components/bootstrap/dist/css/bootstrap.css', array('media'=>'screen')) !!}
    {!! Html::style('components/font-awesome/css/font-awesome.css', array('media'=>'screen')) !!}

    @yield('page_styles')

</head>
<body>

    <!--main content start-->
    <section id="main-content" style="margin-top:100px;">
        @yield('content')
    </section>
    <!--main content end-->

    {!! Html::script('components/jquery/dist/jquery.min.js') !!}
    {!! Html::script('components/bootstrap/dist/js/bootstrap.min.js') !!}

    @yield('page_scripts')
</body>
</html>
