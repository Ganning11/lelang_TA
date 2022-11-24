<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E Auction - Lelang Online</title>
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
    <link rel="stylesheet" href="<?= base_url('assets/front_end/') ?>css/style.default.css" id="theme-stylesheet">
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
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
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
              <p>Contact us on 0812 19000 806 or agus.ladur@gmail.com.</p>
            </div>
          </div>
        </div>
      </div>
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">My Orders</h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="#">Profile</a></li>
                <li class="breadcrumb-item active">My Orders</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar mb-0">
            <div id="customer-orders" class="col-md-9">
              <p class="text-muted lead">If you have any questions, please feel free to <a href="#">contact us</a>, our customer service center is working for you 24/7.</p>
              <div class="box">
                <?php
                  $id       = $this->session->userdata('id');
                  $produk = $this->uri->segment(4);
                  $sql1 = "SELECT * FROM abe_invoice WHERE id_produk = '$produk' ";
                  $sql2 = "SELECT ai.*, ap.*, afp.* FROM abe_invoice as ai, abe_produk as ap, abe_foto_produk as afp WHERE ai.id_produk = '$produk' AND ai.id_produk = ap.id_produk AND afp.id_produk = ap.id_produk ";
                  $invoice = $this->db->query($sql1)->row_array();
                  $produk = $this->db->query($sql2)->row_array();
                  $sql_payment = "SELECT * FROM abe_invoice WHERE id_user = '$id' AND status = 'belum bayar'";
                  $payment = $this->db->query($sql_payment)->num_rows();
                  $nama   = $produk['nama_produk'];
                  $harga  = $invoice['harga_produk'];
                  $kode   = $invoice['kode_unik'];
                  $deposit   = $invoice['deposit'];
                  $total  = $harga;
                  $ppn    = ($harga * 10)/100 ;
                  $all_total = $harga + $kode + $ppn - $deposit;
                ?>
                <div class="table-responsive">
                  <a href="<?= base_url('back_end/transaksi/invoice/') ?>" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                  <button class="btn btn-success"><i class="fa fa-list"></i> <?= $invoice['no_invoice'] ?></button>
                  <table class="table">
                    <thead>
                      <tr>
                        <th colspan="2" class="border-top-0">Product</th>
                        <th class="border-top-0">Quantity</th>
                        <th class="border-top-0">Unit price</th>
                        <th class="border-top-0">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><a href="#"><img src="<?= base_url('assets/foto_produk/').$produk['file_foto']  ?>" alt="White Blouse Armani" class="img-fluid"></a></td>
                        <td><a href="#"><?= $produk['nama_produk'] ?></a></td>
                        <td>1</td>
                        <td>Rp. <?= number_format($harga,2,',','.') ?></td>
                        <td>Rp. <?= number_format($total,2,',','.') ?></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4" class="text-right">Order subtotal</th>
                        <th style="text-align: right">Rp. <?= number_format($harga,2,',','.') ?></th>
                      </tr>
                      <tr>
                        <th colspan="4" class="text-right">Kode Unik</th>
                        <th style="text-align: right"><?= $invoice['kode_unik'] ?></th>
                      </tr>
                      <tr>
                        <th colspan="4" class="text-right">PPN 10%</th>
                        <th style="text-align: right">Rp. <?= number_format($ppn,2,',','.') ?></th>
                      </tr>
                      <tr>
                        <th colspan="4" class="text-right">Deposit</th>
                        <th style="text-align: right">Rp. <?= number_format($deposit,2,',','.') ?></th>
                      </tr>
                      <tr>
                        <th colspan="4" class="text-right">Total Transfer</th>
                        <th style="text-align: right">Rp. <?= number_format($all_total,2,',','.') ?></th>
                      </tr>
                      <tr>
                        <th colspan="5" class="text-right">
                          <?php
                            $status = $invoice['status'];
                            if($status == 'lunas'){
                          ?>
                            <button class="btn btn-success"><i class="fa fa-check"></i> Lunas</button>
                          <?php
                            }else{
                          ?>
                            <button class="btn btn-warning"><i class="fa fa-check"></i> Belum Dibayar</button>
                          <?php
                            }
                          ?>
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="row addresses">
                  <div class="col-md-6 text-right">
                    <h3 class="text-uppercase">Invoice address</h3>
                    <p><?= $this->session->userdata('first_name') ?> <?= $this->session->userdata('last_name') ?><br>             13/25 New Avenue<br>              New Heaven<br>              45Y 73J<br>             DKI Jakarta<br>             Indonesia</p>
                  </div>
                  <div class="col-md-6 text-right">
                    <h3 class="text-uppercase">Shipping address</h3>
                    <p><?= $this->session->userdata('first_name') ?> <?= $this->session->userdata('last_name') ?><br>             13/25 New Avenue<br>              New Heaven<br>              45Y 73J<br>             DKI Jakarta<br>             Indonesia</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- FOOTER -->
      <footer class="main-footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-3">
              <h4 class="h6">About Us</h4>
              <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
              <hr>
            </div>
            <div class="col-lg-3">
              <h4 class="h6">Call Me</h4>
                <p class="text-uppercase">
                  <strong>
                    <i class="fa fa-phone"></i> 0812 19000 806<br>
                    <i class="fa fa-envelope-o"></i> agus.ladur@gmail.com<br>
                    <i class="fa fa-shopping-basket"></i> E auction
                  </strong>
                </p>
              <hr class="d-block d-lg-none">
            </div>
            <div class="col-lg-3">
              <h4 class="h6">Contact</h4>
              <p class="text-uppercase"><strong>E Auction.</strong><br>Bahari Gg1 <br>No.80 A9 <br>Tanjung Priuk <br>Jakarta Utara <br><strong>Indonesia</strong></p><a href="#" class="btn btn-template-main">Go to contact page</a>
              <hr class="d-block d-lg-none">
            </div>
            <div class="col-lg-3">
              <ul class="list-inline photo-stream">
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/l.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/e.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/l2.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/a.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/n.jpg" alt="..." class="img-fluid"></a></li>
                <li class="list-inline-item"><a href="#"><img src="<?= base_url('assets/front_end/') ?>img/g.jpg" alt="..." class="img-fluid"></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="copyrights">
          <div class="container">
            <div class="row">
              <div class="col-lg-4 text-center-md">
                <p>&copy; 2018. E - Auction / agus bahrudin</p>
              </div>
              <div class="col-lg-8 text-right text-center-md">
                <p>Template design by <a href="https://bootstrapious.com/free-templates">Bootstrapious Templates </a></p>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
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