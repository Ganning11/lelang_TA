<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sistem Lelang Barang</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="all,follow">
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>vendor/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome CSS-->
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>vendor/font-awesome/css/font-awesome.min.css">
	<!-- Google fonts - Roboto-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
	<!-- Bootstrap Select-->
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>vendor/bootstrap-select/css/bootstrap-select.min.css">
	<!-- owl carousel-->
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>vendor/owl.carousel/assets/owl.carousel.css">
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>vendor/owl.carousel/assets/owl.theme.default.css">
	<!-- theme stylesheet-->
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>css/style.blue.css" id="theme-stylesheet">
	<!-- Custom stylesheet - for your changes-->
	<link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>css/custom.css">
	<!-- Favicon and apple touch icons-->
	<link rel="shortcut icon" href="<?= base_url('assets/front_end/') ?>img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('assets/front_end/') ?>img/apple-touch-icon-152x152.png">
	<!-- Tweaks for older IEs-->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
			

<body>
	
	<div id="all">
		<!-- Top bar-->
		<div class="top-bar">
			<div class="container">
				<div class="row d-flex align-items-center">
					<div class="col-md-6 d-md-block d-none">
						<p>Ganaldi Gilang Eka P // 15523171</p>
					</div>
					<div class="col-md-6">
						<div class="d-flex justify-content-md-end justify-content-between">
							<ul class="list-inline contact-info d-block d-md-none">
								<li class="list-inline-item"><a href="#"><i class="fa fa-phone"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>
							<div class="login">
								<?php
								if ($this->session->userdata('loggedIn') == true) {
								?>
									<a href="<?= base_url('profile') ?>" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Akun Saya</span></a>
									<a href="<?= base_url('home/logout') ?>" class="signup-btn"><i class="fa fa-sign-out"></i><span class="d-none d-md-inline-block">Logout</span></a>
								<?php
								} else {
								?>
									<a href="<?= base_url('home/register') ?>" class="signup-btn"><i class="fa fa-users"></i><span class="d-none d-md-inline-block">Login User</span></a>
									<a href="<?= base_url('pelelang') ?>" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Login Admin</span></a>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<?php
		include "home/data_menu.php";
		echo $contents;
		?>
		<!-- FOOTER -->
		<footer class="main-footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
						<h4 class="h6">Tugas Akhir</h4>
						<p>Ganaldi Gilang Eka P<br>15523171<br>Informatika<br>Universitas Islam Indonesia</p>
						<hr>
					</div>
					<!--<div class="col-lg-3">
              <h4 class="h6">Contact</h4>
                <p class="text-uppercase">
                  <strong>
                    <i class="fa fa-phone"></i> 087780269553<br>
                    <i class="fa fa-envelope-o"></i> muhrizkyrivaldi@gmail.com<br>
                    <i class="fa fa-shopping-basket"></i> E auction
                  </strong>
                </p>
              <hr class="d-block d-lg-none">
            </div>-->
					<!--<div class="col-lg-3">
              <h4 class="h6">Address</h4>
              <p class="text-uppercase"><strong>E Auction.</strong><br>Bahari Gg1 <br>No.80 A9 <br>Tanjung Priuk <br>Jakarta Utara <br><strong>Indonesia</strong></p><a href="<?= base_url('home/kontak') ?>" class="btn btn-template-main">Go to contact page</a>
              <hr class="d-block d-lg-none">
            </div>-->
					<!--<div class="col-lg-3">
              <ul class="list-inline photo-stream">
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/l.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/e.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/l2.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/a.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/n.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/g.jpg" alt="..." class="img-fluid"></a></li>
              </ul>
            </div>-->
				</div>
			</div>
			<div class="copyrights">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 text-center-md">
							<p>&copy; 2022. Sistem Lelang Barang Berbasis Web / Ganaldi Gilang  </p>
						</div>
						<div class="col-lg-8 text-right text-center-md">
							
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<!-- Javascript files-->
	<script src="<?= base_url('assets/front_end/') ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/popper.js/umd/popper.min.js"> </script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/jquery.cookie/jquery.cookie.js"> </script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/waypoints/lib/jquery.waypoints.min.js"> </script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/jquery.counterup/jquery.counterup.min.js"> </script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/owl.carousel/owl.carousel.min.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>js/jquery.parallax-1.1.3.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>vendor/jquery.scrollto/jquery.scrollTo.min.js"></script>
	<script src="<?= base_url('assets/front_end/') ?>js/front.js"></script>
</body>

</html>
