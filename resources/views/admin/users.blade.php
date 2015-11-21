@extends('layouts.backend')

@section('page_styles')
@parent
@stop

@section('page_scripts')
@parent
{!! Html::script('components/bootstrap/js/tooltip.js') !!}
{!! Html::script('components/bootstrap-confirmation2/bootstrap-confirmation.min.js') !!}
<script type="text/javascript">
(function() {

    //csrf token for ajax calls
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var confirm_options = {
        singleton : 'true',
        popout : 'true',
        onConfirm: function() {
            var user_id = $(this).attr('data-id');
            var form = $('#form-user-delete-' + user_id);
            form.submit();
        }
    };
    $('[data-toggle="confirmation"]').confirmation(confirm_options);
})();
</script>

@stop

@section('content')
    <div id="users-con">
        <h1 class="page-header">Users</h1>

        @if (session('message'))
            <div class="alert alert-info">
                <span class="glyphicon glyphicon-ok"
                    aria-hidden="true"></span>
                {{ session('message') }}
            </div> <!-- /.alert-info -->
        @endif

        <div class="col-sm-12"> <!-- begin user list -->
            <h4><strong>Users</strong></h4>
            <table class="table table-bordered table-condensed table-striped table-hover">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Date Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td align="center">{{ $user->id }}</td>
                            <td align="center"><img src="{{ $user->photo ?: 'http://res.cloudinary.com/kurapikats/image/upload/v1448081834/default-user-picture_azttz8.jpg' }}"
                                width="100" height="100" class="img-thumbnail"></td>
                            <td>{{ $user->name }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td>{{ $user->contact_number }}</td>
                            <td>{{ $user->role()->name }}</td>
                            <td>{{ date('m/d/Y h:i a', strtotime($user->created_at)) }}</td>
                            <td align="center">
                                {!! Form::open(['url' => '/admin/delete/user', 'method' => 'delete',
                                    'id' => 'form-user-delete-' . $user->id]) !!}
                                    {!! csrf_field() !!}
                                    {!! Form::hidden('user_id', $user->id) !!}
                                    {!! Form::button('Delete', ['class' => 'btn btn-danger',
                                        'data-id' => $user->id, 'data-toggle' => 'confirmation']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                {!! $users->render() !!}
            </div>
        </div> <!-- end user list -->

    </div> <!-- #users-con -->

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Confirm User Deletion</h4>
                </div>
                <div class="modal-body" id="confirm-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
@stop

