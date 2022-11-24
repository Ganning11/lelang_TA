

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Invoice Masuk
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
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
            <div class="box-body">
              <table id="mytable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th width="10%">Bukti Transfer</th>
                    <th>Email User</th>
                    <th>Bank Tujuan</th>
                    <th>Jumlah Transfer</th>
                    <th>Atas Nama</th>
                    <th width="7%">Status</th>
                    <th width="7%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql    = "SELECT * FROM abe_invoice WHERE status = 'transfer' ORDER BY id_invoice DESC";
                    $invoice = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($invoice as $row) {
                        //$id = $row->id_kategori;
                        $id_invoice = $row->id_invoice;
                        $id = $row->id_user;
                        $user = $this->db->query("SELECT * FROM users WHERE id = '$id'")->row_array();
                        $a = $user['email'];
                        $b = $row->file_foto;
                        //$foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                        //$b = $foto['file_foto'];
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto_transfer/')."$b' height='100'></td>
                            <td>$a</td>
                            <td>$row->bank_penerima</td>
                            <td>Rp ".number_format($row->jumlah_transfer,2,',','.')."</td>
                            <td>$row->nama_pengirim</td>
                            <td>$row->status</td>
                            <td><a title='Konfirmasi Deposit' class='btn btn-xs btn-info btn-flat' href='".base_url()."back_end/deposit/konfirmasi_invoice/$id_invoice'><i class='fa fa-check'></i> Confirm</a></tr>";     
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