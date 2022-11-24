<?php
  $id       = $this->uri->segment(3);
  $sql_user = "SELECT * FROM abe_pelelang WHERE id_user = '$id'";
  $pelelang   = $this->db->query($sql_user)->row_array();
?>

      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">Profile Pelelang</h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="index.html">Profile</a></li>
                <li class="breadcrumb-item active">Pelelang</li>
              </ul>
            </div>
          </div>
        </div>
      </div> 
      <div id="content">
        <div class="container">
          <div class="row bar">
            <div id="customer-account" class="col-lg-9 clearfix">
              <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
              <div class="bo3">
                <div class="heading">
                  <h3 class="text-uppercase">Pelelang details</h3>
                </div>
                <?php if($this->session->flashdata('sukses')){ ?>
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><center><?php echo $this->session->flashdata('sukses'); ?></center></p>
                  </div>
                <?php }elseif($this->session->flashdata('gagal')){?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><center><?php echo $this->session->flashdata('gagal'); ?></center></p>
                  </div>
                <?php } ?>
                <form action="<?= base_url('profile/update') ?>" method="post">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="firstname">Nama Pelelang</label>
                        <input id="firstname" name="firstname" value="<?= $pelelang['nama_lengkap'] ?>" readonly="" type="text" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lastname">Email</label>
                        <input id="lastname" type="text" name="lastname" value="<?= $pelelang['email'] ?>" readonly="" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="company">Status</label>
                        <input id="company" type="text" name="email" value="<?= $pelelang['status'] ?>" readonly="" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="street">Tanggal Aktif</label>
                        <input id="company" type="text" name="email" value="<?= $pelelang['tgl_daftar'] ?>" readonly="" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 col-lg-12">
                      <div class="form-group">
                        <label for="city">Alamat</label>
                        <textarea readonly="" class="form-control" name="alamat"><?= $pelelang['alamat'] ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone">Telephone</label>
                        <input name="telephone" readonly="" value="<?= $pelelang['telpon'] ?>" required="" type="text" class="form-control">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-lg-3 mt-4 mt-lg-0">
              <!-- CUSTOMER MENU -->
              <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                  <h3 class="h4 panel-title">Pelelang section</h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-pills flex-column text-sm">
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang/').$id ?>" class="nav-link active"><i class="fa fa-user"></i> Profile</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang_produk/').$id ?>" class="nav-link"><i class="fa fa-list"></i> Semua Produk</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang_produk_laku/').$id ?>" class="nav-link"><i class="fa fa-list"></i> Produk Terjual</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>