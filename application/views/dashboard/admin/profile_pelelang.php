  <script>
      function validasiFile(){
        var inputFile = document.getElementById('file');
        var pathFile = inputFile.value;
        var file_size = $('#file')[0].files[0].size;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Mohon maaf, file yang diperbolehkan untuk upload berformat .JPG / .JPEG / .PNG');
            inputFile.value = '';
            return false;
        }else if(file_size > 1000000){
            alert('Mohon maaf, file yang diperbolehkan untuk upload maksimal 1 Mb');
            inputFile.value = '';
            return false;
        }
      }

      function tampilkanPreview(gambar,idpreview){
//                membuat objek gambar
          var gb = gambar.files;
          
//                loop untuk merender gambar
          for (var i = 0; i < gb.length; i++){
//                    bikin variabel
              var gbPreview = gb[i];
              var imageType = /image.*/;
              var preview=document.getElementById(idpreview);            
              var reader = new FileReader();
              
              if (gbPreview.type.match(imageType)) {
//                        jika tipe data sesuai
                  preview.file = gbPreview;
                  reader.onload = (function(element) { 
                      return function(e) { 
                          element.src = e.target.result; 
                      }; 
                  })(preview);

//                    membaca data URL gambar
                  reader.readAsDataURL(gbPreview);
              }else{
//                        jika tipe data tidak sesuai
                  alert("Type file tidak sesuai. Khusus image.");
              }
             
          }    
      }
  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile <?= $record['nama_lengkap'] ?>
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
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?= base_url('dashboard/update_pelelang'); ?>">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Profile Pelelang</h3>
            </div>
            <div class="box-body">
              <div class="col-xs-3">
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="thumbnail">
                      <div class="view view-first">
                        <img id="preview" style="width: 100%; height: 200px ; display: block;" src="<?= base_url() ?>assets/foto/<?= $record['foto'] ?>" alt="foto karyawan" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <input type="file" id="exampleInputFile" name="foto" accept="image/*" onchange="tampilkanPreview(this,'preview')" class="form-control">
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
              <div class="col-xs-9">
                <div class="form-group">
                  <label class="col-sm-3 control-label">NIK KTP</label>
                  <div class="col-sm-9">
                    <input type="number" name="nik_ktp" placeholder="nomor ktp" class="form-control" value="<?= $record['nik_ktp'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" name="nama_lengkap" class="form-control" required="true" value="<?= $record['nama_lengkap'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" required="true" name="email" value="<?= $record['email'] ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Hak Akses</label>
                  <div class="col-sm-4">
                    <input type="text" readonly="true" class="form-control" required="true" name="hak_akses" value="<?= $record['hak_akses'] ?>">
                  </div>
                  <label class="col-sm-1 control-label">Status</label>
                  <div class="col-sm-4">
                    <input type="text" readonly="true" class="form-control" required="true" name="status" value="<?= $record['status'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nomor Telphone</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" required="true" value="<?= $record['telpon'] ?>" name="telpon" placeholder="nomor telphone">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Alamat Lengkap</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" placeholder="alamat lengkap"  name="alamat" rows="5"><?= $record['alamat'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-save"></i> Update Data</button>
              <a href="<?= base_url('dashboard') ?>" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-mail-reply"></i> Cancel</a>
            </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Data Produk</h3>
            </div>
            <div class="box-body">
              <table id="mytable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th width="10%">Foto</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th width="10%">Harga</th>
                    <th width="7%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $user   = $this->session->userdata('id_user');
                    $sql    = "SELECT * FROM abe_produk WHERE id_pelelang = '$user' ORDER BY id_produk DESC";
                    $barang = $this->db->query($sql)->result();
                    $no = 1;
                    foreach ($barang as $row) {
                        $id = $row->id_kategori;
                        $produk = $row->id_produk;
                        $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id'")->row_array();
                        $a = $kategori['nama_kategori'];
                        $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk' ORDER BY id_foto_produk DESC LIMIT 1")->row_array();
                        $b = $foto['file_foto'];
                        echo "<tr>
                            <td>$no</td>
                            <td><img src='".base_url('assets/foto_produk/')."$b' height='100'></td>
                            <td>$a</td>
                            <td>$row->nama_produk</td>
                            <td>Rp ".number_format($row->harga_produk,2,',','.')."</td>
                            <td>";
                          if($row->status == 'ready' OR $row->status == 'oke'){
                            echo "<button class='btn btn-xs btn-flat btn-info'><i class='fa fa-ban'></i> $row->status</button>";
                          }else if($row->status == 'lelang'){
                            echo "<button class='btn btn-xs btn-flat btn-warning'><i class='fa fa-flag'></i> $row->status</button>";
                          }else{
                            echo "<button class='btn btn-xs btn-flat btn-success'><i class='fa fa-check'></i> $row->status</button>";
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
<script src="<?php echo base_url(); ?>assets/js/chain/jquery.chained.min.js"></script>
<script>
    $("#kabupaten").chained("#propinsi");
    $("#kecamatan").chained("#kabupaten");
    $("#desa").chained("#kecamatan");
</script>
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
<script src="<?= base_url() ?>assets/js/jquery.priceformat.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $('.tanggal').datepicker({
            format: "dd-mm-yyyy",
            //format: "yyyy-mm-dd",
            autoclose:true
            }).on('changeDate',function (ev) {
       var idnya = this.id; // baca ID masing2 tgl
       $("#berubah").html('<font color="red"><b>'+$('#'+idnya).val()+'</b></font>');
              });
        });

      $('#harga').priceFormat({
        prefix: 'Rp ',
        centsLimit: 0,
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
</script> 
<script type="text/javascript">
  var save_method; //for save method string
  var table;
  var base_url = '<?= base_url();?>';
  var id_produk = '';
  loadDataLampiran(id_produk);

  function add_file()
  {
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Foto Produk'); // Set Title to Bootstrap modal title
  }

  function save()
  {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      var url;
      url = "<?php echo site_url('back_end/barang/add_foto')?>";
      var formData = new FormData($('#form')[0]);
      // ajax adding data to database
      $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
          success: function(data)
          {
            if(data.status) //if success close modal and reload ajax table
            {
              $('#modal_form').modal('hide');
              loadDataLampiran(id_produk);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable 
          }
      });
  }

 function loadDataLampiran($no){
    var id_produk = $no;
    $.ajax({
      type :'GET',
      url  :'<?= base_url('back_end/barang/dataFoto') ?>',
      data :'id_produk='+id_produk,
      success:function(html){
        $("#table_foto_produk").html(html);
      }
    })
  }

  function delete_foto(id)
  {
      if(confirm('Anda yakin ingin menghapus Foto ini?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?php echo site_url('back_end/barang/hapus_foto')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  loadDataLampiran(id_produk);
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
      }
  }

</script>