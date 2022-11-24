<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('M_produk','M_barang','User','M_dashboard')); 
        
    }

    public function index()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','home/home',$data);  
    }

    public function about()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','home/about',$data);  
    }

    public function kontak()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','home/kontak',$data);  
    }

    public function rekomendasi()
    {
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','home/rekomendasi');
        }
    }

    public function kategori()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','produk/kategori',$data);  
    }

    public function produk()
    {
        $bidder = $this->session->userdata('id');
        $id             = $this->uri->segment(4);
        $url_kategori   = $this->uri->segment(3);
        $user           = $this->session->userdata('id');
        $data['loginURL'] = $this->google->loginURL();
        $data['record'] = $this->M_produk->detail_produk($id)->row_array();
        if($bidder != ''){
            //untuk menambahkan jumlah barang yang di klik
            $sql_kategori = $this->db->query("SELECT * FROM abe_kategori where url_kategori = '$url_kategori'")->row_array();
            $id_kategori = $sql_kategori['id_kategori'];
            //menambah klik
            $query = $this->db->query("SELECT MAX(jumlah_klik) as max_klik, id_kategori_klik FROM abe_kategori_klik WHERE id_bidder = '$user' AND id_kategori = '$id_kategori'")->row_array();
            $query2 =  $this->db->query("SELECT * FROM abe_kategori_klik WHERE id_bidder = '$user' AND id_kategori = '$id_kategori'")->num_rows();
            $max_id     = $query['max_klik'];
            $id_klik    = $query['id_kategori_klik'];
            //$max_id1 = substr($max_id,-4);
            $jumlah = $max_id + 1;

            $data2 = array(
                'id_bidder'     => $user,
                'id_kategori'   => $id_kategori,
                'jumlah_klik'   => $jumlah,
                'url_kategori'  => $url_kategori,
            );
            $data3 = array(
                'jumlah_klik'   => $jumlah
            );
            if($query2 == '1'){
                $this->M_produk->update_klik(array('id_kategori_klik' => $id_klik), $data3);
            }else{
                $this->M_produk->add_klik($data2);
            }
        }
        $this->template->load('template_front','produk/detail', $data); 
    }
    
    public function register(){
        //redirect to profile page if user already logged in
        if($this->session->userdata('loggedIn') == true){
            redirect('home');
        }
        
        if(isset($_GET['code'])){
            //authenticate user
            $this->google->getAuthenticate();
            
            //get user info from google
            $gpInfo = $this->google->getUserInfo();
            
            //preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid']      = $gpInfo['id'];
            $userData['first_name']     = $gpInfo['given_name'];
            $userData['last_name']      = $gpInfo['family_name'];
            $userData['email']          = $gpInfo['email'];
            //$userData['gender']         = !empty($gpInfo['gender'])?$gpInfo['gender']:'';
            $userData['locale']         = !empty($gpInfo['locale'])?$gpInfo['locale']:'';
            $userData['profile_url']    = !empty($gpInfo['link'])?$gpInfo['link']:'';
            $userData['picture_url']    = !empty($gpInfo['picture'])?$gpInfo['picture']:'';
            
            //insert or update user data to the database
            $userID = $this->User->checkUser($userData);
            
            //store status & user info in session
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('userData', $userData);

            //membuat session di luar google
            $email = $userData['email'];
            $oauth_uid = $userData['oauth_uid'];
            $result = $this->User->cekLogin($email, $oauth_uid);
            $this->session->set_userdata($result);
            //redirect to profile page
            redirect('home');
        } 
        
        //google login url
        $data['loginURL'] = $this->google->loginURL();
        
        //load google login view
        $this->template->load('template_front','home/register',$data);
    }

    public function daftar()
    {
        $this->template->load('template_front','home/daftar');      
    }

    public function daftar_user(){

        $first_name       = $this->input->post('first_name');
        $last_name       = $this->input->post('last_name');
        $password   = ($this->input->post('password'));
        $email      = $this->input->post('email');
        $alamat      = $this->input->post('alamat');
        $no_hp      = $this->input->post('no_hp');
        $gender      = $this->input->post('gender');
        $date       = date('Y:m:d');
        $cek_email = $this->User->email($email);
        if ($cek_email > 0){
            echo "<div id='gagal' class='alert alert-danger'>Mohon maaf Email anda sudah terdaftar<button type='button' class='close' data-dismiss='alert'><i class='fa fa-times'></i></button></div>";
            $this->session->set_flashdata('gagal','Mohon maaf<br>Email anda sudah terdaftar<br>mohon periksa kembali email anda<br>terimakasih');
            redirect('home/register');
         
        }else {            
            //memasukan ke array
            $data = array(
                'first_name'=> $first_name,
                'last_name'=> $last_name,
                'password'  => $password,
                'gender'     => $gender,
                'email'     => $email,
                'alamat'     => $alamat,
                'telephone'     => $no_hp,
                'status'    => 'aktif',
                'created'=> $date,
                'foto'      => 'user.png',
            );
            //tambahkan akun ke database
            $id = $this->User->daftar_member($data);
            echo "<div id='success' class='alert alert-primary'>Mohon maaf Email anda sudah terdaftar<button type='button' class='close' data-dismiss='alert'><i class='fa fa-times'></i></button></div>";
            $this->session->set_flashdata('success','Terima Kasih<br>Sudah mendaftar<br>Silahkan login menggunakan akun yang sudah didaftarkan<br>terimakasih');
            redirect('home/register');

            
            
        }
    }


    public function login()
    {
        $email = $this->input->post('email');
        $password = ($this->input->post('password'));
        // untuk enkripsi
        // $password = MD5($this->input->post('password'));
        
        $result = $this->User->cekLogin2($email, $password);
        if ($result == 0) {
            $this->session->set_flashdata('gagal','username / password anda salah');
            redirect('home/register');            
        }else{
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata($result);
            //$this->session->set_flashdata('berhasil','Terimakasih');
            redirect('home');
        }
    }

    public function logout(){
        //delete login status & user info from session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        
        //redirect to login page
        redirect('/home/'); 
    }

    public function bidder()
    {
        date_default_timezone_set('Asia/Jakarta');
        $harga      = $this->input->post('harga');
        $id_barang  = $this->input->post('barang');
        $kategori   = $this->input->post('kategori');
        $id_kategori= $this->input->post('id_kategori');
        $user       = $this->session->userdata('id');
        $status     = 'pending';
        $date       = date('Y-m-d H:i:s');
        $min_harga      = $this->input->post('min_harga');
        $max_harga  = $this->input->post('max_harga');
        
        $data2 = array(
            'harga_produk'  => $harga,
        );

        if($harga > $min_harga && $harga < $max_harga ){
            $data = array(
                'id_barang' => $id_barang,
                'id_bidder' => $user,
                'id_kategori' => $id_kategori,
                'harga_lelang' => $harga,
                'status'    => $status,
                'tanggal'   => $date,
            );

            $data2 = array(
                'harga_produk'  => $harga,
            );
            
            
            $this->M_produk->update_barang($data2, $id_barang);
            //tambahkan akun ke database
            $this->M_produk->add_penawaran($data);

            $this->session->set_flashdata('sukses','Penawaran Anda berhasil di tambahkan<br>Terimakasih');
            redirect('home/produk/'.$kategori.'/'.$id_barang);
        }elseif($harga == $max_harga){
            date_default_timezone_set('Asia/Jakarta');
            $harga      = $this->input->post('harga');
            $id_barang  = $this->input->post('barang');
            $kategori   = $this->input->post('kategori');
            $id_kategori= $this->input->post('id_kategori');
            $user       = $this->session->userdata('id');
            $status     = 'pending';
            $date       = date('Y-m-d H:i:s');
    
            
            
    
            $data = array(
                'id_barang' => $id_barang,
                'id_bidder' => $user,
                'id_kategori' => $id_kategori,
                'harga_lelang' => $harga,
                'status'    => $status,
                'tanggal'   => $date,
            );

            $data2 = array(
                'harga_produk'  => $harga,
            );
            
            
            $this->M_produk->update_barang($data2, $id_barang);
            //tambahkan akun ke database
            $this->M_produk->add_penawaran($data);
            $this->session->set_flashdata('sukses','Penawaran Anda berhasil di tambahkan<br>Terimakasih');
            
    
            date_default_timezone_set('Asia/Jakarta');
            $id_transaksi   = 100;
            $id_produk      = $id_barang;
            $id_user        = $user;
            $harga          = $harga;
            $tgl_buat       = date('Y-m-d H:i:s');
            $random = 433;
            $no_inv = $this->get_no_invoice();
            $data = array(
                'status'        => 'pemenang',
            );
    
            $data2 = array(
                'status'        => 'Terbeli Secara Langsung',
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
            $this->session->set_flashdata('sukses','Anda memenangkan lelang dengan membeli menggunakan harga maksimal<br>Terimakasih');
            redirect('profile/invoice/'.$id_produk);
        }else{
            $this->session->set_flashdata('gagal','Maaf harga yang anda tawarkan teralu rendah<br>Terimakasih');
            redirect('home/produk/'.$kategori.'/'.$id_barang);
        }
        
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

    public function binner()
    {
        date_default_timezone_set('Asia/Jakarta');
        $harga      = $this->input->post('harga');
        $id_barang  = $this->input->post('barang');
        $kategori   = $this->input->post('kategori');
        $id_kategori= $this->input->post('id_kategori');
        $user       = $this->session->userdata('id');
        $status     = 'pending';
        $date       = date('Y-m-d H:i:s');

        
        

        $data = array(
            'id_barang' => $id_barang,
            'id_bidder' => $user,
            'id_kategori' => $id_kategori,
            'harga_lelang' => $harga,
            'status'    => $status,
            'tanggal'   => $date,
        );
        //tambahkan akun ke database
        $this->M_produk->add_penawaran($data);
        $this->session->set_flashdata('sukses','Penawaran Anda berhasil di tambahkan<br>Terimakasih');
        

        date_default_timezone_set('Asia/Jakarta');
        $id_transaksi   = 100;
        $id_produk      = $id_barang;
        $id_user        = $user;
        $harga          = $harga;
        $tgl_buat       = date('Y-m-d H:i:s');
        $random = 433;
        $no_inv = $this->get_no_invoice();
        $data = array(
            'status'        => 'pemenang',
        );

        $data2 = array(
            'status'        => 'Terbeli Secara Langsung',
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
        $this->session->set_flashdata('sukses','Anda memenangkan lelang dengan membeli menggunakan harga maksimal<br>Terimakasih');
        redirect('profile/invoice/'.$id_produk);


        
        
        

    }











}
