<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('M_dashboard')); 
    }

    public function index()
    {
        $x = $this->session->userdata('id_user');
        if(isset($x)){
            //echo "sukses masuk";
            $this->template->load('template_back','dashboard/home');
        }else{
            $this->load->view('dashboard/login');  
        }
    }

    public function admin()
    {
        $x = $this->session->userdata('id_user');
        if(isset($x)){
            //echo "sukses masuk";
            $this->template->load('template_back','dashboard/home');
        }else{
            $this->load->view('dashboard/admin/login_admin');  
        }
    }

    public function daftar()
    {
        $this->load->view('dashboard/daftar');      
    }

    public function proses_daftar()
    {
        $nama       = $this->input->post('nama');
        $password   = ($this->input->post('password'));
        $email      = $this->input->post('email');
        $date       = date('Y:m:d');
        $cek_email = $this->M_dashboard->email($email);
        if ($cek_email > 0){
            echo "<div id='gagal' class='alert alert-danger'>Mohon maaf Email anda sudah terdaftar<button type='button' class='close' data-dismiss='alert'><i class='fa fa-times'></i></button></div>";
            $this->session->set_flashdata('gagal','Mohon maaf<br>Email anda sudah terdaftar<br>mohon periksa kembali email anda<br>terimakasih');
            redirect('dashboard/daftar');
         
        }else {            
            //memasukan ke array
            $data = array(
                'nama_lengkap'=> $nama,
                'password'  => $password,
                'email'     => $email,
                'status'    => 'aktif',
                'tgl_daftar'=> $date,
                'hak_akses' => 'pelelang',
                'foto'      => 'user.png',
            );
            //tambahkan akun ke database
            $id = $this->M_dashboard->daftar_member($data);

            redirect('dashboard');
            //enkripsi id untuk validasi akun via email
            // $encrypted_id = md5($id);
            
            // //$this->load->library('email');
            // $config = array();
            // $config['charset'] = 'utf-8';
            // $config['useragent'] = 'Codeigniter';
            // $config['protocol']= "smtp";
            // $config['mailtype']= "html";
            // $config['smtp_host']= "fgsgroup.com";//pengaturan smtp
            // $config['smtp_port']= "587";
            // $config['smtp_timeout']= "400";
            // $config['smtp_user']= "agus@fgsgroup.com"; // isi dengan email kamu
            // $config['smtp_pass']= "Gkbi123.agus"; // isi dengan password kamu
            // $config['crlf']="\r\n"; 
            // $config['newline']="\r\n"; 
            // $config['wordwrap'] = TRUE;
            // //memanggil library email dan set konfigurasi untuk pengiriman email
                
            // $this->email->initialize($config);
            // //konfigurasi pengiriman
            // $this->email->from($config['smtp_user']);
            // $this->email->to($email);
            // $this->email->subject("Verifikasi Akun");
            // $this->email->message(
            //     "<h1>E-Auction</h1> Terimakasih telah melakuan registrasi, untuk memverifikasi akun anda silahkan klik tautan dibawah ini<br><br>".
            //     site_url("dashboard/verification/$encrypted_id")
            // );
            
            // if($this->email->send())
            // {
            //     $this->session->set_flashdata('success','Registrasi Berhasil<br>silahkan cek email anda<br>untuk mengaktifkan Akun<br>Terimakasih');
            //     redirect('dashboard');
            // }else
            {
                //echo "Berhasil melakukan registrasi, namu gagal mengirim verifikasi email";
                show_error($this->email->print_debugger());
                //$this->session->set_flashdata('gagal','Berhasil melakukan registrasi<br>namun gagal mengirim verifikasi email');
                //redirect('home/daftar');
            }
        } 
    }

    public function verification($key)
    {
        $this->M_dashboard->verifikasi($key);
        $this->session->set_flashdata('success','Selamat akun anda berhasil diaktifkan<br>Silahkan Login<br>Terimakasih');
        redirect('dashboard');
    }

    public function proses_login()
    {
        $email = $this->input->post('email');
        $password = ($this->input->post('password'));
        
        $result = $this->M_dashboard->cekLogin($email, $password);
        $result2 = $this->M_dashboard->cekLogin2($email, $password);
        if ($result == 0) {
            $this->session->set_flashdata('gagal','username / password anda salah');
            redirect('dashboard');            
        } elseif($result2 == 0) {
            $this->session->set_flashdata('gagal','Mohon maaf<br>akun anda belum aktif<br>periksa email & aktifkan akun anda');
            redirect('dashboard');
        }else{
            $this->session->set_userdata($result);
            //$this->session->set_flashdata('berhasil','Terimakasih');
            redirect('dashboard');
        }
    }

    public function proses_login_admin()
    {
        $email = $this->input->post('email');
        $password = ($this->input->post('password'));
        
        $result = $this->M_dashboard->cekLogin_admin($email, $password);
        $result2 = $this->M_dashboard->cekLogin2_admin($email, $password);
        if ($result == 0) {
            $this->session->set_flashdata('gagal','username / password anda salah');
            redirect('dashboard/admin');            
        } elseif($result2 == 0) {
            $this->session->set_flashdata('gagal','Mohon maaf<br>akun anda sudah di nonaktifkan');
            redirect('dashboard/admin');
        }else{
            $this->session->set_userdata($result);
            //$this->session->set_flashdata('berhasil','Terimakasih');
            redirect('dashboard');
        }
    }

    public function forgot()
    {
        $this->load->view('dashboard/forgot'); 
    }

    public function proses_forgot()
    {
        $email               = $this->input->post('email');
        $sess_email['email'] = $email;
        $this->session->set_userdata($sess_email);
        $cek_email = $this->M_dashboard->email($email);
        if ($cek_email == 0){
            $this->session->set_flashdata('gagal','Mohon maaf<br>Email anda belum terdaftar<br>mohon periksa kembali email anda<br>terimakasih');
            redirect('dashboard/forgot');
         
        }else {            
            //enkripsi id email untuk validasi akun via email
            $encrypted_id = md5($email);
            
            $config = array();
            $config['charset'] = 'utf-8';
            $config['useragent'] = 'Codeigniter';
            $config['protocol']= "smtp";
            $config['mailtype']= "html";
            $config['smtp_host']= "fgsgroup.com";//pengaturan smtp
            $config['smtp_port']= "587";
            $config['smtp_timeout']= "400";
            $config['smtp_user']= "agus@fgsgroup.com"; // isi dengan email kamu
            $config['smtp_pass']= "Gkbi123.agus"; // isi dengan password kamu
            $config['crlf']="\r\n"; 
            $config['newline']="\r\n"; 
            $config['wordwrap'] = TRUE;
            //memanggil library email dan set konfigurasi untuk pengiriman email
                
            $this->email->initialize($config);
            //konfigurasi pengiriman
            $this->email->from($config['smtp_user']);
            $this->email->to($email);
            $this->email->subject("Reset Password E-Auction");
            $this->email->message(
                "<h1>E-Auction</h1> Terimakasih telah melakukan reset password, untuk mereset password anda silahkan klik tautan dibawah ini<br><br>".
                site_url("dashboard/reset_password/$encrypted_id")
            );
            
            if($this->email->send())
            {
                $this->session->set_flashdata('success','Reset Password Berhasil<br>silahkan cek email anda<br>untuk mereset password Akun<br>Terimakasih');
                redirect('dashboard');
            }else
            {
                //echo "Berhasil melakukan registrasi, namu gagal mengirim verifikasi email";
                show_error($this->email->print_debugger());
                //$this->session->set_flashdata('gagal','Berhasil melakukan registrasi<br>namun gagal mengirim verifikasi email');
                //redirect('home/daftar');
            }
        } 
    }

    public function reset_password()
    {
        $cek = $this->uri->segment(3);
        if($cek == '')
        {
            $this->load->view('dashboard/login');
        }else{
            $this->load->view('dashboard/reset');    
        }
        
    }

    public function proses_reset()
    {
        $email    = $this->input->post('email');
        $password = MD5($this->input->post('password'));
        $this->M_dashboard->reset($email, $password);
        $this->session->set_flashdata('success','Reset Password Berhasil<br>silahkan login kembali<br>Terimakasih');
        redirect('dashboard');
    }

    public function logout_pelelang(){
        $this->session->sess_destroy();
        redirect('dashboard');
    }

    public function logout_administrator(){
        $this->session->sess_destroy();
        redirect('dashboard/admin');
    }

    public function logout_admin(){
        $this->session->sess_destroy();
        redirect('dashboard/admin');
    }

    public function profile_pelelang()
    {
        $id = $this->session->userdata('id_user');
        $data['record'] = $this->M_dashboard->profile_pelelang($id)->row_array();
        $this->template->load('template_back','dashboard/admin/profile_pelelang',$data);
    }

    public function update_pelelang()
    {  
        $user       = $this->session->userdata('id_user');

        $data = array(
            'nama_lengkap'  => $this->input->post('nama_lengkap'),
            'email'         => $this->input->post('email'),
            'nik_ktp'       => $this->input->post('nik_ktp'),
            'alamat'        => $this->input->post('alamat'),
            'telpon'        => $this->input->post('telpon'),
        );

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

        $this->M_dashboard->update_pelelang($data, $user);
        $this->session->set_flashdata('sukses','Data Pelelang Berhasil Di update');
        redirect('dashboard/profile_pelelang');
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
}
