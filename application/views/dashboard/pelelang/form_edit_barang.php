<script src="<?= base_url();?>assets/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ 
  selector:'textarea',
  plugins : 'advlist lists table'
});</script>

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
  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Buat Produk Lelang
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-5">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <?php
                $user = $this->session->userdata('id_user');
              ?>
                <div class="form-group" style="text-align: left">
                  <button class="btn btn-sm btn-success btn-flat" onclick="add_file()"><i class="fa fa-plus"></i> Foto Produk</button>
                  <a class="btn btn-sm btn-warning btn-flat" href="<?= base_url('back_end/barang/') ?>"><i class="fa fa-reply"></i> Cancel</a>
                </div>
                <div id="table_foto_produk"></div>
                <p><i><strong>note : </strong><br>Foto yang di perbolehkan upload ( jpg / png / jpeg )<br>Size maks 1 Mb</i></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-7">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?= base_url('back_end/barang/update_produk'); ?>">
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" value="<?= $this->uri->segment(4) ?>" name="id_produk"/> 
                  <label class="col-sm-4 control-label">Kategori Produk</label>
                  <div class="col-sm-8">
                    <?php
                      echo cmb_dinamis('kategori','abe_kategori','nama_kategori','id_kategori',$record['id_kategori']);
                    ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nama Produk</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?= $record['nama_produk'] ?>" required="true" name="nama" placeholder="nama produk">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Harga Produk</label>
                  <div class="col-sm-8">
                    <input type="text" id="harga" class="form-control" required="true" name="harga" value="<?= $record['harga_produk'] ?>" placeholder="harga minimal produk">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Harga Maksimal</label>
                  <div class="col-sm-8">
                    <input type="text" id="max_harga" class="form-control" required="true" name="max_harga" value="<?= $record['max_harga'] ?>" placeholder="harga minimal produk">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Jumlah Produk</label>
                  <div class="col-sm-8">
                    <input type="number" readonly="" class="form-control" name="jumlah" value="1" placeholder="stok produk">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Keterangan / Deskripsi Produk</h3>
            </div>
            <div class="box-body">
              <textarea id="editor1" name="keterangan" rows="10" cols="80"><?= $record['deskripsi'] ?></textarea>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-save"></i> Update</button>
              <a href="<?= base_url('back_end/barang') ?>" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-mail-reply"></i> Cancel</a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        </form>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
      $('#max_harga').priceFormat({
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
  var id_produk = '<?= $this->uri->segment(4) ?>';
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
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Foto Produk Form</h3>
            </div>
            <div class="modal-body form">
              <form action="#" id="form"  class="form-horizontal">
                <input type="hidden" value="" name="id"/>
                <input type="hidden" value="oke" name="status"/>
                <input type="hidden" value="<?= $this->uri->segment(4) ?>" name="id_produk"/> 
                <div class="form-body">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12">Nama Foto Produk</label>
                    <div class="col-md-9 col-sm-12">
                      <input type="text" name="nama_foto" placeholder="nama foto produk / keterangan" class="form-control" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12">Pilih File</label>
                    <div class="col-md-9 col-sm-12">
                      <input type="file" id="file" name="file_foto" onchange="return validasiFile()" class="form-control" >
                    </div>
                  </div>
                  <p style="text-align: right"><i><strong>note : </strong><br>Gambar yang di perbolehkan upload berformat .JPG / .JPEG / .PNG<br>Size maks 1 Mb</i></p>
                </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"> <i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- CK Editor -->
<script src="<?= base_url() ?>assets/back_end/bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/back_end/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>