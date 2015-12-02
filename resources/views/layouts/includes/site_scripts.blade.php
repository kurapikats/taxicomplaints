{{-- Included Scripts --}}
{!! Html::script('components/jquery/dist/jquery.min.js') !!}
{!! Html::script('components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('components/jquery-validation/dist/jquery.validate.min.js') !!}

@yield('page_scripts')

@if (env('APP_ENV') === 'local')
    {!! Html::script('components/less/dist/less.min.js') !!}
@else
    @include('layouts.includes.google_analytics')
@endif
