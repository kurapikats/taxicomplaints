@section('page_scripts')
    @parent
    {!! Html::script('components/jquery-colorbox/jquery.colorbox-min.js') !!}

    <script type="text/javascript">
    var taxiModal = (function () {
        var taxi = {};

        taxi.show = function(taxi_id) {

            $.get('/api/show/' + taxi_id).done(function(data) {

                $('#tic_description').text('');
                $('#tic_taxi_pictures').text('');
                $('#tic_taxi_complaints').html('');
                $('#tic_taxi_violations').html('');

                // taxi details
                var taxi_data = data.data;
                $('#tic_plate_number').text(taxi_data.taxi.plate_number);
                $('#tic_name').text(taxi_data.taxi.name);

                var formatted_description = 'N/A';
                if (taxi_data.taxi.description != '') {
                    formatted_description = taxi_data.taxi.description;
                }
                $('#tic_description').text(formatted_description);

                // populate taxi pictures
                if (taxi_data.taxi_pictures.length > 0) {
                    $(taxi_data.taxi_pictures).each(function(e) {
                        var gallery = 'taxi-gallery';
                        var a_link = document.createElement('a');
                        a_link.setAttribute('href', this.path);
                        a_link.setAttribute('rel', 'gallery');
                        a_link.setAttribute('target', '_blank');
                        a_link.setAttribute('onClick', 'taxiModal.cbox("' + gallery + '")');
                        a_link.className = gallery;

                        var img_elm = document.createElement('img');
                        img_elm.setAttribute('src', this.path);
                        img_elm.setAttribute('width', '100');
                        $(img_elm).css({
                            border: '1px solid #000',
                            margin: '2px'
                        });

                        a_link.appendChild(img_elm);
                        $('#tic_taxi_pictures').append(a_link);
                    });
                } else {
                    $('#tic_taxi_pictures').text('N/A');
                }

                // begin taxi complaints table
                var tbl = document.createElement('table');
                tbl.className = 'table table-bordered table-striped table-hover table-condensed col-sm-12';
                var tbdy = document.createElement('tbody');

                var theadr = document.createElement('tr');
                theadr.setAttribute('align', 'center');
                var theadd = $(
                    '<td class="col-sm-1">Ref #</td>' +
                    '<td class="col-sm-2">Incident Date</td>' +
                    '<td class="col-sm-2">Incident Time</td>' +
                    '<td class="col-sm-2">Driver\'s Name</td>' +
                    '<td class="col-sm-2">Incident Location</td>' +
                    '<td class="col-sm-3">Notes</td>'
                );
                $(theadr).append(theadd);
                $(tbdy).append(theadr);

                $(taxi_data.taxi_complaints).each(function(e) {

                    var taxi_complaint_id = this.id;

                    var incident_date = new Date(this.incident_date);
                    var formatted_date = 'N/A';
                    if (incident_date != 'Invalid Date') {
                        var month = incident_date.getMonth() + 1;
                        formatted_date = month + '/' +
                            incident_date.getDate() + '/' +
                            incident_date.getFullYear();
                    }

                    var incident_time = this.incident_time;
                    var formatted_time = 'N/A';
                    if (incident_time != null) {
                        // convert millitary to standard time format
                        var hour   = incident_time.substring(0, 2);
                        var mins   = incident_time.substring(3, 5);
                        var ampm   = 'AM';
                        var twelve = 12;

                        if (hour == 00) {
                            hour = twelve;
                        }

                        if (hour > twelve) {
                            ampm = 'PM';
                            hour -= twelve;
                        }

                        formatted_time = hour + ":" + mins + " " + ampm;
                    }

                    var formatted_drivers_name = 'N/A';
                    if (this.drivers_name != '') {
                        formatted_drivers_name = this.drivers_name;
                    }

                    var formatted_incident_location = 'N/A';
                    if (this.incident_location != '') {
                        formatted_incident_location = this.incident_location;
                    }

                    var formatted_notes = 'N/A';
                    if (this.notes != '') {
                        formatted_notes = this.notes;
                    }

                    var tr = document.createElement('tr');
                    var td = $(
                        '<td align="center">' + taxi_complaint_id + '</td>' +
                        '<td align="center">' + formatted_date + '</td>' +
                        '<td align="center">' + formatted_time + '</td>' +
                        '<td>' + formatted_drivers_name + '</td>' +
                        '<td>' + formatted_incident_location + '</td>' +
                        '<td>' + formatted_notes + '</td>'
                    );
                    $(tr).append(td);
                    tbdy.appendChild(tr);
                });
                tbl.appendChild(tbdy);
                $('#tic_taxi_complaints').append($(tbl));
                // end taxi complaints table

                // begin taxi violations table
                var uniq_violations = taxi_data.uniq_violations;
                var ul = document.createElement('ul');
                // iterate on a json object
                for (var key in uniq_violations) {
                  if (uniq_violations.hasOwnProperty(key)) {
                    var li = document.createElement('li');
                    var violation = document.createTextNode(uniq_violations[key]);
                    li.appendChild(violation);
                    ul.appendChild(li);
                  }
                }

                $('#tic_taxi_violations').append($(ul));
                // end taxi violations table

                $('.taxi-modal-lg').modal('show');
            });

        }; // end taxi.show()

        taxi.cbox = function(targetClass) {
            $('.' + targetClass).colorbox({
                rel: 'gallery',
                fixed: true,
                photo: true
            });
        }; // end taxi.cbox()

        return taxi;
    }());

    (function($) {
        // show taxi details on modal box
        $('.show-taxi-link').click(function(e) {
            e.preventDefault();
            var taxi_id = $(this).attr('data-id');
            taxiModal.show(taxi_id);
        });

        // clear modal data when on close
        $('.taxi-modal-lg').on('hidden.bs.modal', function(e) {
            $('#tic_description').text('N/A');
            $('#tic_taxi_pictures').text('N/A');
            $('#tic_taxi_complaints').html('');
            $('#tic_taxi_violations').html('');
        });

        $('.report-new-complaint').click(function(e) {
            $('#plate_number').val($('#tic_plate_number').text());
            $('#name').val($('#tic_name').text());

            $('.taxi-modal-lg').modal('hide');
            $('#report-modal').modal('show');
        });

        // auto load modal box if $object is not empty
        @if (!empty($taxi))
            taxiModal.show({{ $taxi->id }});
        @endif

    })(jQuery);
    </script>
@stop

<!-- Large modal -->
<div class="modal fade taxi-modal-lg" tabindex="-1" role="dialog" aria-labelledby="taxi-large-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <strong>Taxi ::
                    <span id="tic_plate_number" class="blue"></span> ::
                    <span id="tic_name" class="blue"></span>
                    </strong>
                </h4>
            </div> <!-- /.modal-header -->
            <div class="modal-body">
                <div id="taxi-details-con">
                    <strong>Taxi Description:</strong>
                        <div id="tic_description">N/A</div><br>
                    <strong>Taxi Pictures:</strong>
                        <div id="tic_taxi_pictures">N/A</div><br>
                    <strong>Taxi Complaints:</strong>
                        <div id="tic_taxi_complaints"></div><br>
                    <strong>Taxi Violations:</strong>
                        <div id="tic_taxi_violations"></div>
                </div> <!-- /#taxi-details -->
            </div> <!-- /.modal-body -->
            <div class="modal-footer">
                <button class="report-new-complaint btn btn-primary pull-right">
                    Create New Complaint for this Taxi</button>
            </div>
        </div>
    </div>
</div>
