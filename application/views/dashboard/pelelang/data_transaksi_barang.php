  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Transaksi Produk Lelang
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <?php if($this->session->flashdata('sukses')){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <p><center><?php echo $this->session->flashdata('sukses'); ?></center></p>
            </div>
          <?php }?>
          <?php if($this->session->flashdata('gagal')){ ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <p><center><?php echo $this->session->flashdata('gagal'); ?></center></p>
            </div>
          <?php }?>
          <div class="box">
            <div id='form_view'></div>
          </div>
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="mytable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th width="10%">Foto</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th width="15%">Harga</th>
                    <th width="7%">Status</th>
                    <th width="20%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $user   = $this->session->userdata('id_user');
                    $sql    = "SELECT * FROM abe_produk WHERE id_pelelang = '$user' AND status = 'lelang' ORDER BY id_produk DESC";
                    $barang = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($barang as $row) {
                        $id = $row->id_kategori;
                        $produk = $row->id_produk;
                        $tgl_tutup= $row->tgl_tutup;
                        $today    = date('Y-m-d');
                        $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id'")->row_array();
                        $a = $kategori['nama_kategori'];
                        $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                        $b = $foto['file_foto'];
                        $jumlah = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$produk'")->num_rows();
                        echo "<tr>
                            <td>$no .</td>
                            <td><img src='".base_url('assets/foto_produk/')."$b' height='100'></td>
                            <td>$a</td>
                            <td>$row->nama_produk</td>
                            <td>Rp ".number_format($row->harga_produk,2,',','.')."</td>
                            <td>$row->status</td>";
                            if($tgl_tutup < $today){
                              echo "<td>
                              <button class=\"btn btn-xs btn-warning btn-flat\"><i class=\"fa fa-user\"></i> = $jumlah </button>
                              <button class=\"btn btn-xs btn-info btn-flat\" onclick=\"view_detail($row->id_produk)\"><i class=\"fa fa-flag\" ></i> Detail</button>
                              <button onclick=\"mulai_lelang('$row->id_produk')\" class=\"btn btn-xs btn-danger btn-flat\"><i class=\"fa fa-ban\"></i> expired </button>
                            </td>

                            </tr>
                            "; 
                            }else{
                              echo "<td>
                              <button class=\"btn btn-xs btn-warning btn-flat\"><i class=\"fa fa-user\"></i> = $jumlah </button>

                              <button class=\"btn btn-xs btn-info btn-flat\" onclick=\"view_detail($row->id_produk)\"><i class=\"fa fa-flag\" ></i> Detail</button>
                            </td>

                            </tr>
                            "; 
                            }
                           
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

<!-- page script -->
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    })
  })
  
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

<script type="text/javascript">
  function view_detail($id){
    var id_produk = $id;
    $.ajax({
      type :'GET',
      url  :'<?= base_url('back_end/transaksi/form_view_detail') ?>',
      data :'id_produk='+id_produk,
      success:function(html){
        $("#form_view").html(html);
      }
    })
  }

  function mulai_lelang(produk)
  {
      $('#form2')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#btnSave').text('Save'); //change button text
      $('#modal_form2').modal('show'); // show bootstrap modal
      $('.modal-title').text('Mulai Lelang'); // Set Title to Bootstrap modal title
      $('[name="id"]').val(produk);
  }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Pengguna Form</h3>
            </div>
            <div class="modal-body form">
              <form id="form2" action="<?= base_url('back_end/barang/proses_lelang') ?>" method="post" class="form-horizontal">
                <input type="hidden" value="" name="id"/> 
                <div class="form-body">
                  <div class="form-group">
                      <label class="control-label col-md-3">Tanggal Akhir</label>
                      <div class="col-md-9">
                        <input name="id" type="hidden">
                          <input name="tgl_akhir" placeholder="tanggal akhir lelang" class="form-control" type="text" id="datepicker" required="">
                          <span class="help-block"></span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3">Keterangan Tambahan</label>
                      <div class="col-md-9">
                          <textarea name="keterangan" class="form-control"></textarea>
                          <span class="help-block"></span>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Proses</button>
                  <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                </div>
              </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->