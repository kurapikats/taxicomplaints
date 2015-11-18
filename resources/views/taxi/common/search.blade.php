@section('page_scripts')
@parent
<script type="text/javascript">

// this closes the existing modal box, when the user clicks a taxi
var searchTaxi = (function() {
    var search = {};

    search.show = function(taxi_id) {
        $('.search-result-modal-sm').modal('hide');
        taxiModal.show(taxi_id);
    };

    search.report = function() {
        $('.search-result-modal-sm').modal('hide');
        $('#report-modal').modal('show');
    };

    return search;
}());

(function() {

    $('#search-form').submit(function(e) {
        e.preventDefault();
        searchSubmit();
    });

    var searchSubmit = function() {
        var keyword = $('#keyword').val();
        if (keyword != '') {
            $.get('/api/search/' + keyword).done(function(data) {
                var search_result = data.data;

                // if search result return only 1 matched result.
                // open the show modal box
                if (typeof (search_result) !== 'undefined' &&
                    search_result.length === 1) {
                    taxiModal.show(search_result[0].id);
                } else if (typeof(search_result) == 'undefined') {

                    $('#sr_result').html('<p>Did not find any matching Taxi.</p>'
                        + '<p><a href="#" onclick="searchTaxi.report()">Report a Taxi?</a></p>');

                    $('#sr_keyword').text(keyword);
                    $('.search-result-modal-sm').modal('show');
                } else {
                    // it returned many results
                    console.log(search_result);

                    var ol = document.createElement('ol');
                    $(search_result).each(function(e) {

                        var li = document.createElement('li');
                        var a_link = document.createElement('a');
                        a_link.setAttribute('href', '#');
                        a_link.setAttribute('onclick', 'searchTaxi.show(' + this.id + ')');
                        $(a_link).text(this.plate_number + ' - ' + this.name);
                        li.appendChild(a_link);
                        ol.appendChild(li);
                    });

                    $('#sr_result').html(ol);

                    // sr_result
                    // <a href="#" onclick="searchTaxi.show(38);">body</a>
                    $('#sr_keyword').text(keyword);
                    $('.search-result-modal-sm').modal('show');
                }

            });
        }
    };


    $('#btn-search').click(function(e) {
        searchSubmit();
    });

    // clear modal data when on close
    $('.search-result-modal-sm').on('hidden.bs.modal', function(e) {
        $('#sr_result').text('N/A');
    });

})();
</script>
@stop

{{-- begin search form --}}
<div class="col-sm-4"></div>
<div class="search-con col-sm-4">
    <form method="get" action="/search" id="search-form">
        <div class="input-group">
            <input type="text" class="form-control" id='keyword' name="keyword"
                placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="btn-search">
                    Go!</button>
            </span>
        </div><!-- /input-group -->
    </form> <!-- /#search-form -->
</div> <!-- /.search-con -->
<div class="col-sm-4"></div>
<br><br><br>
{{-- end search form --}}

{{-- begin search modal result --}}
<div class="modal fade search-result-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <strong>Search Result :: <span
                    <span id="sr_keyword" class="blue"></span>
                    </strong>
                </h4>
            </div> <!-- /.modal-header -->
            <div class="modal-body">
                <div id="sr_result">N/A</div>
            </div>
        </div>
    </div>
</div>
{{-- end search modal result --}}
