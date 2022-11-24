  <?php
    $notif_deposit = $this->db->query("SELECT * FROM abe_deposit WHERE status = 'transfer'")->num_rows();
    $notif_invoice = $this->db->query("SELECT * FROM abe_invoice WHERE status = 'transfer'")->num_rows();
  ?>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url() ?>assets/foto/<?= $foto ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $this->session->userdata('nama_lengkap') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Aktif</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Pilih Menu</li>
        <?php
          $hak_akses = $this->session->userdata('hak_akses'); 
          if($hak_akses == 'administrator' OR $hak_akses == 'admin'){
        ?>
          <!-- <li>
            <a href="<?= base_url('dashboard') ?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li> -->
          <li>
            <a href="<?= base_url('back_end/admin') ?>">
              <i class="fa fa-user"></i> <span>Data Admin</span>
            </a>
          </li>
          <!-- <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Data Pelelang</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('back_end/users/pelelang_baru') ?>"><i class="fa fa-circle-o"></i> Pelelang Baru</a></li>
              <li><a href="<?= base_url('back_end/users/pelelang_aktif') ?>"><i class="fa fa-circle-o"></i> Pelelang Aktif</a></li>
              <li><a href="<?= base_url('back_end/users/pelelang_blokir') ?>"><i class="fa fa-circle-o"></i> Pelelang Blokir</a></li>
            </ul> -->
          </li> 
          <li class="treeview">
            <a href="#">
              <i class="fa fa-cubes"></i>
              <span>Data Barang</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('back_end/barang/admin_baru') ?>"><i class="fa fa-circle-o"></i> Barang Coming soon </a></li>
              <li><a href="<?= base_url('back_end/barang/admin_aktif') ?>"><i class="fa fa-circle-o"></i> Produk Yang Sedang dilelang</a></li>
              <li><a href="<?= base_url('back_end/barang/admin_laku') ?>"><i class="fa fa-circle-o"></i> Produk Laku</a></li>
            </ul>
          </li>
          <li>
            <a href="<?= base_url('back_end/deposit') ?>">
              <i class="fa fa-money"></i> <span>Data Deposit</span>
              <?php
                if($notif_deposit == '0'){
                  echo "";
                }else{
              ?>
                <span class="pull-right-container">
                  <span class="label label-danger pull-right"><?= $notif_deposit ?></span>
                </span>
              <?php
                }
              ?>               
            </a>
          </li>
          <li>
            <a href="<?= base_url('back_end/deposit/invoice') ?>">
              <i class="fa fa-money"></i> <span>Konfirmasi Data Invoice</span>
              <?php
                if($notif_invoice == '0'){
                  echo "";
                }else{
              ?>
                <span class="pull-right-container">
                  <span class="label label-danger pull-right"><?= $notif_invoice ?></span>
                </span>
              <?php
                }
              ?> 
            </a>
          </li>
          <!-- <li>
            <a href="<?= base_url('back_end/users/review') ?>">
              <i class="fa fa-users"></i> <span>Data Review Bidder</span>
            </a>
          </li> -->
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Data User</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('back_end/users/bidder_aktif') ?>"><i class="fa fa-circle-o"></i> User Aktif</a></li>
              <li><a href="<?= base_url('back_end/users/bidder_blokir') ?>"><i class="fa fa-circle-o"></i> User Blokir</a></li>
            </ul>
          </li>
          <!-- <li class="treeview">
            <a href="#">
              <i class="fa fa-cogs"></i>
              <span>Data Minat Bidder</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('back_end/users/kategori_klik') ?>"><i class="fa fa-circle-o"></i> Bidder Kategori Klik</a></li>
              <li><a href="<?= base_url('back_end/users/kategori_bid') ?>"><i class="fa fa-circle-o"></i> Bidder Kategori Bid</a></li>
            </ul>
          </li> -->
        <?php
          }else if($hak_akses == 'pelelang'){
        ?>
          
          <li>
            <a href="<?= base_url('back_end/barang') ?>">
              <i class="fa fa-cubes"></i> <span>Data Barang</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('back_end/transaksi') ?>">
              <i class="fa fa-gift"></i> <span>Data Transaksi</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('back_end/transaksi/invoice') ?>">
              <i class="fa fa-money"></i> <span>Data Invoice</span>
            </a>
          </li>
        <?php
          }else{
        ?>


        <?php
          }
        ?>

        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>