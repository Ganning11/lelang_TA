<body>
    <div id="all">
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">New Account / Sign In</h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active">New Account / Sign In</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-6">
              <div class="box">
                <h2 class="text-uppercase">Buat Akun</h2>
                <p class="lead">Masukan Data Diri</p>
                <hr>
                <?php if($this->session->flashdata('success')){ ?>
                  <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><center><?php echo $this->session->flashdata('success'); ?></center></p>
                  </div>
                <?php }elseif($this->session->flashdata('gagal')){?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><center><?php echo $this->session->flashdata('gagal'); ?></center></p>
                  </div>
                <?php } ?>
                <form action="<?= base_url('home/daftar_user') ?>" method="post">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input id="email" name="first_name" type="text" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input id="email" name="last_name" type="text" class="form-control" required="">
                  </div>
                  <div class="form-group">
                        <label for="street">Jenis Kelamin</label>
                        <select class="form-control" required="" name="gender">
                          <option value="">-- pilih kelamin --</option>
                          <option value="laki-laki"> Laki - Laki</option>
                          <option value="perempuan"> Perempuan</option>
                        </select>
                      </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label for="re_password">Konfirmasi Password</label>
                    <input id="password" name="re_password" type="password" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label for="re_password">Alamat</label>
                    <input id="password" name="alamat" type="text" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label for="re_password">No Handphone</label>
                    <input id="password" name="no_hp" type="text" class="form-control" required="">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Daftar</button><br> OR <br>
                    <a href="<?= base_url('home/register') ?>">
                      Sudah Punya Akun
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>