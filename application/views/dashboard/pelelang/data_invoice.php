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
                    <th>No Invoice</th>
                    <th width="15%">Harga Jual</th>
                    <th width="7%">Status</th>
                    <th width="13%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $user   = $this->session->userdata('id_user');
                    $sql    = "SELECT * FROM abe_produk WHERE id_pelelang = '$user' AND status = 'SOLD OUT' ORDER BY id_produk DESC";
                    $barang = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($barang as $row) {
                        $id = $row->id_kategori;
                        $produk = $row->id_produk;
                        $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id'")->row_array();
                        $a = $kategori['nama_kategori'];
                        $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                        $b = $foto['file_foto'];
                        $jumlah   = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$produk'")->num_rows();
                        $invoice  = $this->db->query("SELECT * FROM abe_invoice WHERE id_produk = '$produk' ")->row_array();
                        echo "<tr>
                            <td>$no .</td>
                            <td><img src='".base_url('assets/foto_produk/')."$b' height='100'></td>
                            <td>$a</td>
                            <td>$row->nama_produk</td>
                            <td><a href='".base_url('back_end/transaksi/detail/').$invoice['id_produk']."'> ".$invoice['no_invoice']."</a> </td>
                            <td>Rp ".number_format($row->harga_jual,2,',','.')."</td>
                            <td>".$invoice['status']."</td>
                            <td>
                              <button class=\"btn btn-xs btn-warning btn-flat\"><i class=\"fa fa-user\"></i> = $jumlah </button>

                              <button class=\"btn btn-xs btn-info btn-flat\" onclick=\"view_detail($row->id_produk)\"><i class=\"fa fa-flag\" ></i> Detail</button>
                            </td></tr>

                            ";    
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

</script>

