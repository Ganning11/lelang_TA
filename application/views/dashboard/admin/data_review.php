  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Review Bidder
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
                    <th width="10%">Pelelang</th>
                    <th width="15%">Produk</th>
                    <th width="10%">Bidder</th>
                    <th width="10%">Kepuasan</th>
                    <th>Review</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql    = "SELECT * FROM abe_review ORDER BY id_review DESC";
                    $review = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($review as $row) {
                        $user   = $this->db->query("SELECT * FROM users WHERE id = '$row->user_input'")->row_array();
                        $produk = $this->db->query("SELECT * FROM abe_produk WHERE id_produk = '$row->produk'")->row_array();
                        $pelelang = $this->db->query("SELECT * FROM abe_pelelang WHERE id_user = '$row->pelelang'")->row_array();
                        $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$row->kategori_produk'")->row_array();
                        echo "<tr>
                            <td>$no</td>
                            <td>".$pelelang['email']."</td>
                            <td><a target='blank' href='".base_url('home/produk/').$kategori['url_kategori'].'/'.$row->produk."'> ".$produk['nama_produk']."</a></td>
                            <td>".$user['email']."</td>
                            <td>$row->kepuasan</td>
                            <td>$row->review</td>
                            </tr>";     
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