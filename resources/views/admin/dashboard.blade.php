@extends('layouts.backend')

@section('page_styles')
<style type="text/css">
#dashboard-con ul.pagination {
    margin: 0;
}
</style>
@stop

@section('page_scripts')
<script type="text/javascript">
(function() {

    //csrf token for ajax calls
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // toggle validate complaints
    $('.btn-validate').click(function(e) {
        var taxi_complaint_id = $(this).attr('data-id');
        var btn = $(this);
        var status = 0;

        btn.toggleClass('checked');

        if (btn.hasClass('checked')) {
            status = 1;
        }

        $.ajax({
            url: '/api/validate',
            method: 'PUT',
            data: { 'toggle' : status, 'taxi_complaint_id' : taxi_complaint_id },
            beforeSend: function() {
                btn.button('loading');
            },
            success: function(response) {
                btn.button('reset');
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(jqXhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });

    // send email complaints
    $('.btn-email').click(function(e) {
        var taxi_complaint_id = $(this).attr('data-id');
        var btn = $(this);
        var status = 1; // always send true status

        $.ajax({
            url: '/api/send-mail',
            method: 'PUT',
            data: { 'toggle' : status, 'taxi_complaint_id' : taxi_complaint_id },
            beforeSend: function() {
                btn.button('loading');
            },
            success: function(response) {
                btn.button('reset');
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(jqXhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });
})();
</script>
@parent

<script>
$(function () {
  $('[data-toggle="popover"]').popover({html: true});
})
</script>
{!! Html::script('components/bootstrap/js/tooltip.js') !!}
@stop

@section('content')
    <div id="dashboard-con">
        <h1 class="page-header">Dashboard</h1>

        <div class="col-sm-6"> <!-- begin unvalidated complaints -->
            <h4><strong>Unvalidated Taxi Complaints</strong></h4>
            <table class="table table-bordered table-condensed table-striped table-hover">
                <thead>
                    <tr align="center">
                        <th>CRef ID #</th>
                        <th>Plate Number</th>
                        <th>Reported By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taxi_complaints['unvalidated'] as $tc_unvalidated)
                        <tr>
                            <td>{{ $tc_unvalidated->id }}
                            </td>
                            <td>{!! link_to('/' . $tc_unvalidated->taxi_id,
                                $tc_unvalidated->taxi()->plate_number) !!}
                            </td>
                            <td>{{ $tc_unvalidated->user()->name }}</td>
                            <td align="center">
                                <button type="button" class="btn btn-sm btn-default"
                                data-toggle="popover" title="{{
                                $tc_unvalidated->taxi()->plate_number . " :: " .
                                $tc_unvalidated->taxi()->name }}" data-trigger="focus"
                                data-placement="left"
                                data-content="
                                    When: {{ date('m/d/y', strtotime($tc_unvalidated->incident_date))}}<br>
                                    {{-- todo: remove this if on production, test data is incomplete --}}
                                    @if (isset($tc_unvalidated->violations()[0]))
                                        What: {{ $tc_unvalidated->violations()[0]->name }}
                                    @endif
                                ">
                                View</button>
                                <button class="btn btn-sm btn-default btn-validate"
                                    data-toggle="button" data-id="{{ $tc_unvalidated->id }}"
                                    data-loading-text="Updating...">Validate</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                {!! $taxi_complaints['unvalidated']->render() !!}
            </div>
        </div> <!-- end unvalidated complaints -->

        <div class="col-sm-6"> <!-- begin validated complaints -->
            <h4><strong>Validated Taxi Complaints</strong></h4>
            <table class="table table-bordered table-condensed table-striped table-hover">
                <thead>
                    <tr align="center">
                        <th>CRef ID #</th>
                        <th>Plate Number</th>
                        <th>Reported By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taxi_complaints['validated'] as $tc_validated)
                        <tr>
                            <td>{{ $tc_validated->id }}
                            </td>
                            <td>{!! link_to('/' . $tc_validated->taxi_id,
                                $tc_validated->taxi()->plate_number) !!}
                            </td>
                            <td>{{ $tc_validated->user()->name }}</td>
                            <td align="left">
                                <button type="button" class="btn btn-sm btn-default"
                                data-toggle="popover" title="{{
                                $tc_validated->taxi()->plate_number . " :: " .
                                $tc_validated->taxi()->name }}" data-trigger="focus"
                                data-placement="left"
                                data-content="
                                    When: {{ date('m/d/y', strtotime($tc_validated->incident_date))}}<br>
                                    {{-- todo: remove this if on production, test data is incomplete --}}
                                    @if (isset($tc_validated->violations()[0]))
                                        What: {{ $tc_validated->violations()[0]->name }}
                                    @endif
                                ">
                                View</button>
                                <button class="btn btn-sm btn-default btn-validate checked"
                                    data-toggle="button" data-id="{{ $tc_validated->id }}"
                                    data-loading-text="Updating...">Invalidate</button>
                                @if ($tc_validated->mail_sent)
                                    <?php $btn_text = 'Resend Email'; ?>
                                @else
                                    <?php $btn_text = 'Send Email'; ?>
                                @endif
                                <button class="btn btn-sm btn-default btn-email"
                                    data-toggle="button" data-id="{{ $tc_validated->id }}"
                                    data-loading-text="Updating...">{{ $btn_text }}</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                {!! $taxi_complaints['validated']->render() !!}
            </div>
        </div> <!-- end validated complaints -->

    </div> <!-- #dashboard-con -->
@stop

