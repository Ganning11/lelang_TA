  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Profile <?= $record['nama_lengkap'] ?>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="#">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Profile Pelelang</h3>
            </div>
            <div class="box-body">
              <div class="col-xs-3">
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="thumbnail">
                      <div class="view view-first">
                        <img id="preview" style="width: 100%; height: 200px ; display: block;" src="<?= base_url() ?>assets/foto/<?= $record['foto'] ?>" alt="foto karyawan" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-9">
                <div class="form-group">
                  <label class="col-sm-3 control-label">NIK KTP</label>
                  <div class="col-sm-9">
                    <input type="number" name="nik_ktp" placeholder="nomor ktp" readonly="true" class="form-control" value="<?= $record['nik_ktp'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" name="nama_lengkap" class="form-control" readonly="true" value="<?= $record['nama_lengkap'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" readonly="true" name="email" value="<?= $record['email'] ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Hak Akses</label>
                  <div class="col-sm-4">
                    <input type="text" readonly="true" class="form-control" required="true" name="hak_akses" value="<?= $record['hak_akses'] ?>">
                  </div>
                  <label class="col-sm-1 control-label">Status</label>
                  <div class="col-sm-4">
                    <input type="text" readonly="true" class="form-control" required="true" name="status" value="<?= $record['status'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nomor Telphone</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" readonly="true" value="<?= $record['telpon'] ?>" name="telpon" placeholder="nomor telphone">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Alamat Lengkap</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" readonly="true" placeholder="alamat lengkap"  name="alamat" rows="5"><?= $record['alamat'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a href ="javascript:history.back()" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-mail-reply"></i> Kembali</a>
            </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Data Produk</h3>
            </div>
            <div class="box-body">
              <table id="mytable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th width="10%">Foto</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th width="10%">Harga</th>
                    <th width="7%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $user   = $this->uri->segment(4 );
                    $sql    = "SELECT * FROM abe_produk WHERE id_pelelang = '$user' ORDER BY id_produk DESC";
                    $barang = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($barang as $row) {
                        $id = $row->id_kategori;
                        $produk = $row->id_produk;
                        $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id'")->row_array();
                        $a = $kategori['nama_kategori'];
                        $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                        $b = $foto['file_foto'];
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto_produk/')."$b' height='100'></td>
                            <td>$a</td>
                            <td>$row->nama_produk</td>
                            <td>Rp ".number_format($row->harga_produk,2,',','.')."</td>
                            <td>";
                          if($row->status == 'ready' OR $row->status == 'oke'){
                            echo "<button class='btn btn-xs btn-flat btn-info'><i class='fa fa-ban'></i> $row->status</button>";
                          }else if($row->status == 'lelang'){
                            echo "<button class='btn btn-xs btn-flat btn-warning'><i class='fa fa-flag'></i> $row->status</button>";
                          }else{
                            echo "<button class='btn btn-xs btn-flat btn-success'><i class='fa fa-check'></i> $row->status</button>";
                          }
                        echo "</td></tr>";   
                          $no++;
                      }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="<?php echo base_url(); ?>assets/js/chain/jquery.chained.min.js"></script>
<script>
    $("#kabupaten").chained("#propinsi");
    $("#kecamatan").chained("#kabupaten");
    $("#desa").chained("#kecamatan");
</script>
<script>
  $(function () {
    $('#mytable').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script src="<?= base_url() ?>assets/js/jquery.priceformat.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $('.tanggal').datepicker({
            format: "dd-mm-yyyy",
            //format: "yyyy-mm-dd",
            autoclose:true
            }).on('changeDate',function (ev) {
       var idnya = this.id; // baca ID masing2 tgl
       $("#berubah").html('<font color="red"><b>'+$('#'+idnya).val()+'</b></font>');
              });
        });

      $('#harga').priceFormat({
        prefix: 'Rp ',
        centsLimit: 0,
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
</script> 