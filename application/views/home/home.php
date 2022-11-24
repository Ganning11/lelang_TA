      <section style="background: url('<?= base_url('assets/front_end/') ?>img/photogrid.jpg') center center repeat; background-size: cover;" class="relative-positioned">
        <!-- Carousel Start-->
        <div class="home-carousel">
          <div class="dark-mask mask-primary"></div>
          <div class="container">
            <div class="homepage owl-carousel">
              <div class="item">
                <div class="row">
                  <div class="col-md-12 text-center">
                    
                    <h1>Selamat Datang</h1>
                    <h1>di</h1>
                    <h1>Sistem Informasi Lelang Barang Berbasis Web</h1>
                    <p><br>Solusi mencari barang termurah</p>
                    <!-- <p><img src="<?= base_url('assets/front_end/') ?>img/logo_home.png" alt="" class="ml-auto"></p> -->
                  </div>
                  
                </div>
              </div>
              <!-- <div class="item">
                <div class="row">
                  <div class="col-md-7 text-center"><img src="<?= base_url('assets/front_end/') ?>img/template-mac.png" alt="" class="img-fluid"></div>
                  <div class="col-md-5">
                    <h2>46 HTML pages full of features</h2>
                    <ul class="list-unstyled">
                      <li>Sliders and carousels</li>
                      <li>4 Header variations</li>
                      <li>Google maps, Forms, Megamenu, CSS3 Animations and much more</li>
                      <li>+ 11 extra pages showing template features</li>
                    </ul>
                  </div>
                </div>
              </div> -->
              <!-- <div class="item">
                <div class="row">
                  <div class="col-md-5 text-right">
                    <h1>Design</h1>
                    <ul class="list-unstyled">
                      <li>Clean and elegant design</li>
                      <li>Full width and boxed mode</li>
                      <li>Easily readable Roboto font and awesome icons</li>
                      <li>7 preprepared colour variations</li>
                    </ul>
                  </div>
                  <div class="col-md-7"><img src="<?= base_url('assets/front_end/') ?>img/template-easy-customize.png" alt="" class="img-fluid"></div>
                </div>
              </div> -->
              <!-- <div class="item">
                <div class="row">
                  <div class="col-md-7"><img src="<?= base_url('assets/front_end/') ?>img/template-easy-code.png" alt="" class="img-fluid"></div>
                  <div class="col-md-5">
                    <h1>Easy to customize</h1>
                    <ul class="list-unstyled">
                      <li>7 preprepared colour variations.</li>
                      <li>Easily to change fonts</li>
                    </ul>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <!-- Carousel End-->
      </section>
      <section class="bar no-mb">
        <div class="container">
          <div class="col-md-12">
            <div class="heading text-center">
              <h2>Produk Lelang</h2>
            </div>
            <div class="row text-center">
              <?php
                $sql    = "SELECT * FROM abe_produk WHERE status = 'lelang' ORDER BY rand() LIMIT 8";
                $produk = $this->db->query($sql)->result();
                foreach ($produk as $row) {
                  $id_kategori  = $row->id_kategori;
                  $id_produk    = $row->id_produk;
                  $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                  $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
              ?>
                <div class="col-md-3">
                  <div data-animate="fadeInUp" class="team-member">
                    <div class="image">
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>">
                      <img width="200" height="200" class="rounded" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" ></a>
                    </div>
                    <h3><a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>"><?= $row->nama_produk ?></a></h3>
                    <p class="role"><?= $kategori['nama_kategori'] ?></p>
                    <div class="text">
                      <p><strong> Rp. <?= number_format($row->harga_produk,2,',','.') ?> </strong></p>
                    </div>
                    <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Bid Now</a>
                    
                  </div>
                </div>

              <?php
                 } 
              ?>

            </div>
          </div>
        </div>

        <?php
          if($this->session->userdata('id') == ''){
            echo "";
          }else{
        ?>
          <div class="container">
            <div class="col-md-12">
              <div class="heading text-center">
                <h2>Mungkin Kamu Suka</h2>
              </div>
              <div class="row text-center">
                <?php
                  $user   = $this->session->userdata('id');
                  $query  = $this->db->query("SELECT MAX(jumlah_klik) as max_klik, id_kategori FROM abe_kategori_klik WHERE id_bidder = '$user'")->row_array(); 
                  $kategori_klik = $query['id_kategori']; 

                  $sql    = "SELECT * FROM abe_produk WHERE status = 'lelang' AND id_kategori = '$kategori_klik' ORDER BY rand() LIMIT 8 ";
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
                        <div class="ribbon new"><?= $bidder ?> bid</div>
                      </div>
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Bid Now</a>
                      
                    </div>
                  </div>
                <?php
                   } 
                ?>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="col-md-12">
              <div class="heading text-center">
                <h2>Rekomendasi</h2>
              </div>
              <div class="row text-center">
                <?php
                  $user   = $this->session->userdata('id');
                  $query2  = $this->db->query("SELECT id_kategori, count(id_kategori) AS jumlah FROM abe_lelang_bidder WHERE id_bidder = '$user' group by id_kategori ORDER BY jumlah DESC limit 1")->row_array(); 
                  $kategori_bid = $query2['id_kategori']; 

                  $sql2    = "SELECT * FROM abe_produk WHERE status = 'lelang' AND id_kategori = '$kategori_bid' ORDER BY rand() LIMIT 8 ";
                  $produk2 = $this->db->query($sql2)->result();
                  foreach ($produk2 as $row) {
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
                        <div class="ribbon new"><?= $bidder ?> bid</div>
                      </div>
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Bid Now</a>
                      
                    </div>
                  </div>
                <?php
                   } 
                ?>
              </div>
            </div>
          </div>
        <?php
          }
        ?>


      </section>
      <section class="bar no-mb">
        <div data-animate="fadeInUp" class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="heading text-center">
                <h3>Kategori</h3>
              </div>
              <div class="row portfolio text-center no-space">
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/elektronik.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/elektronik') ?>" class="color-white">Elektronik</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Barang elektronik rumah tangga</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/elektronik') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/laptop.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/komputer_laptop') ?>" class="color-white">Komputer & Laptop</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Kebutuhan komputer dan laptop beserta aksesoris</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/komputer_laptop') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/mobile.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/gadget') ?>" class="color-white">Gadget</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Handphone beserta akesoris</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/gadget') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/console.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/gaming') ?>" class="color-white">Gaming</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Konsol permainan beserta game dan aksesoris</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/gaming') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/koleksi.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/koleksi') ?>" class="color-white">Mainan Koleksi</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Mainan koleksi yang bisa dipajang dan disimpan</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/koleksi') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/camera.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/camera') ?>" class="color-white">Camera</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">kamera dan aksesoris</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/camera') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>