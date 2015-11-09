{{-- Included Scripts --}}
{!! Html::script('components/jquery/dist/jquery.min.js') !!}
{!! Html::script('components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('components/jquery-validation/dist/jquery.validate.min.js') !!}

{{-- todo: remove this on production --}}
{!! Html::script('components/less/dist/less.min.js') !!}

@yield('page_scripts')
