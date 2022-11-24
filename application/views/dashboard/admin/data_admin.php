  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Admin
      </h1>
      <ol class="breadcrumb">
        <button class="btn btn-success btn-flat btn-sm" onclick="add_admin()"><i class="fa fa-plus"></i> Admin</button>
      </ol>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="10%">Level</th>
                    <th width="7%">Status</th>
                    <th width="13%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $level  = $this->session->userdata('hak_akses');
                    $sql    = "SELECT * FROM abe_admin ORDER BY id_user DESC";
                    $admin  = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($admin as $row) {
                        echo "<tr>
                            <td>$no .</td>
                            <td><img src='".base_url('assets/foto/')."$row->foto' width='30'></td>
                            <td>$row->nama_lengkap</td>
                            <td>$row->email</td>
                            <td>$row->hak_akses</td>
                            <td>$row->status</td>
                            <td>";
                              $a = $row->id_user;
                              $b = $row->nama_lengkap;
                              $c = $row->email;
                              $d = $row->hak_akses;
                              $e = $row->status;
                        if($level == 'administrator'){
                          if($e == 'aktif'){
                            echo "<a class='btn btn-xs btn-warning btn-flat' href='".base_url()."back_end/admin/hapus/$row->id_user'><i class='fa fa-times'></i> Non aktifkan</a> ";
                            echo "<button title=\"Detail Tamu\" class=\"btn btn-xs btn-info btn-flat\" onclick=\"edit_admin('$a','$b','$c','$d')\"><i class=\"fa fa-pencil\"></i> Edit</button>";
                          } else{
                            echo "<a class='btn btn-xs btn-success btn-flat' href='".base_url()."back_end/admin/aktifkan/$row->id_user'><i class='fa fa-check'></i> Aktifkan</a> ";
                            ?>
                            <a class='btn btn-xs btn-danger btn-flat' href='<?= base_url('back_end/admin/hapus_permanent/').$row->id_user ?>' onclick="javascript: return confirm('Anda yakin ingin hapus data ini selamanya !!')"><i class='fa fa-times'></i>Hapus Permanent</a>

                            <?php
                          } 
                          
                        }else{
                          echo "<button class=\"btn btn-xs btn-info btn-flat\"><i class=\"fa fa-flag\"></i> Done</button>";
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
  var save_method; //for save method string
  var table;
  var base_url = '<?php echo base_url();?>';
   
  function add_admin()
  {
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#btnSave').text('Save'); //change button text
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Admin'); // Set Title to Bootstrap modal title
  }

  function edit_admin(a, b, c, d)
  {
      $('#form2')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#btnSave').text('Save'); //change button text
      $('#modal_form2').modal('show'); // show bootstrap modal
      $('.modal-title').text('Edit Admin'); // Set Title to Bootstrap modal title
      $('[name="id"]').val(a);
      $('[name="nama"]').val(b);
      $('[name="email"]').val(c);
      $('[name="hak_akses"]').val(d);
  }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Pengguna Form</h3>
            </div>
            <div class="modal-body form">
              <form id="form" action="<?= base_url('back_end/admin/add_admin') ?>" method="post" class="form-horizontal">
                <input type="hidden" value="" name="id"/> 
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Lengkap</label>
                        <div class="col-md-9">
                            <input name="nama" placeholder="nama lengkap" class="form-control" type="text" required="">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email</label>
                        <div class="col-md-9">
                            <input name="email" placeholder="email" class="form-control" type="email" required="">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Password</label>
                        <div class="col-md-9">
                            <input name="password" placeholder="password" class="form-control" type="password" required="">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Hak Akses</label>
                      <div class="col-md-9">
                       <select class="form-control" name="hak_akses" required="">
                         <option value="">-- pilih hak akses --</option>
                         <option value="admin">Admin</option>
                         <option value="administrator">Administrator</option>
                       </select>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                  <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                </div>
              </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Pengguna Form</h3>
            </div>
            <div class="modal-body form">
              <form id="form2" action="<?= base_url('back_end/admin/edit_admin') ?>" method="post" class="form-horizontal">
                <input type="hidden" value="" name="id"/> 
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Lengkap</label>
                        <div class="col-md-9">
                          <input name="id" type="hidden">
                            <input name="nama" placeholder="nama lengkap" class="form-control" type="text" required="">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email</label>
                        <div class="col-md-9">
                            <input name="email" placeholder="email" class="form-control" type="email" required="">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Password</label>
                        <div class="col-md-9">
                            <input name="password" placeholder="kosongkan saja bila tidak merubah password" class="form-control" type="password">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Hak Akses</label>
                      <div class="col-md-9">
                       <select class="form-control" name="hak_akses" required="">
                         <option value="">-- pilih hak akses --</option>
                         <option value="admin">Admin</option>
                         <option value="administrator">Administrator</option>
                       </select>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Update</button>
                  <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                </div>
              </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->