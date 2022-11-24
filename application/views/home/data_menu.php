      <?php
        $uri = $this->uri->segment(2);
      ?>
      <!-- Navbar Start-->
      <header class="nav-holder make-sticky">
        <div id="navbar" role="navigation" class="navbar navbar-expand-lg">
          <div class="container">
            <a href=<?= base_url() ?> class="navbar-brand home">
              <img src="<?= base_url('assets/front_end/') ?>img/logo.png" alt="Universal logo" class="d-none d-md-inline-block">
              <img src="<?= base_url('assets/front_end/') ?>img/logo-small.png" alt="Universal logo" class="d-inline-block d-md-none">
              <span class="sr-only">Universal - go to homepage</span>
            </a>
            <button type="button" data-toggle="collapse" data-target="#navigation" class="navbar-toggler btn-template-outlined">
              <span class="sr-only">Toggle navigation</span><i class="fa fa-align-justify"></i></button>
            <div id="navigation" class="navbar-collapse collapse">
              <ul class="nav navbar-nav ml-auto">
                <li <?php if($uri == ''){ echo "class='nav-item active'";}else{echo "class='nav-item'";} ?>><a href="<?= base_url() ?>"><b><i class="fa fa-home"></i> Menu Utama</b></a>
                </li>
                
                <li <?php if($uri == 'about'){ echo "class='nav-item active'";}else{echo "class='nav-item'";} ?>><a href="<?= base_url('home/about') ?>"><b><i class=""></i> Cara Lelang</b></a>
                </li>
                <?php 
                  if ($this->session->userdata('id') == ''){
                    echo "";
                  }else{
                ?>
                <li <?php if($uri == 'rekomendasi'){ echo "class='nav-item active'";}else{echo "class='nav-item'";} ?>><a href="<?= base_url('home/rekomendasi') ?>"><b><i class="fa fa-  -o"></i> Produk Rekomendasi</b></a>
                </li>
                <?php
                  }
                ?>

                <!-- <li <?php if($uri == 'kategori'){ echo "class='nav-item dropdown menu-large active'";}else{echo "class='nnav-item dropdown menu-large'";} ?> ><a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bars"></i> Kategori<b class="caret"></b></a>
                  <ul class="dropdown-menu megamenu">
                    <li>
                      <div class="row">
                        <div class="col-lg-6"><img src="<?= base_url('assets/front_end/') ?>img/Hands_Bid.png" alt="" class="img-fluid d-none d-lg-block"></div>
                        <div class="col-lg-6 col-md-6">
                          <h5>Category List</h5>
                          <ul class="list-unstyled mb-3">
                            <?php
                              $kategori   = $this->db->query("SELECT * FROM abe_kategori")->result();
                              foreach ($kategori as $ka) {
                                $nama_kategori = $ka->nama_kategori;
                                //$url           = str_replace(' ', '', $nama_kategori);
                                $url    = $ka->url_kategori;
                            ?>
                              <li class="nav-item"><a href="<?= base_url('home/')."kategori/".$url ?>" class="nav-link"><?= $nama_kategori ?></a></li>
                            <?php
                              }
                            ?>
                          </ul>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li> -->
                <!--<li <?php if($uri == 'kontak'){ echo "class='nav-item active'";}else{echo "class='nav-item'";} ?>><a href="<?= base_url('home/kontak') ?>"><b><i class="fa fa-comments-o"></i> Hubungi Kami</b></a>
                </li>-->
              </ul>
            </div>
            <div id="search" class="collapse clearfix">
              <form role="search" class="navbar-form">
                <div class="input-group">
                  <input type="text" placeholder="Search" class="form-control"><span class="input-group-btn">
                    <button type="submit" class="btn btn-template-main"><i class="fa fa-search"></i></button></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </header>
      <!-- Navbar End-->