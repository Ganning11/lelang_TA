<?php
  $id       = $this->session->userdata('id');
  $sql_user = "SELECT * FROM users WHERE id = '$id'";
  $bidder   = $this->db->query($sql_user)->row_array();
  $kelamin  = $bidder['gender'];

  $sql_deposit = "SELECT * FROM abe_deposit WHERE id_user = '$id' AND status = 'oke'";
  $deposit     = $this->db->query($sql_deposit)->row_array();
  $jumlah = $deposit['jumlah'];
  $sql_payment = "SELECT * FROM abe_invoice WHERE id_user = '$id' AND status = 'belum bayar'";
  $payment = $this->db->query($sql_payment)->num_rows();
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
              <p class="text-muted lead">Pilih Kategori mana saja yang anda minati / gemari, agar kami dapat menampilkan produk-produk terbaik pilihan anda.</p>
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
              <div class="box mt-0 mb-lg-0">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Link Kategori</th>
                        <th>Minati</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $id_user = $this->session->userdata('id');
                        $sql_rekomendasi = $this->db->get('abe_kategori')->result();
                        $no = 1;
                        foreach ($sql_rekomendasi as $row) {
                      ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $row->nama_kategori ?></td>
                        <td><a href="<?= base_url('home/kategori/').$row->url_kategori ?>"> <?= $row->url_kategori ?></a></td>
                        
                        <td>
                          <input type="hidden" id="bidder" name="bidder" value="<?= $id_user ?>">
                          <input type="checkbox" <?php check_akses($id_user, $row->id_kategori) ?> onclick="addRekomendasi(<?= $row->id_kategori ?>)" name="minati"></td>
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
            <div class="col-md-3 mt-4 mt-md-0">
              <!-- CUSTOMER MENU -->
              <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                  <h3 class="h4 panel-title">Customer section</h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-pills flex-column text-sm">
                    <li class="nav-item"><a href="<?= base_url('profile') ?>" class="nav-link "><i class="fa fa-user"></i> My account</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/rekomendasi') ?>" class="nav-link active"><i class="fa fa-list"></i> My Interest</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/orders') ?>" class="nav-link "><i class="fa fa-list"></i> My orders</a></li>
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

<script type="text/javascript">
  var base_url = '<?php echo base_url();?>';

  function addRekomendasi(kategori){
    //alert('sukses memberikan akses');
    var bidder = $("#bidder").val();
    $.ajax({
      type :'GET',
      url  :'<?= base_url('profile/addrekomendasi') ?>',
      data :'bidder='+bidder+'&kategori='+kategori,
      success:function(html){
        alert('sukses merubah rekomendasi');
      }
    })
  }
</script>