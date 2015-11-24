{{-- Included Scripts --}}
{!! Html::script('components/jquery/dist/jquery.min.js') !!}
{!! Html::script('components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('components/jquery-validation/dist/jquery.validate.min.js') !!}

@yield('page_scripts')

@if (env('APP_ENV') === 'local')
    {!! Html::script('components/less/dist/less.min.js') !!}
@else
    {{-- begin google analytics --}}
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-70277228-1', 'auto');
      ga('send', 'pageview');
    </script>
    {{-- end google analytics --}}
@endif
