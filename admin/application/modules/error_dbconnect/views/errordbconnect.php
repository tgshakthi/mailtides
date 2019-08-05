<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div class="col-md-12">
                <div class="col-middle">
                    <div class="text-center text-center">
                        <h1 class="error-number">403</h1>
                        <h2>Access denied</h2>
                        <p>Full authentication is required to access Admin panel.</p>
                        <div class="mid_center">
                          <?php
                            $url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].'/';;
                          ?>
                          <h3>
                            <a class="btn btn-warning" href="<?php echo $url; ?>">Go Back</a>
                          </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
