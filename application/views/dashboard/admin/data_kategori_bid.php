  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Minat Bidder Kategori BID
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
                    <th width="20%">Jumlah BID</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql_user    = $this->db->query("SELECT alb.*, us.* FROM abe_lelang_bidder as alb, users as us WHERE us.status = 'aktif' AND us.id = alb.id_bidder GROUP BY alb.id_bidder")->result();
                    $no = 1;
                    foreach ($sql_user as $row) {
                      $sql_bid  = $this->db->query("SELECT id_kategori, count(id_kategori) AS jumlah FROM abe_lelang_bidder WHERE id_bidder = '$row->id_bidder' GROUP BY id_kategori")->result();
                        //$id = $row->id;
                        //$sql_bid = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_bidder = '$id'")->result();
                        foreach ($sql_bid as $bid) {
                          $sql_kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori ='$bid->id_kategori' ")->row_array();
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto/')."$row->foto' height='50'></td>
                            <td>$row->nama_lengkap</td>
                            <td>$row->email</td>
                            <td>$sql_kategori[nama_kategori]</td>
                            <td>$bid->jumlah</td>
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