  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Minat Bidder Kategori Klik
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
                    <th>Nama Bidder</th>
                    <th>Email</th>
                    <th width="10%">kategori</th>
                    <th width="20%">Jumlah Klik</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql    = "SELECT * FROM users WHERE status = 'aktif' ORDER BY id DESC";
                    $bidder = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($bidder as $row) {
                        $id = $row->id;
                        $sql_klik = $this->db->query("SELECT * FROM abe_kategori_klik WHERE id_bidder = '$id'")->result();
                        foreach ($sql_klik as $klik) {
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto/')."$row->foto' height='50'></td>
                            <td>$row->nama_lengkap</td>
                            <td>$row->email</td>
                            <td>$klik->url_kategori</td>
                            <td>$klik->jumlah_klik</td>
                            </tr>";   
                          $no++;
                        }
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