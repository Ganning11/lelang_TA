  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pelelang Aktif
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
                    <th>Nama Pelelang</th>
                    <th>Email</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql    = "SELECT * FROM abe_pelelang WHERE status = 'daftar' ORDER BY id_user DESC";
                    $pelelang = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($pelelang as $row) {
                        $id = $row->id_user;
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto/')."$row->foto' height='50'></td>
                            <td>$row->nama_lengkap</td>
                            <td>$row->email</td>
                            <td>$row->status</td>
                            <td><a title='Aktifkan Pelelang' class='btn btn-xs btn-success btn-flat' href='".base_url()."back_end/users/aktifkan_pelelang/$id'><i class='fa fa-check'></i> Aktifkan</a></td></tr>";     
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