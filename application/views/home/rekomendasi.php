      
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">Rekomendasi <?= $this->uri->segment(3) ?></h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Rekomendasi <?= $this->uri->segment(3) ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar">
            <div class="col-md-12">
              <p class="text-muted lead text-center">Rekomendasi berdasarkan kesukaan kamu</p>
              <div class="products-big">
                <div class="row products">
                  <?php
                    $id_user  = $this->session->userdata('id');
                    $kategori = $this->db->query("SELECT ar.*, ap.*, ak.* FROM abe_rekomendasi as ar, abe_produk as ap, abe_kategori as ak WHERE ar.bidder = '$id_user' AND ar.kategori = ap.id_kategori AND ar.kategori = ak.id_kategori AND ap.status = 'lelang' ORDER BY rand() LIMIT 12 ")->result();
                    foreach ($kategori as $row) {
                      $id_kategori  = $row->kategori;
                      $id_produk    = $row->id_produk;
                      $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
                  ?>
                    <div class="col-lg-3 col-md-4">
                      <div class="product">
                        <div class="image"><a href="<?= base_url('home/produk/').$row->url_kategori.'/'.$id_produk ?>"><img src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" alt="" class="img-fluid image1"></a>
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
                          <h3 class="h5"><a href="<?= base_url('home/produk/').$row->url_kategori.'/'.$id_produk ?>"><?= $row->nama_produk ?></a></h3>
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
      </div>
