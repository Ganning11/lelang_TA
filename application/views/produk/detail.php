      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2"><?= $record['nama_produk'] ?></h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Produk</a></li>
                <li class="breadcrumb-item"><a href="#"><?= $this->uri->segment(3) ?></a></li>
                <li class="breadcrumb-item active"><?= $record['nama_produk'] ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar">
            <!-- LEFT COLUMN _________________________________________________________-->
            <div class="col-lg-9">
              <div id="productMain" class="row">
                <div class="col-sm-6">
                  <div data-slider-id="1" class="owl-carousel shop-detail-carousel">
                    <?php
                      $id_produk = $this->uri->segment(4);
                      $status = $record['status'];
                      $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk'")->result();
                      foreach ($foto as $row) {
                    ?>
                      <div> <img src="<?= base_url('assets/foto_produk/').$row->file_foto ?>" alt="" class="img-fluid"></div>
                    <?php
                      }
                    ?>
                  </div>
                </div>
                <div class="col-sm-6">
                  <?php
                    $id_pelelang = $record['id_pelelang'];
                    $pelelang = $this->db->query("SELECT * FROM abe_pelelang WHERE id_user = '$id_pelelang' ")->row_array();
                    
                  ?>
                  <a href="<?= base_url('profile/pelelang/').$id_pelelang ?>" class="btn btn-info" ><i class="fa fa-user"></i> <?= $pelelang['nama_lengkap'] ?></a>
                  <div class="box">
                    <form>
                      <div class="sizes">
                        <h3><?= $record['nama_produk'] ?></h3>
                        <?php
                          $today = date('Y-m-d');
                          $exp = $record['tgl_tutup'];
                        ?>
                        <?php
                          if($status == 'sold out'){
                        ?>
                          <button class="btn btn-warning" ><i class="fa fa-check"></i> sold out</button>
                        <?php
                          }else if($status == 'ready'){
                            ?>
                              <button class="btn btn-warning" ><i class="fa fa-check"></i> cooming soon</button>
                            <?php
                          }else{
                            ?>
                            <button class="btn btn-warning" ><i class="fa fa-hourglass-half"></i> Exp. <?= date('d F Y', strtotime($exp)) ?></button>
                        <?php
                          }
                        ?>
                      </div>
                      <?php if($this->session->flashdata('sukses')){ ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p><center><?php echo $this->session->flashdata('sukses'); ?></center></p>
              </div>
                      <?php }?>
                      <?php if($this->session->flashdata('gagal')){ ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <p><center><?php echo $this->session->flashdata('gagal'); ?></center></p>
                        </div>
                      <?php }?>
                      <p class="price_max">Harga Saat ini </p>
                      <p class="price">Rp. <?= number_format($record['harga_produk'],2,',','.') ?></p>
                      <p class="price_max">Harga maksimal</p>
                      
                      <p class="price">Rp. <?= number_format($record['max_harga'],2,',','.') ?></p>
                      <p class="text-center">
                        <?php
                          $user = $this->session->userdata('id');
                          
                          if($user == ''){
                        ?>
                          <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-shopping-cart"></i> Bid Now</a>
                          <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-shopping-cart"></i> Beli Langsung</a>
                        <?php
                          }else{
                            $sql_cek = "SELECT * FROM abe_deposit WHERE id_user = '$user' AND status = 'oke'";
                            $deposit = $this->db->query($sql_cek)->num_rows();
                            if($deposit == ''){
                          ?>
                          <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#deposit-modal"><i class="fa fa-shopping-cart"></i> Bid Now</a>
                          <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#deposit-modal"><i class="fa fa-shopping-cart"></i> Beli Langsung</a>
                          <?php
                            }else{
                              if($status == 'sold out'){
                                ?>
                                  <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#soldout-modal"><i class="fa fa-shopping-cart"></i> Bid Now</a>
                                  <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#soldout-modal"><i class="fa fa-shopping-cart"></i> Beli Langsung</a>
                              <?php
                              }else if($status == 'ready'){
                                ?>
                                  <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#ready-modal"><i class="fa fa-shopping-cart"></i> Bid Now</a>
                                  <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#ready-modal"><i class="fa fa-shopping-cart"></i> Beli Langsung</a>
                                <?php
                              }else{
                                if($today <= $exp){
                                  ?>
                                    <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#bid-modal"><i class="fa fa-shopping-cart"></i> Bid Now</a>
                                    <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#bin-modal"><i class="fa fa-shopping-cart"></i> Beli Langsung</a>
                                  <?php
                                }else{
                                  ?>
                                    <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#exp-modal"><i class="fa fa-shopping-cart"></i> Bid Now</a>
                                    <a class="btn btn-template-outlined" href="#" data-toggle="modal" data-target="#exp-modal"><i class="fa fa-shopping-cart"></i> Beli Langsung</a>
                                  <?php
                                }
                                ?>
                                  
                                <?php
                              }
                            }
                        ?>
                          
                        <?php
                          }
                        ?>
                      </p>
                    </form>
                  </div>
                  <div data-slider-id="1" class="owl-thumbs">
                    <?php
                      $id_produk = $this->uri->segment(4);
                      $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk'")->result();
                      foreach ($foto as $row) {
                    ?>
                      <button class="owl-thumb-item"><img width="50" height="50" src="<?= base_url('assets/foto_produk/').$row->file_foto ?>" alt="" class="img-fluid"></button>
                    <?php
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div id="details" class="box mb-4 mt-4">
                <p></p>
                <h4>Informasi Produk</h4>
                <?= $record['deskripsi'] ?>
                <blockquote class="blockquote">
                  <p class="mb-0"><em><?= $record['keterangan'] ?></em></p>
                </blockquote>
                
                <div class="table-responsive">
                  <h3>Penawaran saat ini</h3>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Penawar</th>
                        <th>Jumlah Penawaran</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $id_barang = $this->uri->segment(4);
                        $sql_bidder = "SELECT * FROM abe_lelang_bidder WHERE id_barang = '$id_barang' ORDER BY id_lelang_bidder DESC";
                        $bidder = $this->db->query($sql_bidder)->result();
                        $bidder2 = $this->db->query($sql_bidder)->num_rows();
                        $no = 1;
                        if($bidder2 == ''){
                          ?>
                        <tr><td colspan="5"><center>belum ada penawaran masuk / tidak ada data</center> </td></tr>
                        <?php
                          }else{
                        foreach ($bidder as $row) {
                          $user = $row->id_bidder;
                          $user_bidder = "SELECT email, id FROM users WHERE id = '$user'";
                          $sql_user = $this->db->query($user_bidder)->row_array();
                      ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= date('d M Y / H:i:s', strtotime($row->tanggal)) ?></td>
                        <td><?= $sql_user['email'] ?></td>
                        <td>Rp. <?= number_format($row->harga_lelang,2,',','.') ?></td>
                        <td><span class="badge badge-info"><?= $row->status ?></span></td>
                      </tr>
                      <?php
                          $no ++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-6">
                  <div class="box text-uppercase mt-0 mb-small">
                    <h3>Produk Yang Mungkin Kamu Suka</h3>
                  </div>
                </div>
                <?php
                  $kategori = $record['id_kategori'];
                  $produk   = $this->uri->segment(4);
                  $produk_kategori = $this->db->query("SELECT * FROM abe_produk WHERE id_kategori = '$kategori' AND id_produk != '$produk' ORDER BY rand() LIMIT 3")->result();
                  foreach ($produk_kategori as $pk) {
                    $produk = $pk->id_produk;
                    $uri    = $this->uri->segment(3);
                    $foto   = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$produk'")->row_array();
                ?>
                  <div class="col-lg-3 col-md-6">
                    <div class="product">
                      <div class="image">
                        <a href="<?= base_url('home/produk/').$uri.'/'.$produk ?>"><img width="100" height="100" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" alt="<?= $pk->nama_produk ?>" ></a>
                      </div>
                      <div class="text">
                        <h3 class="h5"><a href="<?= base_url('home/produk/').$uri.'/'.$produk ?>"><?= $pk->nama_produk ?></a></h3>
                        <p class="price">Rp. <?= number_format($pk->harga_produk,2,',','.') ?></p>
                      </div>
                      <?php
                        if($pk->status == 'sold out'){
                      ?>
                        <div class="ribbon-holder">
                          <div class="ribbon new">soldout</div>
                        </div>
                      <?php
                        }else if($pk->status == 'ready'){
                      ?>
                        <div class="ribbon-holder">
                          <div class="ribbon sale">soon</div>
                        </div>
                      <?php
                        }else{
                      ?>
                        <div class="ribbon-holder">
                          <div class="ribbon sale">Bid now</div>
                        </div>
                      <?php
                        }
                      ?>
                      
                    </div>
                  </div>
                <?php
                  }
                ?>
              </div>
            </div>
            <div class="col-lg-3">
              <!-- MENUS AND FILTERS-->
              <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                  <h3 class="h4 panel-title">Kategori</h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-pills flex-column text-sm category-menu">
                    <?php
                      $kategori = $this->db->query("SELECT * FROM abe_kategori")->result();
                      foreach ($kategori as $row) {
                        $url = $row->url_kategori;
                        $uri = $this->uri->segment(3);
                        $jumlah = "SELECT * FROM abe_produk WHERE id_kategori = '$row->id_kategori' AND status = 'lelang'";
                        $jml = $this->db->query($jumlah)->num_rows();
                    ?>
                        <li class="nav-item">
                          <a href="<?= base_url('home/kategori/').$url ?>" <?php if($url == $uri){ echo "class='nav-link active d-flex align-items-center justify-content-between'";}else{ echo "class='nav-link d-flex align-items-center justify-content-between'";} ?> >
                            <span><?= $row->nama_kategori ?></span><span class="badge badge-secondary"><?= $jml ?></span>
                          </a>
                        </li>
                    <?php
                      }
                    ?>
                  </ul>
                </div>
              </div>
              <div class="panel-heading">
                <h3 class="h4 panel-title">Produk Rekomendasi</h3>
              </div>
              <?php
                $sql    = "SELECT ap.*, alb.* FROM abe_produk as ap, abe_lelang_bidder as alb WHERE ap.status = 'lelang' AND ap.id_produk = alb.id_barang GROUP BY alb.id_barang  ORDER BY rand() LIMIT 4 ";
                $produk = $this->db->query($sql)->result();
                foreach ($produk as $row) {
                  $id_kategori  = $row->id_kategori;
                  $id_produk    = $row->id_produk;
                  $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                  $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
                  $bidder = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$id_produk'")->num_rows();
              ?>
                <div class="product">
                  <div class="image">
                    <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>">
                      <img width="200" height="200" class="img-circle" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" ></a>
                  </div>
                  <div class="text">
                    <h3 class="h5"><a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>"><?= $row->nama_produk ?></a></h3>
                    <p class="price"><strong> Rp. <?= number_format($row->harga_produk,2,',','.') ?> </strong></p>
                  </div>
                  <div class="ribbon-holder">
                      <div class="ribbon new"><?= $bidder ?> bid</div>
                    </div>
                </div>
              <?php
                 } 
              ?>
            </div>
          </div>
        </div>
      </div>
      
            <!-- Memberikan penawaran-->
      <div id="bid-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Masukkan Jumlah Penawaran Anda</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
            
              <form action="<?= base_url('home/bidder') ?>" method="post">
                <div class="form-group">
                  <input type="hidden" name="barang" value="<?= $this->uri->segment(4) ?>" >
                  <input type="hidden" name="kategori" value="<?= $this->uri->segment(3) ?>" >
                  <input type="hidden" name="id_kategori" value="<?= $record['id_kategori'] ?>" >
                  <input type="hidden" name="min_harga" value="<?= $record['harga_produk'] ?>" >
                  <input type="hidden" name="max_harga" value="<?= $record['max_harga'] ?>" >
                 
                  <input id="" type="number" name="harga" required="" placeholder="jumlah penawaran anda" class="form-control">
                </div>
                <p class="text-center">
                  <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Bid Now</button>
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan anda masukkan jumlah penawaran tertinggi anda</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Mebeli secara langsung -->
      <div id="bin-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Apakah anda akan membeli barang secara langsung?</h4>
              
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
            <p class="price">Harga Maksimal Sebesar Rp. <?= number_format($record['max_harga'],2,',','.') ?></p>
              <form action="<?= base_url('home/binner') ?>" method="post">
                <div class="form-group">
                  <input type="hidden" name="barang" value="<?= $this->uri->segment(4) ?>" >
                  <input type="hidden" name="kategori" value="<?= $this->uri->segment(3) ?>" >
                  <input type="hidden" name="id_kategori" value="<?= $record['id_kategori'] ?>" >
                  <input type="hidden" name="harga" value="<?= $record['max_harga'] ?>" >
                 
                  
                </div>
                <p class="text-center">
                  <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Bid Now</button>
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan anda masukkan jumlah penawaran tertinggi anda</p>
            </div>
          </div>
        </div>
      </div>

      <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Mohon Maaf</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form>
                <p class="text-center">
                  <a href="<?= base_url('home/register') ?>" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Login</a>
                  
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan anda login terlebih dahulu untuk mengikuti lelang ini<br> Terimakasih</p>
            </div>
          </div>
        </div>
      </div>

      <div id="deposit-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Mohon Maaf</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form>
                <p class="text-center">
                  <a href="<?= base_url('profile') ?>" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Deposit Now</a>
                  
                </p>
              </form>
              <p class="text-center text-muted"> Silahkan anda Deposit terlebih dahulu untuk mengikuti lelang ini<br> Terimakasih</p>
            </div>
          </div>
        </div>
      </div>

      <div id="soldout-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Mohon Maaf</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form>
                <p class="text-center">
                  <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-template-outlined"><i class="fa fa-check"></i> Sold Out</button>
                </p>
              </form>
              <p class="text-center text-muted"> Mohon maaf, Produk ini sudah laku terjual<br> Terimakasih</p>
            </div>
          </div>
        </div>
      </div>

      <div id="ready-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Mohon Maaf</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form>
                <p class="text-center">
                  <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-template-outlined"><i class="fa fa-check"></i> Cooming Soon</button>
                </p>
              </form>
              <p class="text-center text-muted"> Mohon maaf, Produk ini belum siap di lelang<br> Terimakasih</p>
            </div>
          </div>
        </div>
      </div>

      <div id="exp-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Mohon Maaf</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form>
                <p class="text-center">
                  <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-template-outlined"><i class="fa fa-check"></i> Lelang Selesai</button>
                </p>
              </form>
              <p class="text-center text-muted"> Mohon maaf, Produk ini sudah melebihi Waktu Lelang<br>apabila belum ada pemenang lelang, maka akan di lelang ulang<br> Terimakasih</p>
            </div>
          </div>
        </div>
      </div>