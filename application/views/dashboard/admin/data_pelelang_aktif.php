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
                    <th width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql    = "SELECT * FROM abe_pelelang WHERE status = 'aktif' ORDER BY id_user DESC";
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
                            <td><a title='Detail Pelelang' class='btn btn-xs btn-info btn-flat' href='".base_url()."back_end/users/detail_pelelang/$id'><i class='fa fa-list'></i> Detail</a> <a class='btn btn-xs btn-danger btn-flat' href='".base_url()."back_end/users/blokir_pelelang/$id'><i class='fa fa-ban'></i> blokir</a></td></tr>";     
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