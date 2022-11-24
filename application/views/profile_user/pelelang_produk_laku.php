<?php
  $id       = $this->uri->segment(3);
  $sql_user = "SELECT * FROM abe_pelelang WHERE id_user = '$id'";
  $pelelang   = $this->db->query($sql_user)->row_array();
  
  if($this->session->userdata('id') == ''){
    $id_user = 'kosong';
  }else{
    $id_user = $this->session->userdata['id'];
  } 
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
                  <h4>Data Produk Terjual</h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Foto</th>
                          <th>Kategori</th>
                          <th>Nama Produk</th>
                          <th>Status</th>
                          <th>Report</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $id         = $this->uri->segment(3);
                          $sql_produk = "SELECT * FROM abe_produk WHERE id_pelelang = '$id' AND status = 'sold out' ";
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
                          <td>
                          <?php
                            $status = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$produk' AND id_bidder = '$id_user' AND status = 'pemenang'")->num_rows();
                            if($status == '0'){
                          ?>
                            <button title="Review Produk" disabled="true" class="btn btn-sm btn-warning btn-flat" onclick="review2('<?= $produk ?>')"><i class="fa fa-edit"></i> report</button>
                          <?php
                            }else{
                          ?>
                            <button title="Review Produk" class="btn btn-sm btn-warning btn-flat" onclick="review('<?= $produk ?>','<?= $id_kategori ?>')"><i class="fa fa-edit"></i> report</button>
                          <?php
                            }
                          ?>

                          </td>
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
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang_produk/').$id ?>" class="nav-link"><i class="fa fa-list"></i> Semua Produk</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/pelelang_produk_laku/').$id ?>" class="nav-link active"><i class="fa fa-list"></i> Produk Terjual</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">

  function review(produk, kategori)
  {
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#review-modal').modal('show'); // show bootstrap modal
      $('[name="id_produk"]').val(produk);
      $('[name="id_kategori"]').val(kategori);
  }

</script>

      <div id="review-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Masukkan Report Anda</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form id="form" action="<?= base_url('profile/report') ?>" class="form-horizontal" enctype="multipart/form-data" method="post">
                <div class="form-group">
                  <select class="form-control" name="kepuasan" required="">
                    <option value="">-- pilih penilaian anda --</option>
                    <option value="kecewa">KECEWA</option>
                    <option value="suka">SUKA</option>
                    <option value="puas">PUAS</option>
                  </select><br>
                  <input type="hidden" name="id_produk" id="id_produk">
                  <input type="hidden" name="id_kategori" id="id_kategori">
                  <input type="hidden" name="id_pelelang" id="id_pelelang" value="<?= $id ?>">
                  <textarea name="review" class="form-control" placeholder="review pengalaman anda"></textarea><br>
                </div>
                <p class="text-center">
                  <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Report Now</button>
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan isi report ini sesuai dengan pengalaman anda<br> menggunakan aplikasi ini<br> Terimakasih</p>
            </div>
          </div>
        </div>
      </div>