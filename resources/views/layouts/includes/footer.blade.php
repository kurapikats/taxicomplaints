<!-- Footer -->
<footer>
    <div id="footer" class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4><strong>TaxiComplaints</strong>
                </h4>
                <p><i class="fa fa-globe fa-fw"></i>Philippines</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-mobile"></i> +63 908 2150659</li>
                    <li><i class="fa fa-envelope-o fa-fw"></i>
                      <a href="mailto:{{ config('app.taxi_complaint_admin_email') }}">
                        {{ config('app.taxi_complaint_admin_email') }}</a>
                    </li>
                    <li><i class="fa fa-github"></i>
                      <a href="https://github.com/kurapikats/taxicomplaints"
                        target="_blank">Fork me on GitHub</a>
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
