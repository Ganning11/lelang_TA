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
                <div class="box mt-0 mb-lg-0">
                  <h4>Data Semua Produk</h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Foto</th>
                          <th>Kategori</th>
                          <th>Nama Produk</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $id         = $this->uri->segment(3);
                          $sql_produk = "SELECT * FROM abe_produk WHERE id_pelelang = '$id' AND status = 'lelang' ";
                          $produk     = $this->db->query($sql_produk)->result();
                          $no = 1;
                          foreach ($produk as $row) {
                            $id_kategori  = $row->id_kategori;
                            $produk       = $row->id_produk;
                            $kategori     = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                            $a    = $kategori['nama_kategori'];
                            $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                            $b    = $foto['file_foto'];
                        ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><img src='<?= base_url('assets/foto_produk/').$b ?>' height='100'></td>
                          <td><?= $a ?></td>
                          <td><a href="<?= base_url('home/produk/').$a.'/'.$row->id_produk ?>"> <?= $row->nama_produk ?></a></td>
                          <td><span class="badge badge-info"><?= $row->status ?></span></td>
                        </tr>
                        <?php
                            $no ++;
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang/').$id ?>" class="nav-link"><i class="fa fa-user"></i> Profile</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang_produk/').$id ?>" class="nav-link active"><i class="fa fa-list"></i> Semua Produk</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang_produk_laku/').$id ?>" class="nav-link"><i class="fa fa-list"></i> Produk Terjual</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>