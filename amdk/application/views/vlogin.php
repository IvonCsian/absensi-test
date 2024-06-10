<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="Suha - Multipurpose Ecommerce Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags-->
    <!-- Title-->
    <title>AMDK Mobile</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap">
    <!-- Favicon-->
    <link rel="icon" href="img/icons/icon-72x72.png">
    <!-- Apple Touch Icon-->
    <link rel="apple-touch-icon" href="<?php echo base_url().'libraries/dist/img/icons/icon-96x96.png'?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url().'libraries/dist/img/icons/icon-152x152.png'?>">
    <link rel="apple-touch-icon" sizes="167x167" href="<?php echo base_url().'libraries/dist/img/icons/icon-167x167.png'?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url().'libraries/dist/img/icons/icon-180x180.png'?>">
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="<?php echo base_url().'libraries/dist/css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'libraries/dist/css/animate.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'libraries/dist/css/owl.carousel.min.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'libraries/dist/css/font-awesome.min.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'libraries/dist/css/default/lineicons.min.cs'?>s">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url().'libraries/dist/style.css'?>">
    <!-- Web App Manifest-->
    <link rel="manifest" href="<?php echo base_url().'libraries/dist/manifest.json'?>">
  </head>
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
      <!-- Background Shape-->
      <div class="background-shape"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img class="big-logo" src="<?php echo base_url().'libraries/dist/img/core-img/logo-white.png'?>" alt="">
            <!-- Register Form-->
            <div class="register-form mt-5 px-4">
              <form action="<?php echo site_url('Welcome/proses'); ?>" method="post">
			  	<?php
                if (validation_errors() || $this->session->flashdata('result_login')) {
                    ?>
                    <span class="badge bg-danger ms-1">
                        <?php echo $this->session->flashdata('result_login'); ?>
					</span>
                <?php } ?>
                <div class="form-group text-start mb-4"><span>Username</span>
                  <label for="username"><i class="lni lni-user"></i></label>
                  <input class="form-control" id="username" name="username" type="text" placeholder="username">
                </div>
                <div class="form-group text-start mb-4"><span>Password</span>
                  <label for="password"><i class="lni lni-lock"></i></label>
                  <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                </div>
                <button class="btn btn-success btn-lg w-100" type="submit">Log In</button>
              </form>
            </div>
            <!-- Login Meta-->
            <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="forget-password.html">Forgot Password?</a>
              <p class="mb-0">Didn't have an account?<a class="ms-1" href="register.html">Register Now</a></p>
            </div>
            <!-- View As Guest-->
            <div class="view-as-guest mt-3"><a class="btn" href="home.html">View as Guest</a></div>
          </div>
        </div>
      </div>
    </div>
    <!-- All JavaScript Files-->
    <script src="<?php echo base_url().'libraries/dist/js/bootstrap.bundle.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/waypoints.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.easing.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/owl.carousel.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.counterup.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.countdown.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/jquery.passwordstrength.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/dark-mode-switch.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/active.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/pwa.js'?>"></script>
  </body>
</html>