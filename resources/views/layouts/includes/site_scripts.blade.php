{{-- Included Scripts --}}
{!! Html::script('components/jquery/dist/jquery.min.js') !!}
{!! Html::script('components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('components/jquery-validation/dist/jquery.validate.min.js') !!}

@yield('page_scripts')

@if (env('APP_ENV') === 'development')
    {!! Html::script('components/less/dist/less.min.js') !!}

    {!! Html::script('components/react/react.development.js') !!}
    {!! Html::script('components/react/react-dom.development.js') !!}
    {!! Html::script('http://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js') !!}
    {!! Html::script('js/src/main.js', array('type' => 'text/babel')) !!}
@else
    {!! Html::script('components/react/react.production.min.js') !!}
    {!! Html::script('components/react/react-dom.production.min.js') !!}
    {!! Html::script('js/build/main.min.js') !!}

    @include('layouts.includes.google_analytics')
@endif
