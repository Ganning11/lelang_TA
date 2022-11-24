  <script>
      function validasiFile(){
        var inputFile = document.getElementById('file');
        var pathFile = inputFile.value;
        var file_size = $('#file')[0].files[0].size;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Mohon maaf, file yang diperbolehkan untuk upload berformat .JPG / .JPEG / .PNG');
            inputFile.value = '';
            return false;
        }else if(file_size > 1000000){
            alert('Mohon maaf, file yang diperbolehkan untuk upload maksimal 1 Mb');
            inputFile.value = '';
            return false;
        }
      }
  </script>

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
              <h1 class="h2">My Account</h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">My Account</li>
              </ul>
            </div>
          </div>
        </div>
      </div> 
      <div id="content">
        <div class="container">
          <div class="row bar">
            <div id="customer-account" class="col-lg-9 clearfix">
              <p class="lead">Ubah data diri kami di halaman ini</p>
              <!-- <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p> -->
              <div class="bo3">
                <div class="heading">
                  <h3 class="text-uppercase">Data Diri</h3>
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
                        <label for="firstname">Nama Depan</label>
                        <input id="firstname" name="firstname" value="<?= $bidder['first_name'] ?>" required="" type="text" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lastname">Nama Belakang</label>
                        <input id="lastname" type="text" name="lastname" value="<?= $bidder['last_name'] ?>" required="" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="company">Email</label>
                        <input id="company" type="text" name="email" value="<?= $bidder['email'] ?>" readonly="" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="street">Jenis Kelamin</label>
                        <select class="form-control" required="" name="gender">
                          <option value="">-- pilih kelamin --</option>
                          <option value="laki-laki" <?php if($kelamin == 'laki-laki'){ echo "selected='active'";} ?>> Laki - Laki</option>
                          <option value="perempuan" <?php if($kelamin == 'perempuan'){ echo "selected='active'";} ?>> Perempuan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 col-lg-12">
                      <div class="form-group">
                        <label for="city">Alamat</label>
                        <textarea class="form-control" name="alamat"><?= $bidder['alamat'] ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone">No HP</label>
                        <input name="telephone" value="<?= $bidder['telephone'] ?>" required="" type="text" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone">Password **</label>
                        <input name="password" placeholder="masukkan password username anda" type="password" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="phone">** Untuk dapat login dengan username anda</label>
                        
                      </div>
                    </div>
                    <div class="col-md-12 text-center">
                      <button type="submit" class="btn btn-template-outlined"><i class="fa fa-save"></i> Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
              <br>
              <div class="box mt-0 mb-lg-0">
                <h4>Data Deposit Anda</h4>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Produk</th>
                        <th>Jumlah Deposit</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $id_user = $this->session->userdata['id'];
                        $sql_deposit = "SELECT * FROM abe_deposit WHERE id_user = '$id_user'";
                        $deposit = $this->db->query($sql_deposit)->result();
                        $deposit2 = $this->db->query($sql_deposit)->num_rows();
                        $sql_payment = "SELECT * FROM abe_invoice WHERE id_user = '$id_user' AND status = 'belum bayar'";
                        $payment = $this->db->query($sql_payment)->num_rows();
                        $no = 1;
                        if($deposit2 == ''){
                          ?>
                        <tr><td colspan="5"><center>belum ada deposit masuk / tidak ada data</center> </td></tr>
                        <?php
                          }else{
                        foreach ($deposit as $row) {
                          $produk = $row->id_produk;
                          $user_bidder = "SELECT * FROM abe_produk WHERE id_produk = '$produk'";
                          $sql_produk = $this->db->query($user_bidder)->row_array();
                      ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= date('d M Y / H:i:s', strtotime($row->tgl_deposit)) ?></td>
                        <td><a href="<?= base_url('home/produk/kategori/').$sql_produk['id_produk'] ?>"> <?= $sql_produk['nama_produk'] ?> </a></td>
                        <td>Rp. <?= number_format($row->jumlah,2,',','.') ?></td>
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
            <div class="col-lg-3 mt-4 mt-lg-0">
              <!-- CUSTOMER MENU -->
              <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                  <h3 class="h4 panel-title">Customer section</h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-pills flex-column text-sm">
                    <li class="nav-item"><a href="<?= base_url('profile') ?>" class="nav-link active"><i class="fa fa-user"></i> My account</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/rekomendasi') ?>" class="nav-link"><i class="fa fa-list"></i> My Interest</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/orders') ?>" class="nav-link"><i class="fa fa-list"></i> My orders</a></li>
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
                        <li class="nav-item"><a href="#" data-toggle="modal" data-target="#deposit-modal" class="nav-link active"><i class="fa fa-money"></i> Top Up Deposit</a></li>
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
    </div>

      <div id="deposit-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Masukkan Jumlah Deposit Anda</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form action="<?= base_url('profile/deposit') ?>" class="form-horizontal" enctype="multipart/form-data" method="post">
                <div class="form-group">
                  <select class="form-control" name="bank_penerima" required="">
                    <option value="">-- pilih bank yg anda transfer --</option>
                    <option value="BCA - 9876543210">BCA - 9876543210</option>
                    <option value="MANDIRI - 9876543210">MANDIRI - 9876543210</option>
                    <option value="BNI - 9876543210">BNI - 9876543210</option>
                  </select><br>
                  <input type="number" name="jumlah" required="" placeholder="jumlah minimal transfer deposit 200 RB" class="form-control"><br>
                  <input type="text" name="bank_pengirim" required="" placeholder="Bank Pengirim" class="form-control"><br>
                  <input type="text" name="nama_pengirim" required="" placeholder="Atas Nama. Bank Pengirim" class="form-control"><br>
                  <input type="number" name="nomor_rekening" required="" placeholder="Nomor Rekening Bank Pengirim" class="form-control"><br>
                  <textarea name="catatan" class="form-control" placeholder="catatan"></textarea><br>
                  <h5>Lampirkan Bukti Transfer</h5>
                  <input type="file" id="file" name="file_foto" onchange="return validasiFile()" required="" placeholder="bukti transfer" class="form-control">
                </div>
                <p class="text-center">
                  <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Deposit Now</button>
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan Transfer Deposit Rp 200.000 Rupiah, untuk mengikuti lelang ini<br> seluruh bank transfer<br> an. <strong> PT Lelang Barang Sejahtera</strong></p>
            </div>
          </div>
        </div>
      </div>