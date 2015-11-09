@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" aria-label="Close" data-dismiss='alert'>
            <span aria-hidden="true">&times;</span>
        </button>
        {!! Session::get('success') !!}
    </div>
@endif
@if (count($errors->all()) > 0)
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" aria-label="Close" data-dismiss='alert'>
            <span aria-hidden="true">&times;</span>
        </button>
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif
