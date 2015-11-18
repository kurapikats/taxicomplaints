<!-- Footer -->
<footer>
    <div id="footer" class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4><strong>TaxiComplaints</strong>
                </h4>
                <p><i class="fa fa-globe fa-fw"></i>Philippines</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-phone fa-fw"></i> 0908-2150659</li>
                    <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:{{ config('app.taxi_complaint_admin_email') }}">{{ config('app.taxi_complaint_admin_email') }}</a>
                    </li>
                </ul>
                <br>
                <ul class="list-inline">
                    <li>
                        <a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-dribbble fa-fw fa-3x"></i></a>
                    </li>
                </ul>
                <hr class="small">
                <p class="text-muted">Copyright &copy; TaxiComplaints {{ date('Y') }}
                  <a href="/#top" class="go-top">
                    <i class="fa fa-angle-up"></i>
                  </a>
                </p>
            </div>
        </div>
    </div>
</footer>
