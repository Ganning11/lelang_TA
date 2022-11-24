<?php
  $id       = $this->session->userdata('id');
  $sql_user = "SELECT * FROM users WHERE id = '$id'";
  $bidder   = $this->db->query($sql_user)->row_array();
  $kelamin  = $bidder['gender'];

  $sql_deposit = "SELECT * FROM abe_deposit WHERE id_user = '$id' AND status = 'oke'";
  $deposit     = $this->db->query($sql_deposit)->row_array();
  $jumlah = $deposit['jumlah'];
?>
      
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
              <p class="text-muted lead">Riwayat penawaran yang kamu berikan</p>
              <div class="box mt-0 mb-lg-0">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah Penawaran</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $id_user = $this->session->userdata['id'];
                        $sql_bidder = "SELECT * FROM abe_lelang_bidder WHERE id_bidder = '$id_user'";
                        $bidder = $this->db->query($sql_bidder)->result();
                        $bidder2 = $this->db->query($sql_bidder)->num_rows();
                        $sql_payment = "SELECT * FROM abe_invoice WHERE id_user = '$id_user' AND status = 'belum bayar'";
                        $payment = $this->db->query($sql_payment)->num_rows();
                        $no = 1;
                        if($bidder2 == ''){
                          ?>
                        <tr><td colspan="5"><center>belum ada penawaran masuk / tidak ada data</center> </td></tr>
                        <?php
                          }else{
                        foreach ($bidder as $row) {
                          $produk = $row->id_barang;
                          //$kategori = ;
                          $user_bidder = "SELECT * FROM abe_produk WHERE id_produk = '$produk'";
                          $sql_produk = $this->db->query($user_bidder)->row_array();
                          $sql_kategori = $this->db->query("SELECT ak.*, ap.* FROM abe_kategori as ak, abe_produk as ap WHERE ap.id_produk = '$produk' AND ap.id_kategori = ak.id_kategori")->row_array();
                      ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= date('d M Y / H:i:s', strtotime($row->tanggal)) ?></td>
                        <td><a href="<?= base_url('home/produk/').$sql_kategori['url_kategori'].'/'.$sql_produk['id_produk'] ?>"> <?= $sql_produk['nama_produk'] ?> </a></td>
                        <td>Rp. <?= number_format($row->harga_lelang,2,',','.') ?></td>
                        <td><span class="badge badge-info"><?= $row->status ?></span></td>
                      </tr>
                      <?php
                          $no ++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-3 mt-4 mt-md-0">
              <!-- CUSTOMER MENU -->
              <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                  <h3 class="h4 panel-title">Customer section</h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-pills flex-column text-sm">
                    <li class="nav-item"><a href="<?= base_url('profile') ?>" class="nav-link "><i class="fa fa-user"></i> My account</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/rekomendasi') ?>" class="nav-link"><i class="fa fa-list"></i> My Interest</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/orders') ?>" class="nav-link active"><i class="fa fa-list"></i> My orders</a></li>
                    <li class="nav-item">
                      <a href="<?= base_url('profile/payment') ?>" class="nav-link"><i class="fa fa-credit-card"></i> My payment 
                        <?php
                          if($payment == '0'){
                            echo "";
                          }else{
                        ?>
                          <span class="btn btn-sm btn-danger"><?= $payment ?></span>
                        <?php
                          }
                        ?>
                      </a>
                    </li>
                    <li class="nav-item"><a href="<?= base_url('home/logout') ?>" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a></li>
                    <?php
                      if($jumlah == ''){
                    ?>
                        <div class="alert alert-danger" role="alert">
                          <p><center>Saldo Deposit Anda <br>Rp. 0 <br> Silahkan isi terlebih dahulu agar dapat mengikuti lelang</center></p>
                        </div>
                        <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-money"></i> Top Up Deposit</a></li>
                    <?php
                      }else{
                    ?>
                      <div class="alert alert-info" role="alert">
                          <p><center>Saldo Deposit Anda <br>Rp. <?= number_format($jumlah,2,',','.') ?></center></p>
                      </div>
                    <?php
                      }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   