<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('M_produk','User','M_dashboard')); 
    }

    public function index()
    { 
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','profile_user/account');
        }
          
    }

    public function orders()
    {
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','profile_user/orders');
        }
    }

    public function payment()
    {
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','profile_user/payment');
        }
    }

    public function invoice()
    {
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','profile_user/invoice');
        }
    }

    public function rekomendasi()
    {
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','profile_user/rekomendasi');
        }
    }

    public function addrekomendasi()
    {
        $bidder      = $_GET['bidder'];
        $kategori   = $_GET['kategori'];
        $data       = array('bidder'=>$bidder,'kategori'=>$kategori);
        $chek       = $this->db->get_where('abe_rekomendasi',$data);
        if($chek->num_rows() < 1){
            $this->db->insert('abe_rekomendasi',$data);
        }else{
            $this->db->where('bidder',$bidder);
            $this->db->where('kategori',$kategori);
            $this->db->delete('abe_rekomendasi');
        }
    }

    public function chek_akses($bidder, $kategori)
    {
        $data       = array('bidder'=>$bidder,'kategori'=>$kategori);
        $chek       = $this->db->get_where('abe_rekomendasi',$data);
        if($chek->num_rows() > 0){
            echo " checked";
        }
    }

    public function pelelang()
    { 
        $this->template->load('template_front','profile_user/pelelang');  
    }

    public function pelelang_produk()
    { 
        $this->template->load('template_front','profile_user/pelelang_produk');  
    }

    public function pelelang_produk_laku()
    { 
        $this->template->load('template_front','profile_user/pelelang_produk_laku');  
    }

    public function update()
    {  
        $user       = $this->session->userdata('id');
        $password   = $this->input->post('password');
        if($password == ''){
            $data = array(
                'first_name'    => $this->input->post('firstname'),
                'last_name'     => $this->input->post('lastname'),
                'email'         => $this->input->post('email'),
                'gender'        => $this->input->post('gender'),
                'alamat'        => $this->input->post('alamat'),
                'telephone'     => $this->input->post('telephone'),
            );
        }else{
            $data = array(
                'first_name'    => $this->input->post('firstname'),
                'last_name'     => $this->input->post('lastname'),
                'email'         => $this->input->post('email'),
                'gender'        => $this->input->post('gender'),
                'alamat'        => $this->input->post('alamat'),
                'telephone'     => $this->input->post('telephone'),
                'password'      => MD5($password),
            );
        }
        

        if(!empty($_FILES['foto']['name']))
            {
                $upload = $this->_do_upload();
                $data['foto'] = $upload;
                //hapus foto sebelumnya
                $foto = $this->M_dashboard->id_foto($user);
                if(file_exists('assets/foto/'.$foto->foto) && $foto->foto)
                    unlink('assets/foto/'.$foto->foto);
                $this->M_dashboard->hapus_foto($data,$user);
            }

        $this->User->update($data, $user);
        $this->session->set_flashdata('sukses','Data User Berhasil Di update');
        redirect('profile');
    }

    private function _do_upload()
    {
        $config['upload_path']          = 'assets/foto';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 4000; //set max size allowed in Kilobyte
       // $config['max_width']            = 1000; // set max width image allowed
       // $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('foto')) //upload and validate
        {
            $data['inputerror'][] = 'foto';
            $data['error_string'][] = 'Upload error : '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    public function deposit()
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user       = $this->session->userdata('id');
        $tgl        = date('Y-m-d H:i:s');
        $jumlah     = $this->input->post('jumlah');
        if($jumlah >= '200000'){
            $data = array(
                'id_user'    => $user,
                'status'     => 'transfer',
                'jumlah'        => $jumlah,
                'bank_pengirim' => $this->input->post('bank_pengirim'),
                'nama_pengirim' => $this->input->post('nama_pengirim'),
                'nomor_rekening'=> $this->input->post('nomor_rekening'),
                'bank_penerima' => $this->input->post('bank_penerima'),
                'catatan'       => $this->input->post('catatan'),
                'tgl_deposit'   => $tgl,
            );

            if(!empty($_FILES['file_foto']['name']))
                {
                    $upload = $this->upload_transfer();
                    $data['file_foto'] = $upload;
                }

            $data2 = array(
                'status'     => 'aktif',
            );

            $this->User->update($data2, $user);
            $this->User->add_deposit($data);
            $this->session->set_flashdata('sukses','Data Deposit akan segera di proses Admin<br>Terimakasih');
            redirect('profile');
        }else{
            $this->session->set_flashdata('gagal','Mohon Maaf,, Data deposit anda tidak sesuai<br> Anda di wajibkan deposit 1 Juta Rupiah untuk mengikuti Lelang Ini <br> silahkan Deposit Ulang');
            redirect('profile');
        }
            
    }

    private function upload_transfer()
    {
        $config['upload_path']          = 'assets/foto_transfer';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 4000; //set max size allowed in Kilobyte
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('file_foto')) //upload and validate
        {
            $data['inputerror'][] = 'file_foto';
            $data['error_string'][] = 'Upload error : '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    public function bayar_invoice_deposit()
    {  
        date_default_timezone_set('Asia/Jakarta');
        $tgl        = date('Y-m-d H:i:s');
        $user       = $this->session->userdata('id');
        $id         = $this->input->post('id_invoice');
        $produk     = $this->input->post('produk');
        $id_deposit = $this->input->post('id_deposit');
        $deposit    = $this->input->post('nilai_deposit');
        $tagihan    = $this->input->post('tagihan');
        $sql_deposit = $this->db->query("SELECT * FROM abe_deposit WHERE id_deposit = '$id_deposit'")->row_array();

        $data2 = array(
            'status'     => 'bayar',
            'id_invoice' => $id,
            'id_produk'  => $produk,
        );
        $this->User->bayar_invoice_deposit($data2, $id_deposit);

        if($deposit > $tagihan){
            $selisih = $deposit - $tagihan ;
            $data3 = array(
                'id_user'       => $user,
                'status'        => 'oke',
                'jumlah'        => $selisih,
                'bank_pengirim' => $sql_deposit['bank_pengirim'],
                'nama_pengirim' => $sql_deposit['nama_pengirim'],
                'nomor_rekening'=> $sql_deposit['nomor_rekening'],
                'bank_penerima' => $sql_deposit['bank_penerima'],
                'catatan'       => $sql_deposit['catatan'],
                'tgl_deposit'   => $tgl,
                'file_foto'     => $sql_deposit['file_foto'],
                );
            $this->User->add_deposit($data3);
            $data = array(
                'deposit'       => $tagihan,
                'status'        => 'transfer',
                'jumlah_transfer' => $tagihan,
                'bank_pengirim' => $sql_deposit['bank_pengirim'],
                'nama_pengirim' => $sql_deposit['nama_pengirim'],
                'nomor_rekening'=> $sql_deposit['nomor_rekening'],
                'bank_penerima' => $sql_deposit['bank_penerima'],
                'catatan'       => 'bayar dari deposit',
                'ppn'           => $this->input->post('ppn'),
                'tgl_lunas'     => $tgl,
                );
            $this->User->bayar_invoice($data, $id);

            $this->session->set_flashdata('sukses','Data Pembayaran akan segera di proses Admin<br> dan akan di lanjutkan ke pihak pelelang<br>Terimakasih');
            redirect('profile/payment');
        }else{
            $data = array('deposit' => $deposit);
            $this->User->bayar_invoice($data, $id);

            $this->session->set_flashdata('sukses','Data Pembayaran anda menggunakan Deposit Berhasil Di proses <br> Silahkan lakukan Sisa Pembayaran<br>Terimakasih');
            redirect('profile/invoice/'.$produk);
        }
    }

    public function bayar_invoice()
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user       = $this->session->userdata('id');
        $tgl        = date('Y-m-d H:i:s');
        $total      = $this->input->post('total');
        $jumlah     = $this->input->post('jumlah');
        $id         = $this->input->post('id_invoice');
        $produk     = $this->input->post('produk');

        if($jumlah == $total){
            $data = array(
                'status'        => 'transfer',
                'jumlah_transfer' => $jumlah,
                'bank_pengirim' => $this->input->post('bank_pengirim'),
                'nama_pengirim' => $this->input->post('nama_pengirim'),
                'nomor_rekening'=> $this->input->post('nomor_rekening'),
                'bank_penerima' => $this->input->post('bank_penerima'),
                'catatan'       => $this->input->post('catatan'),
                'ppn'           => $this->input->post('ppn'),
                'tgl_lunas'     => $tgl,
            );

            if(!empty($_FILES['file_foto']['name']))
                {
                    $upload = $this->upload_transfer();
                    $data['file_foto'] = $upload;
                }

            $this->User->bayar_invoice($data, $id);
            //$this->User->add_deposit($data);
            $this->session->set_flashdata('sukses','Data Pembayaran akan segera di proses Admin<br> dan akan di lanjutkan ke pihak pelelang<br>Terimakasih');
            redirect('profile/payment');
        }else{
            $this->session->set_flashdata('gagal','Mohon Maaf Proses gagal <br> Pastikan nilai yang anda Transfer sesuai dengan tagihan<br>Terimakasih');
            redirect('profile/invoice/'.$produk);
        }
    }

    public function report()
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user       = $this->session->userdata('id');
        $tgl        = date('Y-m-d H:i:s');
        $kepuasan   = $this->input->post('kepuasan');
        $review     = $this->input->post('review');
        $produk     = $this->input->post('id_produk');
        $pelelang   = $this->input->post('id_pelelang');
        $kategori   = $this->input->post('id_kategori');

        $data = array(
            'user_input'=> $user,
            'kepuasan'  => $kepuasan,
            'review'    => $review,
            'produk'    => $produk,
            'pelelang'  => $pelelang,
            'tgl_input' => $tgl,
            'kategori_produk' => $kategori,
        );

        $this->User->add_review($data);
        $this->session->set_flashdata('sukses','Review Anda sudah terkirim<br> dan akan di tindak lanjuti pihak Admin<br>Untuk Kemajuan Aplikasi ini <br>Terimakasih');
        redirect('profile/pelelang_produk_laku/'.$pelelang);
    }
    public function logout(){
        //delete login status & user info from session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        
        //redirect to login page
        redirect('/home/'); 
    }

}
