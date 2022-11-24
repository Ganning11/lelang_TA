      
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">Category <?= $this->uri->segment(3) ?></h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Category <?= $this->uri->segment(3) ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar">
            <div class="col-md-12">
              <p class="text-muted lead text-center"></p>
              <div class="products-big">
                <div class="row products">
                  <?php
                    $uri          = $this->uri->segment(3);
                    $sql_kategori = $this->db->query("SELECT * FROM abe_kategori WHERE url_kategori = '$uri'")->row_array();
                    $kategori     = $sql_kategori['id_kategori']; 
                    $sql    = "SELECT * FROM abe_produk WHERE id_kategori = '$kategori' ORDER BY rand() LIMIT 12";
                    $produk = $this->db->query($sql)->result();
                    foreach ($produk as $row) {
                      $id_kategori  = $row->id_kategori;
                      $id_produk    = $row->id_produk;
                      //$kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                      $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
                  ?>
                    <div class="col-lg-3 col-md-4">
                      <div class="product">
                        <div class="image"><a href="<?= base_url('home/produk/').$uri.'/'.$id_produk ?>"><img src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" alt="" class="img-fluid image1"></a>
                        </div>
                        <div class="text">
                          <?php
                            if ($row->tgl_tutup == '0000-00-00'){
                          ?>
                            <button type="button" class="btn btn-warning">Cooming Soon</button>
                          <?php
                            }else{
                          ?>
                            <button type="button" class="btn btn-warning">Exp. <?= date('d F Y', strtotime($row->tgl_tutup)) ?></button>
                          <?php
                            }
                          ?>
                          
                          <h3 class="h5"><a href="<?= base_url('home/produk/').$uri.'/'.$id_produk ?>"><?= $row->nama_produk ?></a></h3>
                          <p class="price">
                            Rp. <?= number_format($row->harga_produk,2,',','.') ?>
                          </p>
                        </div>
                        <?php
                          if($row->status == 'sold out'){
                        ?>
                          <div class="ribbon-holder">
                            <div class="ribbon new">soldout</div>
                          </div>
                        <?php
                          }else if($row->status == 'lelang'){
                        ?>
                          <div class="ribbon-holder">
                            <div class="ribbon sale">bid now</div>
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
            </div>
          </div>
        </div>
        <div class="container">
          <div class="col-md-12">
            <div class="heading text-center">
              <h2>Join To BID !</h2>
            </div>
            <div class="row text-center">
              <?php
                $sql    = "SELECT ap.*, alb.* FROM abe_produk as ap, abe_lelang_bidder as alb WHERE ap.status = 'lelang' AND ap.id_produk = alb.id_barang GROUP BY alb.id_barang  ORDER BY rand() LIMIT 8 ";
                $produk = $this->db->query($sql)->result();
                foreach ($produk as $row) {
                  $id_kategori  = $row->id_kategori;
                  $id_produk    = $row->id_produk;
                  $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                  $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
                  $bidder = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$id_produk'")->num_rows();
              ?>
                <div class="col-md-3">
                  <div data-animate="fadeInUp" class="team-member">
                    <div class="image">
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>">
                      <img width="200" height="200" class="img-circle" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" ></a>
                    </div>
                    <h3><a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>"><?= $row->nama_produk ?></a></h3>
                    <p class="role"><?= $kategori['nama_kategori'] ?></p>
                    <div class="text">
                      <p><strong> Rp. <?= number_format($row->harga_produk,2,',','.') ?> </strong></p>
                    </div>
                    <div class="ribbon-holder">
                      <div class="ribbon new"><?= $bidder ?> Penawaran</div>
                    </div>
                    <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Berikan Penawaran Sekarang!</a>
                    
                  </div>
                </div>

              <?php
                 } 
              ?>

            </div>
          </div>
        </div>
      </div>
