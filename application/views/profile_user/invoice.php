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
              <p class="text-muted lead">Status pesanan kamu</p>
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
              <div class="box">
                <?php
                  $produk = $this->uri->segment(3);
                  $sql1 = "SELECT * FROM abe_invoice WHERE id_produk = '$produk' ";
                  $sql2 = "SELECT ai.*, ap.*, afp.* FROM abe_invoice as ai, abe_produk as ap, abe_foto_produk as afp WHERE ai.id_produk = '$produk' AND ai.id_produk = ap.id_produk AND afp.id_produk = ap.id_produk ";
                  $invoice = $this->db->query($sql1)->row_array();
                  $produk = $this->db->query($sql2)->row_array();
                  $sql_payment = "SELECT * FROM abe_invoice WHERE id_user = '$id' AND status = 'belum bayar'";
                  $payment = $this->db->query($sql_payment)->num_rows();
                  $nama   = $produk['nama_produk'];
                  $harga  = $invoice['harga_produk'];
                  $kode   = $invoice['kode_unik'];
                  $deposito = $invoice['deposit'];
                  $total  = $harga;
                  $ppn    = ($harga * 10)/100 ;
                  $all_total = $harga + $kode + $ppn - $deposito;
                ?>
                <div class="table-responsive">
                  <a href="<?= base_url('profile/payment/') ?>" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
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
                        <th style="text-align: right">Rp. <?= number_format($deposito,2,',','.') ?></th>
                      </tr>
                      <tr>
                        <th colspan="4" class="text-right">Total Transfer</th>
                        <th style="text-align: right">Rp. <?= number_format($all_total,2,',','.') ?></th>
                      </tr>
                      <tr>
                        <th colspan="5" class="text-right">
                          <?php
                            $status = $invoice['status'];
                            $status_deposit = $invoice['deposit'];
                            if($status == 'lunas'){
                          ?>
                            <button class="btn btn-success"><i class="fa fa-check"></i> Lunas</button>
                          <?php
                            }else{
                              if($status_deposit == '0'){
                          ?>
                            <a href="#" data-toggle="modal" data-target="#deposit-modal" class="btn btn-success"><i class="fa fa-money"></i> Gunakan Deposit</a>
                            <a href="#" data-toggle="modal" data-target="#invoice-modal" class="btn btn-info"><i class="fa fa-money"></i> Bayar Sekarang</a>
                          <?php
                              }else{
                          ?>
                            <a href="#" data-toggle="modal" data-target="#invoice-modal" class="btn btn-info"><i class="fa fa-money"></i> Bayar Sekarang</a>
                          <?php
                              }
                            }
                          ?>
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="row addresses">
                  
                  <div class="col-md-12 text-right">
                    <h3 class="text-uppercase">Shipping address</h3>
                    <p><?= $this->session->userdata('first_name') ?> <?= $this->session->userdata('last_name') ?><br>             13/25 New Avenue<br>              New Heaven<br>              45Y 73J<br>             DKI Jakarta<br>             Indonesia</p>
                  </div>
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
                    <li class="nav-item"><a href="<?= base_url('profile/orders') ?>" class="nav-link "><i class="fa fa-list"></i> My orders</a></li>
                    <li class="nav-item">
                      <a href="<?= base_url('profile/payment') ?>" class="nav-link active"><i class="fa fa-credit-card"></i> My payment 
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
      <div id="invoice-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Masukkan Jumlah Transfer Anda</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form action="<?= base_url('profile/bayar_invoice') ?>" class="form-horizontal" enctype="multipart/form-data" method="post">
                <div class="form-group">
                  <input type="hidden" name="id_invoice" value="<?= $invoice['id_invoice'] ?>">
                  <input type="hidden" name="produk" value="<?= $invoice['id_produk'] ?>">
                  <select class="form-control" name="bank_penerima" required="">
                    <option value="">-- pilih bank yg anda transfer --</option>
                    <option value="BCA - 9876543210">BCA - 9876543210</option>
                    <option value="MANDIRI - 9876543210">MANDIRI - 9876543210</option>
                    <option value="BNI - 9876543210">BNI - 9876543210</option>
                  </select><br>
                  <input type="number" name="jumlah" required="" placeholder="jumlah transfer anda Rp. <?= number_format($all_total,2,',','.') ?>" class="form-control"><br>
                  <input type="hidden" name="total" value="<?= $all_total ?>" class="form-control">
                  <input type="hidden" name="ppn" value="<?= $ppn ?>" class="form-control">
                  <input type="text" name="bank_pengirim" required="" placeholder="Bank Pengirim" class="form-control"><br>
                  <input type="text" name="nama_pengirim" required="" placeholder="Atas Nama. Bank Pengirim" class="form-control"><br>
                  <input type="number" name="nomor_rekening" required="" placeholder="Nomor Rekening Bank Pengirim" class="form-control"><br>
                  <textarea name="catatan" class="form-control" placeholder="catatan"></textarea><br>
                  <h5>Lampirkan Bukti Transfer</h5>
                  <input type="file" id="file" name="file_foto" onchange="return validasiFile()" required="" placeholder="bukti transfer" class="form-control">
                </div>
                <p class="text-center">
                  <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Bayar Sekarang</button>
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan Transfer Sesuai Harga Total, termasuk 3 (tiga) digit terakhir<br> seluruh bank transfer<br> an. <strong> PT Lelang Barang Sejahtera</strong></p>
            </div>
          </div>
        </div>
      </div>
      <div id="deposit-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Masukkan Jumlah Transfer Anda</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form action="<?= base_url('profile/bayar_invoice_deposit') ?>" class="form-horizontal" enctype="multipart/form-data" method="post">
                <div class="form-group">
                  <?php
                    $id       = $this->session->userdata('id');
                    $deposit  = $this->db->query("SELECT * FROM abe_deposit WHERE id_user = '$id' AND status = 'oke'")->row_array();
                    $sisa     = $all_total - $deposit['jumlah'];
                    //$ppn      = ($all_total * 10)/100 ;
                  ?>
                  <input type="hidden" name="id_invoice" value="<?= $invoice['id_invoice'] ?>">
                  <input type="hidden" name="produk" value="<?= $invoice['id_produk'] ?>">
                  <input type="hidden" name="id_deposit" value="<?= $deposit['id_deposit'] ?>">
                  <p>Jumlah Tagihan Invoice Anda :</p>
                  <input type="text" name="jumlah" readonly="" class="form-control" value="Rp. <?= number_format($all_total,2,',','.') ?>"><br>
                  <input type="hidden" name="tagihan" value="<?= $all_total ?>">
                  <input type="hidden" name="ppn" value="<?= $ppn ?>">
                  <p>Jumlah Deposit Anda :</p>
                  <input type="text" name="deposit" readonly="" value="Rp. <?= number_format($deposit['jumlah'],2,',','.') ?>" class="form-control"><br>
                  <input type="hidden" name="nilai_deposit" value="<?= $deposit['jumlah'] ?>" class="form-control">
                  <h5>Total Sisa Yang Harus Anda Bayar</h5>
                  <input type="text" name="sisa_bayar" readonly="" value="Rp. <?= number_format($sisa,2,',','.') ?>" class="form-control"><br>
                </div>
                <p class="text-center">
                  <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Gunakan Deposit</button>
                </p>
              </form>
              <p class="text-center text-muted"> Setelah Menggunakan Deposit Anda<br> Maka Anda diwajibkan Deposit Ulang<br>untuk mengikuti Lelang Lainnya</p>
            </div>
          </div>
        </div>
      </div>