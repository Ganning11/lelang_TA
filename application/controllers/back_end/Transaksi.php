<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        //chekAksesModule();
        $this->load->model('M_barang');
        if($this->session->userdata('id_user') == '' OR $this->session->userdata('hak_akses') == 'bidder'){
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->template->load('template_back','dashboard/pelelang/data_transaksi_barang');
    }

    public function invoice()
    {
        $this->template->load('template_back','dashboard/pelelang/data_invoice');
    }

    public function form_view_detail(){
        $id_produk = $_GET['id_produk'];
        $sql    = "SELECT * FROM abe_lelang_bidder WHERE id_barang = '$id_produk' ORDER BY id_lelang_bidder DESC";
        $data   = $this->db->query($sql)->result();
        $data2  = $this->db->query($sql)->num_rows();
        //echo $data['detail'];
        echo "<div class='box-body'>
                <table class='table table-bordered'>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>Bidder</th>
                      <th>Jumlah Penawaran</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  ";
                    
                if($data2 == ''){
                    echo "<tr><td colspan='6'><center>Belum ada penawaran masuk</center></td></tr>";
                }else{
                    $no = 1;
                    foreach ($data as $row) {
                    $user = $row->id_bidder;
                    $user_bidder = "SELECT email, id FROM users WHERE id = '$user'";
                    $sql_user = $this->db->query($user_bidder)->row_array();
            echo "<tr>
                      <td>$no</td>
                      <td>".date('d M Y / H:i:s', strtotime($row->tanggal))."</td>
                      <td>".$sql_user['email']."</td>
                      <td>Rp. ".number_format($row->harga_lelang,2,',','.') ."</td>
                      <td><span class='badge badge-info'>".$row->status ."</span></td>";

                      if($row->status != 'pending'){
            echo "<td><a href='#' class='btn btn-xs btn-flat btn-info' title='pilih pemenang' ><i class='fa fa-check'></i> done</a></td>
                    </tr>
                    ";    
                      }else if($row->status == 'pemenang'){
            echo "<td><a href='".base_url('back_end/transaksi/pilih_pemenang/')."$row->id_lelang_bidder/$row->id_barang/$row->id_bidder/$row->harga_lelang' class='btn btn-xs btn-flat btn-success' title='pilih pemenang' ><i class='fa fa-check'></i> pilih</a></td>
                    </tr>
                    ";
                    }else{
                        echo "<td><a href='".base_url('back_end/transaksi/pilih_pemenang/')."$row->id_lelang_bidder/$row->id_barang/$row->id_bidder/$row->harga_lelang' class='btn btn-xs btn-flat btn-success' title='pilih pemenang' ><i class='fa fa-check'></i> pilih</a></td>
                                </tr>
                                ";
                                }
                    
                    $no ++;
                    }
                }
            echo "</tbody>
                </table>
            </div>
        ";
    }

    public function pilih_pemenang() 
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_transaksi   = $this->uri->segment(4);
        $id_produk      = $this->uri->segment(5);
        $id_user        = $this->uri->segment(6);
        $harga          = $this->uri->segment(7);
        $tgl_buat       = date('Y-m-d H:i:s');
        $random = $this->randomString();
        $no_inv = $this->get_no_invoice();
        $data = array(
            'status'        => 'pemenang',
        );

        $data2 = array(
            'status'        => 'kalah',
        );

        $data3 = array(
            'status'        => 'sold out',
            'harga_jual'    => $harga,
        );
        
        $data4 = array(
            'kode_unik'     => $random,
            'no_invoice'    => $no_inv,
            'id_produk'     => $id_produk,
            'status'        => 'belum bayar',
            'id_user'       => $id_user,
            'harga_produk'  => $harga,
            'id_transaksi'  => $id_transaksi,
            'tgl_buat'      => $tgl_buat,
        );
        //update data ke database

        

        $this->M_barang->update_kalah($data2, $id_produk);
                 $this->M_barang->update_pemenang($data, $id_transaksi);
                 $this->M_barang->update_transaksi($data3, $id_produk);
                $this->M_barang->add_invoice($data4);
        $this->session->set_flashdata('sukses','Data Produk berhasil di ubah<br>Terimakasih');
        redirect('back_end/transaksi');
    }

    function randomString($length = 3) {
        $str = "";
        $characters = range('0','9');
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str  .= $characters[$rand];
        }
        return $str;
    }

    function get_no_invoice()
    {
        $tahun = date("Y");
        //$array_bulan = array('01'=>"I",'02'=>"II",'03'=>"III",'04'=>"IV",'05'=>"V",'06'=>"VI",'07'=>"VII",'08'=>"VIII",'09'=>"IX",'10'=>"X",'11'=> "XI",'12'=>"XII");
        //$bulan = $array_bulan[date('m')];
        $bulan = date('m');
        $kode = 'INV';
        //$tahun2 = substr($tahun,-2);
        $query = $this->db->query("SELECT MAX(no_invoice) as max_id_inv FROM abe_invoice WHERE no_invoice LIKE '%$tahun'"); 
        $row = $query->row_array();
        $max_id = $row['max_id_inv']; 
        $max_id1 = substr($max_id,2,4);
        $no_invoice = $max_id1 + 1;
        $max_no_invoice = $kode.sprintf("%04s",$no_invoice).$bulan.$tahun ;
        return $max_no_invoice;
    }

    public function detail()
    {
        $this->load->view('dashboard/pelelang/invoice');
        //$this->template->load('template_front','profile_user/invoice_2');  
    }

}
