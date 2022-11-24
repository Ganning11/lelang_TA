

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Produk Lelang Terjual
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
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
                    <th width="13%">Harga Awal</th>
                    <th width="13%">Harga Lelang</th>
                    <th width="13%">Jumlah Transfer</th>
                    <th width="7%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql    = "SELECT * FROM abe_produk WHERE status = 'sold out' ORDER BY id_produk DESC";
                    $barang = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($barang as $row) {
                        $id       = $row->id_kategori;
                        $produk   = $row->id_produk;
                        $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id'")->row_array();
                        $invoice  = $this->db->query("SELECT * FROM abe_invoice WHERE id_produk = '$produk'")->row_array();
                        $a        = $kategori['nama_kategori'];
                        $foto     = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                        $b = $foto['file_foto'];
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto_produk/')."$b' height='100'></td>
                            <td>$a</td>
                            <td>$row->nama_produk</td>
                            <td>Rp ".number_format($row->harga_produk,2,',','.')."</td>
                            <td>Rp ".number_format($invoice['harga_produk'],2,',','.')."</td>
                            <td>Rp ".number_format($invoice['jumlah_transfer'],2,',','.')."</td>
                            <td><button class='btn btn-xs btn-flat btn-success' ><i class='fa fa-check' ></i> $row->status</button></td></tr>";     
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

<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    })
  })
</script>
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